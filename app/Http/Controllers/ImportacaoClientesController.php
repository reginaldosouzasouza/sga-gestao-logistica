<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ImportacaoClientesController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $empresas = collect();

        if ($user && strtoupper($user->tipo ?? '') === 'MASTER') {
           
            $empresas = DB::table('empresas')
                ->select('id', 'nome_fantasia')
                ->orderBy('nome_fantasia')
                ->get();
        }

        return view('clientes.importar', compact('empresas'));
    }

    public function importar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'arquivo' => ['required', 'file', 'mimes:csv,txt'],
            'empresa_id' => ['nullable', 'integer'],
        ]);

        $empresaId = strtoupper($user->tipo ?? '') === 'MASTER'
            ? (int) $request->empresa_id
            : (int) $user->empresa_id;

        if (!$empresaId) {
            return back()->withErrors([
                'empresa_id' => 'Empresa de destino não informada.',
            ]);
        }

        $empresaExiste = DB::table('empresas')->where('id', $empresaId)->exists();

        if (!$empresaExiste) {
            return back()->withErrors([
                'empresa_id' => 'Empresa de destino não encontrada.',
            ]);
        }

        $arquivo = $request->file('arquivo')->getRealPath();

        $handle = fopen($arquivo, 'r');

        if (!$handle) {
            return back()->withErrors([
                'arquivo' => 'Não foi possível abrir o arquivo enviado.',
            ]);
        }

        $primeiraLinha = fgets($handle);
        rewind($handle);

        $delimitador = $this->detectarDelimitador($primeiraLinha);

        $cabecalho = fgetcsv($handle, 0, $delimitador);

        if (!$cabecalho) {
            fclose($handle);

            return back()->withErrors([
                'arquivo' => 'O arquivo está vazio ou sem cabeçalho.',
            ]);
        }

        $cabecalho = array_map(function ($campo) {
            return $this->normalizarCabecalho($campo);
        }, $cabecalho);

        $importados = 0;
        $atualizados = 0;
        $ignorados = 0;
        $erros = [];

        DB::beginTransaction();

        try {
            $linhaNumero = 1;

            while (($linha = fgetcsv($handle, 0, $delimitador)) !== false) {
                $linhaNumero++;

                if ($this->linhaVazia($linha)) {
                    continue;
                }

                $dados = [];

                foreach ($cabecalho as $indice => $campo) {
                    $dados[$campo] = isset($linha[$indice])
                        ? $this->limparValor($linha[$indice])
                        : null;
                }

                $nome = $dados['nome'] ?? null;

                if (!$nome) {
                    $ignorados++;
                    $erros[] = "Linha {$linhaNumero}: ignorada porque está sem nome.";
                    continue;
                }

                $cliente = [
                    'empresa_id'  => $empresaId,
                    'telefone'    => $dados['telefone'] ?? null,
                    'cpf'         => $dados['cpf'] ?? null,
                    'nome'        => $nome,
                    'endereco'    => $dados['endereco'] ?? null,
                    'numero'      => $dados['numero'] ?? null,
                    'bairro'      => $dados['bairro'] ?? null,
                    'cidade'      => $dados['cidade'] ?? null,
                    'email'       => $dados['email'] ?? null,
                    'nascimento'  => $this->formatarData($dados['nascimento'] ?? null),
                    'observacao'  => $dados['observacao'] ?? null,
                    'updated_at'  => now(),
                ];

                $query = DB::table('clientes')->where('empresa_id', $empresaId);

                if (!empty($cliente['telefone'])) {
                    $query->where('telefone', $cliente['telefone']);
                } elseif (!empty($cliente['cpf'])) {
                    $query->where('cpf', $cliente['cpf']);
                } else {
                    $query = null;
                }

                $clienteExistente = $query ? $query->first() : null;

                if ($clienteExistente) {
                    DB::table('clientes')
                        ->where('id', $clienteExistente->id)
                        ->update($cliente);

                    $atualizados++;
                } else {
                    $cliente['created_at'] = now();

                    DB::table('clientes')->insert($cliente);

                    $importados++;
                }
            }

            fclose($handle);

            DB::commit();

            return redirect()
                ->route('clientes.importar')
                ->with('success', 'Importação concluída.')
                ->with('resultado_importacao', [
                    'importados' => $importados,
                    'atualizados' => $atualizados,
                    'ignorados' => $ignorados,
                    'erros' => $erros,
                ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            if (is_resource($handle)) {
                fclose($handle);
            }

            return back()->withErrors([
                'arquivo' => 'Erro ao importar clientes: ' . $e->getMessage(),
            ]);
        }
    }

    private function detectarDelimitador(?string $linha): string
    {
        if (!$linha) {
            return ';';
        }

        $pontoVirgula = substr_count($linha, ';');
        $virgula = substr_count($linha, ',');

        return $pontoVirgula >= $virgula ? ';' : ',';
    }

    private function normalizarCabecalho(?string $campo): string
    {
        $campo = trim((string) $campo);
        $campo = preg_replace('/^\xEF\xBB\xBF/', '', $campo);
        $campo = mb_strtolower($campo, 'UTF-8');

        $mapa = [
            'código' => 'codigo',
            'cod' => 'codigo',
            'endereço' => 'endereco',
            'observação' => 'observacao',
            'data nascimento' => 'nascimento',
            'data_nascimento' => 'nascimento',
            'aniversario' => 'nascimento',
            'aniversário' => 'nascimento',
            'e-mail' => 'email',
        ];

        return $mapa[$campo] ?? str_replace(' ', '_', $campo);
    }

    private function linhaVazia(array $linha): bool
    {
        foreach ($linha as $valor) {
            if (trim((string) $valor) !== '') {
                return false;
            }
        }

        return true;
    }

    private function limparValor(?string $valor): ?string
    {
        if ($valor === null) {
            return null;
        }

        $valor = trim(str_replace('"', '', $valor));

        if ($valor === '') {
            return null;
        }

        /*
         * Muitos arquivos CSV gerados pelo Excel no Windows vêm em ANSI/Windows-1252.
         * Sem esta conversão, acentos como Á, É, Ç, Ã e Õ podem quebrar no MySQL UTF-8.
         */
        if (!mb_check_encoding($valor, 'UTF-8')) {
            $valor = mb_convert_encoding($valor, 'UTF-8', 'Windows-1252');
        }

        return $valor;
    }

    private function formatarData(?string $data): ?string
    {
        if (!$data) {
            return null;
        }

        $data = trim($data);

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $data)) {
            return $data;
        }

        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $data)) {
            [$dia, $mes, $ano] = explode('/', $data);
            return "{$ano}-{$mes}-{$dia}";
        }

        return null;
    }
}