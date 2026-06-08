<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class ClonarEmpresaDemo extends Command
{
    protected $signature = 'empresa:clonar-demo 
                            {origem : ID da empresa origem}
                            {destino : ID da empresa destino}
                            {--limpar-destino : Apaga os dados atuais da empresa destino antes de clonar}
                            {--force : Executa sem pedir confirmação}';

    protected $description = 'Clona os dados de uma empresa para outra, ajustando empresa_id e relacionamentos principais.';

    public function handle()
    {
        $empresaOrigem = (int) $this->argument('origem');
        $empresaDestino = (int) $this->argument('destino');

        if ($empresaOrigem <= 0 || $empresaDestino <= 0) {
            $this->error('Informe IDs válidos para origem e destino.');
            return Command::FAILURE;
        }

        if ($empresaOrigem === $empresaDestino) {
            $this->error('A empresa origem e destino não podem ser iguais.');
            return Command::FAILURE;
        }

        $origem = DB::table('empresas')->where('id', $empresaOrigem)->first();
        $destino = DB::table('empresas')->where('id', $empresaDestino)->first();

        if (!$origem) {
            $this->error("Empresa origem {$empresaOrigem} não encontrada.");
            return Command::FAILURE;
        }

        if (!$destino) {
            $this->error("Empresa destino {$empresaDestino} não encontrada.");
            return Command::FAILURE;
        }

        $this->info('Origem:  ' . $origem->id . ' - ' . ($origem->nome_fantasia ?? $origem->razao_social ?? ''));
        $this->info('Destino: ' . $destino->id . ' - ' . ($destino->nome_fantasia ?? $destino->razao_social ?? ''));

        if (!$this->option('force')) {
            $this->warn('ATENÇÃO: faça backup do banco antes de continuar.');
            $this->warn('Este comando vai copiar dados reais da empresa origem para a empresa destino.');

            if (!$this->confirm('Deseja continuar?')) {
                $this->info('Operação cancelada.');
                return Command::SUCCESS;
            }
        }

        try {
            DB::transaction(function () use ($empresaOrigem, $empresaDestino) {

                if ($this->option('limpar-destino')) {
                    $this->limparEmpresaDestino($empresaDestino);
                }

                $clienteMap = [];
                $fornecedorMap = [];
                $produtoMap = [];
                $compraMap = [];
                $contaPagarMap = [];
                $contaReceberMap = [];
                $movimentacaoMap = [];

                $this->info('Clonando clientes...');
                $clienteMap = $this->clonarTabelaSimples('clientes', $empresaOrigem, $empresaDestino);

                $this->info('Clonando fornecedores...');
                $fornecedorMap = $this->clonarFornecedores($empresaOrigem, $empresaDestino);

                $this->info('Clonando produtos...');
                $produtoMap = $this->clonarTabelaSimples('produtos', $empresaOrigem, $empresaDestino);

                $this->info('Clonando compras...');
                $compraMap = $this->clonarCompras($empresaOrigem, $empresaDestino, $fornecedorMap);

                $this->info('Clonando itens de compras...');
                $this->clonarItensDeCompras($empresaOrigem, $empresaDestino, $compraMap, $produtoMap);

                $this->info('Clonando contas a pagar...');
                $contaPagarMap = $this->clonarContasAPagar($empresaOrigem, $empresaDestino, $fornecedorMap, $compraMap);

                $this->info('Clonando contas a receber...');
                $contaReceberMap = $this->clonarContasAReceber($empresaOrigem, $empresaDestino, $clienteMap);

                $this->info('Clonando movimentações...');
                $movimentacaoMap = $this->clonarMovimentacoes(
                    $empresaOrigem,
                    $empresaDestino,
                    $clienteMap,
                    $contaPagarMap,
                    $contaReceberMap,
                    $compraMap
                );

                $this->info('Clonando itens das movimentações...');
                $this->clonarMovimentacaoItens($empresaOrigem, $empresaDestino, $movimentacaoMap, $produtoMap);

                $this->info('Clonando estoques...');
                $this->clonarEstoques($empresaOrigem, $empresaDestino, $produtoMap);

                $this->info('Clonando caixa...');
                $this->clonarCaixaOuBanco(
                    'caixa',
                    $empresaOrigem,
                    $empresaDestino,
                    $contaPagarMap,
                    $contaReceberMap,
                    $compraMap,
                    $movimentacaoMap
                );

                $this->info('Clonando caixa banco...');
                $this->clonarCaixaOuBanco(
                    'caixa_banco',
                    $empresaOrigem,
                    $empresaDestino,
                    $contaPagarMap,
                    $contaReceberMap,
                    $compraMap,
                    $movimentacaoMap
                );
            });

            $this->newLine();
            $this->info('Clone concluído com sucesso!');
            $this->info("Empresa origem: {$empresaOrigem}");
            $this->info("Empresa destino: {$empresaDestino}");

            return Command::SUCCESS;

        } catch (Throwable $e) {
            $this->error('Erro ao clonar empresa: ' . $e->getMessage());
            $this->error('Linha: ' . $e->getLine());
            $this->error('Arquivo: ' . $e->getFile());

            return Command::FAILURE;
        }
    }

    private function limparEmpresaDestino(int $empresaDestino): void
    {
        $this->warn("Limpando dados atuais da empresa destino {$empresaDestino}...");

        $ordem = [
            'movimentacao_itens',
            'itens_de_compras',
            'estoques',
            'caixa',
            'caixa_banco',
            'contas_a_receber',
            'contas_a_pagar',
            'movimentacao',
            'compras',
            'produtos',
            'fornecedores',
            'clientes',
        ];

        foreach ($ordem as $tabela) {
            if (Schema::hasTable($tabela) && Schema::hasColumn($tabela, 'empresa_id')) {
                DB::table($tabela)->where('empresa_id', $empresaDestino)->delete();
            }
        }
    }

    private function clonarTabelaSimples(string $tabela, int $origem, int $destino): array
    {
        $mapa = [];

        if (!Schema::hasTable($tabela)) {
            $this->warn("Tabela {$tabela} não existe. Pulando...");
            return $mapa;
        }

        $registros = DB::table($tabela)
            ->where('empresa_id', $origem)
            ->orderBy('id')
            ->get();

        foreach ($registros as $registro) {
            $dados = (array) $registro;
            $idAntigo = $dados['id'];

            unset($dados['id']);
            $dados['empresa_id'] = $destino;

            $novoId = DB::table($tabela)->insertGetId($dados);
            $mapa[$idAntigo] = $novoId;
        }

        $this->line("  {$tabela}: " . count($mapa) . ' registros copiados.');

        return $mapa;
    }

    private function clonarFornecedores(int $origem, int $destino): array
    {
        $mapa = [];

        $registros = DB::table('fornecedores')
            ->where('empresa_id', $origem)
            ->orderBy('id')
            ->get();

        foreach ($registros as $registro) {
            $dados = (array) $registro;
            $idAntigo = $dados['id'];

            unset($dados['id']);
            $dados['empresa_id'] = $destino;

            try {
                $novoId = DB::table('fornecedores')->insertGetId($dados);
            } catch (Throwable $e) {
                if (isset($dados['cnpj'])) {
                    $dados['cnpj'] = null;
                    $novoId = DB::table('fornecedores')->insertGetId($dados);
                    $this->warn("  Fornecedor ID antigo {$idAntigo}: CNPJ duplicado. Copiado com CNPJ vazio.");
                } else {
                    throw $e;
                }
            }

            $mapa[$idAntigo] = $novoId;
        }

        $this->line('  fornecedores: ' . count($mapa) . ' registros copiados.');

        return $mapa;
    }

    private function clonarCompras(int $origem, int $destino, array $fornecedorMap): array
    {
        $mapa = [];

        $registros = DB::table('compras')
            ->where('empresa_id', $origem)
            ->orderBy('id')
            ->get();

        foreach ($registros as $registro) {
            $dados = (array) $registro;
            $idAntigo = $dados['id'];

            unset($dados['id']);
            $dados['empresa_id'] = $destino;

            if (isset($dados['fornecedor_id']) && $dados['fornecedor_id']) {
                $dados['fornecedor_id'] = $fornecedorMap[$dados['fornecedor_id']] ?? $dados['fornecedor_id'];
            }

            $novoId = DB::table('compras')->insertGetId($dados);
            $mapa[$idAntigo] = $novoId;
        }

        $this->line('  compras: ' . count($mapa) . ' registros copiados.');

        return $mapa;
    }

    private function clonarItensDeCompras(int $origem, int $destino, array $compraMap, array $produtoMap): void
    {
        if (!Schema::hasTable('itens_de_compras')) {
            $this->warn('Tabela itens_de_compras não existe. Pulando...');
            return;
        }

        $comprasOrigem = array_keys($compraMap);

        if (empty($comprasOrigem)) {
            $this->line('  itens_de_compras: 0 registros copiados.');
            return;
        }

        $registros = DB::table('itens_de_compras')
            ->whereIn('compra_id', $comprasOrigem)
            ->orderBy('id')
            ->get();

        $total = 0;

        foreach ($registros as $registro) {
            $dados = (array) $registro;

            unset($dados['id']);

            if (isset($dados['compra_id'])) {
                $dados['compra_id'] = $compraMap[$dados['compra_id']] ?? $dados['compra_id'];
            }

            if (isset($dados['produto_id'])) {
                $dados['produto_id'] = $produtoMap[$dados['produto_id']] ?? $dados['produto_id'];
            }

            if (Schema::hasColumn('itens_de_compras', 'empresa_id')) {
                $dados['empresa_id'] = $destino;
            }

            DB::table('itens_de_compras')->insert($dados);
            $total++;
        }

        $this->line("  itens_de_compras: {$total} registros copiados.");
    }

    private function clonarContasAPagar(int $origem, int $destino, array $fornecedorMap, array $compraMap): array
    {
        $mapa = [];

        $registros = DB::table('contas_a_pagar')
            ->where('empresa_id', $origem)
            ->orderBy('id')
            ->get();

        foreach ($registros as $registro) {
            $dados = (array) $registro;
            $idAntigo = $dados['id'];

            unset($dados['id']);
            $dados['empresa_id'] = $destino;

            if (isset($dados['fornecedor_id']) && $dados['fornecedor_id']) {
                $dados['fornecedor_id'] = $fornecedorMap[$dados['fornecedor_id']] ?? $dados['fornecedor_id'];
            }

            if (isset($dados['compra_id']) && $dados['compra_id']) {
                $dados['compra_id'] = $compraMap[$dados['compra_id']] ?? $dados['compra_id'];
            }

            $novoId = DB::table('contas_a_pagar')->insertGetId($dados);
            $mapa[$idAntigo] = $novoId;
        }

        $this->line('  contas_a_pagar: ' . count($mapa) . ' registros copiados.');

        return $mapa;
    }

    private function clonarContasAReceber(int $origem, int $destino, array $clienteMap): array
    {
        $mapa = [];

        $registros = DB::table('contas_a_receber')
            ->where('empresa_id', $origem)
            ->orderBy('id')
            ->get();

        foreach ($registros as $registro) {
            $dados = (array) $registro;
            $idAntigo = $dados['id'];

            unset($dados['id']);
            $dados['empresa_id'] = $destino;

            if (isset($dados['cliente_id']) && $dados['cliente_id']) {
                $dados['cliente_id'] = $clienteMap[$dados['cliente_id']] ?? $dados['cliente_id'];
            }

            $novoId = DB::table('contas_a_receber')->insertGetId($dados);
            $mapa[$idAntigo] = $novoId;
        }

        $this->line('  contas_a_receber: ' . count($mapa) . ' registros copiados.');

        return $mapa;
    }

    private function clonarMovimentacoes(
        int $origem,
        int $destino,
        array $clienteMap,
        array $contaPagarMap,
        array $contaReceberMap,
        array $compraMap
    ): array {
        $mapa = [];

        $registros = DB::table('movimentacao')
            ->where('empresa_id', $origem)
            ->orderBy('id')
            ->get();

        foreach ($registros as $registro) {
            $dados = (array) $registro;
            $idAntigo = $dados['id'];

            unset($dados['id']);
            $dados['empresa_id'] = $destino;

            if (isset($dados['cliente_id']) && $dados['cliente_id']) {
                $dados['cliente_id'] = $clienteMap[$dados['cliente_id']] ?? $dados['cliente_id'];
            }

            if (isset($dados['origem_id']) && $dados['origem_id'] && isset($dados['origem_tipo'])) {
                $dados['origem_id'] = $this->mapearReferenciaPorOrigem(
                    $dados['origem_tipo'],
                    $dados['origem_id'],
                    $contaPagarMap,
                    $contaReceberMap,
                    $compraMap,
                    $mapa
                );
            }

            $novoId = DB::table('movimentacao')->insertGetId($dados);
            $mapa[$idAntigo] = $novoId;
        }

        $this->line('  movimentacao: ' . count($mapa) . ' registros copiados.');

        return $mapa;
    }

    private function clonarMovimentacaoItens(int $origem, int $destino, array $movimentacaoMap, array $produtoMap): void
    {
        $movimentacoesOrigem = array_keys($movimentacaoMap);

        if (empty($movimentacoesOrigem)) {
            $this->line('  movimentacao_itens: 0 registros copiados.');
            return;
        }

        $registros = DB::table('movimentacao_itens')
            ->where('empresa_id', $origem)
            ->whereIn('movimentacao_id', $movimentacoesOrigem)
            ->orderBy('id')
            ->get();

        $total = 0;

        foreach ($registros as $registro) {
            $dados = (array) $registro;

            unset($dados['id']);
            $dados['empresa_id'] = $destino;

            if (isset($dados['movimentacao_id'])) {
                $dados['movimentacao_id'] = $movimentacaoMap[$dados['movimentacao_id']] ?? $dados['movimentacao_id'];
            }

            if (isset($dados['produto_id'])) {
                $dados['produto_id'] = $produtoMap[$dados['produto_id']] ?? $dados['produto_id'];
            }

            DB::table('movimentacao_itens')->insert($dados);
            $total++;
        }

        $this->line("  movimentacao_itens: {$total} registros copiados.");
    }

    private function clonarEstoques(int $origem, int $destino, array $produtoMap): void
    {
        if (!Schema::hasTable('estoques')) {
            $this->warn('Tabela estoques não existe. Pulando...');
            return;
        }

        $registros = DB::table('estoques')
            ->where('empresa_id', $origem)
            ->orderBy('id')
            ->get();

        $total = 0;

        foreach ($registros as $registro) {
            $dados = (array) $registro;

            unset($dados['id']);
            $dados['empresa_id'] = $destino;

            if (isset($dados['produto_id'])) {
                $dados['produto_id'] = $produtoMap[$dados['produto_id']] ?? $dados['produto_id'];
            }

            DB::table('estoques')->insert($dados);
            $total++;
        }

        $this->line("  estoques: {$total} registros copiados.");
    }

    private function clonarCaixaOuBanco(
        string $tabela,
        int $origem,
        int $destino,
        array $contaPagarMap,
        array $contaReceberMap,
        array $compraMap,
        array $movimentacaoMap
    ): void {
        if (!Schema::hasTable($tabela)) {
            $this->warn("Tabela {$tabela} não existe. Pulando...");
            return;
        }

        $registros = DB::table($tabela)
            ->where('empresa_id', $origem)
            ->orderBy('id')
            ->get();

        $total = 0;

        foreach ($registros as $registro) {
            $dados = (array) $registro;

            unset($dados['id']);
            $dados['empresa_id'] = $destino;

            if (isset($dados['referencia_id']) && $dados['referencia_id'] && isset($dados['origem'])) {
                $dados['referencia_id'] = $this->mapearReferenciaPorOrigem(
                    $dados['origem'],
                    $dados['referencia_id'],
                    $contaPagarMap,
                    $contaReceberMap,
                    $compraMap,
                    $movimentacaoMap
                );
            }

            DB::table($tabela)->insert($dados);
            $total++;
        }

        $this->line("  {$tabela}: {$total} registros copiados.");
    }

    private function mapearReferenciaPorOrigem(
        ?string $origem,
        $referenciaId,
        array $contaPagarMap,
        array $contaReceberMap,
        array $compraMap,
        array $movimentacaoMap
    ) {
        if (!$origem || !$referenciaId) {
            return $referenciaId;
        }

        $origemNormalizada = mb_strtolower($origem);

        if (
            str_contains($origemNormalizada, 'pagar') ||
            str_contains($origemNormalizada, 'conta_pagar') ||
            str_contains($origemNormalizada, 'contas_a_pagar')
        ) {
            return $contaPagarMap[$referenciaId] ?? $referenciaId;
        }

        if (
            str_contains($origemNormalizada, 'receber') ||
            str_contains($origemNormalizada, 'conta_receber') ||
            str_contains($origemNormalizada, 'contas_a_receber')
        ) {
            return $contaReceberMap[$referenciaId] ?? $referenciaId;
        }

        if (str_contains($origemNormalizada, 'compra')) {
            return $compraMap[$referenciaId] ?? $referenciaId;
        }

        if (
            str_contains($origemNormalizada, 'movimentacao') ||
            str_contains($origemNormalizada, 'movimentação') ||
            str_contains($origemNormalizada, 'venda') ||
            str_contains($origemNormalizada, 'pedido')
        ) {
            return $movimentacaoMap[$referenciaId] ?? $referenciaId;
        }

        return $referenciaId;
    }
}