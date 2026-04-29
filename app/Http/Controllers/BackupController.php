<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use Illuminate\Support\Facades\Auth;

class BackupController extends Controller
{
    public function index()
    {
        $this->verificarPermissaoBackup();

        $backups = Backup::with('usuario')
            ->orderBy('data_geracao', 'desc')
            ->get();

        return view('backups.index', compact('backups'));
    }

    public function gerar()
        {
            $this->verificarPermissaoBackup();

            $usuario = Auth::user();  

        $banco  = env('DB_DATABASE');  
        $host   = env('DB_HOST', '127.0.0.1');  
        $porta  = env('DB_PORT', 3306);  
        $dbUser = env('DB_USERNAME');  
        $dbPass = env('DB_PASSWORD');  

        $data = now()->format('Y_m_d_His');  
        $nomeArquivo = "backup_{$banco}_{$data}.sql";  

        $pastaBackup = storage_path('app/backups');  

        if (!is_dir($pastaBackup)) {  
            mkdir($pastaBackup, 0775, true);  
        }  

        $caminhoCompleto = $pastaBackup . DIRECTORY_SEPARATOR . $nomeArquivo;  

        $mysqldump = $this->getMysqlDumpPath();  

        $comando = "\"{$mysqldump}\" --host={$host} --port={$porta} --user={$dbUser} --password={$dbPass} --databases {$banco} > \"{$caminhoCompleto}\" 2>&1";  

        $output = [];  
        $retorno = null;  

        exec($comando, $output, $retorno);  

        if ($retorno !== 0 || !file_exists($caminhoCompleto)) {  
            return back()->with('erro', 'Erro ao gerar backup');  
        }  

        Backup::create([  
            'nome_arquivo' => $nomeArquivo,  
            'caminho_arquivo' => $caminhoCompleto,  
            'tamanho_bytes' => filesize($caminhoCompleto),  
            'tipo_backup' => 'COMPLETO',  
            'gerado_por' => $usuario->id,  
            'data_geracao' => now(),  
            'status' => 'GERADO',  
            'observacao' => null,  
        ]);  

        return back()->with('sucesso', 'Backup gerado com sucesso');  
        }




    public function download($id)
    {
        $this->verificarPermissaoBackup();

        $backup = Backup::findOrFail($id);

        if (!file_exists($backup->caminho_arquivo)) {
            return back()->with('erro', 'Arquivo de backup não encontrado.');
        }

        return response()->download($backup->caminho_arquivo, $backup->nome_arquivo);
    }

    private function verificarPermissaoBackup()
    {
        $usuario = Auth::user();

        if (!$usuario || !in_array($usuario->tipo, ['MASTER', 'ADMIN'])) {
            abort(403, 'Sem permissão para acessar backup.');
        }
    }

    private function getMysqlDumpPath()
        {
        return 'C:\Program Files\MySQL\MySQL Server 8.4\bin\mysqldump.exe';
        }

    public function restaurar($id)
        {
            $usuario = Auth::user();

            if (!$usuario || $usuario->tipo !== 'MASTER') {
                abort(403, 'Sem permissão');
            }

            $backup = Backup::findOrFail($id);

            if (!file_exists($backup->caminho_arquivo)) {
                return back()->with('erro', 'Arquivo não encontrado');
            }

            $banco  = env('DB_DATABASE');
            $host   = env('DB_HOST', '127.0.0.1');
            $porta  = env('DB_PORT', 3306);
            $dbUser = env('DB_USERNAME');
            $dbPass = env('DB_PASSWORD');

            $mysql = 'C:\\Program Files\\MySQL\\MySQL Server 8.4\\bin\\mysql.exe';

            $comando = "\"{$mysql}\" --host={$host} --port={$porta} --user={$dbUser} --password={$dbPass} {$banco} < \"{$backup->caminho_arquivo}\" 2>&1";

            $output = [];
            $retorno = null;

            exec($comando, $output, $retorno);

            if ($retorno !== 0) {
                return back()->with('erro', 'Erro ao restaurar backup');
            }

            return back()->with('sucesso', 'Backup restaurado com sucesso');
        }


}