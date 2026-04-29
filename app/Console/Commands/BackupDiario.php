<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Backup;

class BackupDiario extends Command
{
    protected $signature = 'backup:diario';
    protected $description = 'Gera backup automático diário';

    public function handle()
    {
        $banco  = env('DB_DATABASE');
        $host   = env('DB_HOST', '127.0.0.1');
        $porta  = env('DB_PORT', 3306);
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');

        $data = now()->format('Y_m_d_His');
        $nomeArquivo = "backup_auto_{$banco}_{$data}.sql";

        $pastaBackup = storage_path('app/backups');

        if (!is_dir($pastaBackup)) {
            mkdir($pastaBackup, 0775, true);
        }

        $caminhoCompleto = $pastaBackup . DIRECTORY_SEPARATOR . $nomeArquivo;

        $mysqldump = 'C:\\Program Files\\MySQL\\MySQL Server 8.4\\bin\\mysqldump.exe';

        $comando = "\"{$mysqldump}\" --host={$host} --port={$porta} --user={$dbUser} --password={$dbPass} --databases {$banco} > \"{$caminhoCompleto}\" 2>&1";

        $output = [];
        $retorno = null;

        exec($comando, $output, $retorno);

       
        if ($retorno === 0 && file_exists($caminhoCompleto)) {
            Backup::create([
                'nome_arquivo'    => $nomeArquivo,
                'caminho_arquivo' => $caminhoCompleto,
                'tamanho_bytes'   => filesize($caminhoCompleto),
                'tipo_backup'     => 'COMPLETO',
                'gerado_por'      => 1,
                'data_geracao'    => now(),
                'status'          => 'GERADO',
                'observacao'      => 'Backup automático',
            ]);


             // Limitar a 30 backups (apagar os mais antigos)
        $limite = 30;

        $total = Backup::count();

        if ($total >= $limite) {
            $antigos = Backup::orderBy('data_geracao', 'asc')
                ->limit($total - $limite + 1)
                ->get();

            foreach ($antigos as $bkp) {
                if (file_exists($bkp->caminho_arquivo)) {
                    unlink($bkp->caminho_arquivo);
                }

                $bkp->delete();
            }
        }

            $this->info('Backup gerado com sucesso');
        } else {
            $this->error('Erro ao gerar backup');
        }
    }
}