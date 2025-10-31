<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ContasAReceber; // Certifique-se de que o nome do modelo está correto
use Carbon\Carbon;

class AtualizarStatusContasAReceber extends Command
{
    protected $signature = 'contas_a_receber:atualizar-status';

    protected $description = 'Atualiza o status das contas a receber para "atrasado" se a data de vencimento já passou';

    public function handle()
    {
        $hoje = Carbon::today();

        // Seleciona as contas que estão pendentes e já venceram
        $contasPendentes = ContasAReceber::where('status', 'pendente')
            ->where('data_vencimento', '<', $hoje)
            ->update(['status' => 'atrasado']);

        if ($contasPendentes) {
            $this->info('Status das contas a receber atualizado para "atrasado".');
        } else {
            $this->info('Nenhuma conta pendente para atualizar.');
        }
    }
}
