<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Os comandos fornecidos pelo aplicativo.
     *
     * @var array
     */
    protected $commands = [
        // Registre os comandos aqui
        Commands\AtualizarStatusContasAReceber::class, // Adicione o novo Command
      
        
    ];

    /**
     * Define a programação das tarefas do aplicativo.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */


    protected function schedule(Schedule $schedule)
    {
        // Comando para atualizar o status das contas a pagar diariamente
        $schedule->command('contas_a_pagar:atualizar-status')->everyMinute();

      // Agendar para rodar a cada minuto
      \Log::info('Agendando o comando de atualização de contas a receber.');
      $schedule->command('contas_a_receber:atualizar-status')->everyMinute();
      $schedule->command('backup:diario')->dailyAt('02:00');
    }

    /**
     * Registra os comandos para o aplicativo.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}


