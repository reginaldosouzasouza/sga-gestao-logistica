<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClienteProdutoDuracao;
use App\Models\Movimentacao;
use Carbon\Carbon;

class ImportarDuracaoGas extends Command
{
    protected $signature   = 'gas:importar-duracao {dataInicio} {dataFim}';
    protected $description = 'Importa clientes que compraram gás. Ex: php artisan gas:importar-duracao 2025-08-01 2026-02-17';

    public function handle()
    {
        $dataInicio = $this->argument('dataInicio');
        $dataFim    = $this->argument('dataFim');

        $this->info("Buscando movimentações de {$dataInicio} até {$dataFim}...");

        $movimentacoes = Movimentacao::whereHas('itens', function ($q) {
                $q->where('produto_id', 2);
            })
            ->whereBetween('data_coleta', [$dataInicio, $dataFim])
            ->whereNotNull('cliente_id')
            ->get();

        if ($movimentacoes->isEmpty()) {
            $this->warn('Nenhuma movimentação encontrada no período.');
            return;
        }

        $porCliente = $movimentacoes->groupBy('cliente_id')->map(function ($movs) {
            return $movs->sortByDesc('data_coleta')->first();
        });

        $inseridos = 0;
        $ignorados = 0;

        foreach ($porCliente as $clienteId => $mov) {
            $existe = ClienteProdutoDuracao::where('cliente_id', $clienteId)
                ->where('produto_id', 2)
                ->exists();

            if ($existe) {
                $ignorados++;
                continue;
            }

            ClienteProdutoDuracao::create([
                'cliente_id' => $clienteId,
                'produto_id' => 2,
                'duracao'    => 50,
            ]);
            $inseridos++;
        }

        $this->info("✅ Inseridos: {$inseridos}");
        $this->info("⏭️  Ignorados (já existiam): {$ignorados}");
    }
}