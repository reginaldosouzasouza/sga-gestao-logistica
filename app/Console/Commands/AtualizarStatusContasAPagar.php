<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ContasAPagar;
use Carbon\Carbon;

class AtualizarStatusContasAPagar extends Command
{
    protected $signature = 'contas_a_pagar:atualizar-status';
    protected $description = 'Atualiza o status das contas a pagar para atrasado, se o vencimento for menor que a data atual';

    public function handle()
    {
        $hoje = Carbon::today();

        ContasAPagar::where('status', 'pendente')
            ->where('data_vencimento', '<', $hoje)
            ->update(['status' => 'atrasado']);

        $this->info('Status das contas a pagar atualizado para "atrasado".');
    }
}
