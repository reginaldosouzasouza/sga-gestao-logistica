@extends('layouts.app')
@section('title', 'Backup do Sistema')
 @section('content') 
<style> 
.backup-page { padding: 30px; background: #f4f6f9; min-height: 100vh; } 
.backup-card { background: #ffffff; border-radius: 16px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08); overflow: hidden; } 
.backup-header { display: flex; justify-content: space-between; align-items: center; padding: 24px 28px; border-bottom: 1px solid #e9ecef; background: #ffffff; } 
.backup-header h2 { margin: 0; font-size: 28px; color: #1f2937; } 
.backup-header p { margin: 6px 0 0; color: #6b7280; font-size: 14px; } 
.backup-body { padding: 24px 28px 30px; } 
.btn-backup { background: #2563eb; color: #fff; border: none; border-radius: 10px; padding: 12px 18px; font-size: 14px; font-weight: 600; cursor: pointer; transition: 0.2s; } 
.btn-backup:hover { background: #1d4ed8; } 
.alert-success-custom, .alert-error-custom { padding: 14px 16px; border-radius: 10px; margin-bottom: 18px; font-size: 14px; } 
.alert-success-custom { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; } 
.alert-error-custom { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; } 
.backup-table { width: 100%; border-collapse: collapse; background: #fff; } 
.backup-table thead th { text-align: left; padding: 14px 12px; background: #f8fafc; color: #374151; font-size: 14px; border-bottom: 1px solid #e5e7eb; } 
.backup-table tbody td { padding: 14px 12px; border-bottom: 1px solid #f1f5f9; color: #111827; font-size: 14px; vertical-align: middle; } 
.backup-table tbody tr:hover { background: #cdcaca; } 
.status-badge { display: inline-block; padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; } 
.status-gerado { background: #dcfce7; color: #166534; } 
.status-erro { background: #fee2e2; color: #991b1b; } 
.actions { display: flex; gap: 8px; flex-wrap: wrap; } 
.btn-download, .btn-restore { display: inline-block; text-decoration: none; padding: 8px 12px; border-radius: 8px; font-size: 13px; font-weight: 600; border: none; cursor: pointer; } 
.btn-download { background: #16a34a; color: #fff; } 
.btn-download:hover { background: #15803d; } 
.btn-restore { background: #dc2626; color: #fff; } 
.btn-restore:hover { background: #b91c1c; } 
.empty-row { text-align: center; color: #6b7280; padding: 28px 12px; } @media (max-width: 768px) { .backup-header { flex-direction: column; align-items: flex-start; gap: 16px; } 
.backup-page { padding: 15px; } 
.backup-body, .backup-header { padding: 18px; } .backup-table { display: block; overflow-x: auto; white-space: nowrap; } } 

</style>



<div class="backup-page">
   <div class="backup-card">
      <div class="backup-header">
         <div>
            <h2>Backup do Sistema</h2>
            <p>Gerencie backups manuais e automáticos do banco de dados.</p>
         </div>
         <form action="{{ route('backups.gerar') }}" method="POST"> @csrf <button type="submit" class="btn-backup">Gerar Backup</button> </form>
      </div>
      <div class="backup-body">
         @if(session('sucesso')) 
         <div class="alert-success-custom"> {{ session('sucesso') }} </div>
         @endif @if(session('erro')) 
         <div class="alert-error-custom"> {{ session('erro') }} </div>
         @endif 
         <table class="backup-table">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Arquivo</th>
                  <th>Data</th>
                  <th>Tamanho</th>
                  <th>Status</th>
                  <th>Gerado por</th>
                  <th>Ações</th>
               </tr>
            </thead>
            <tbody>
               @forelse($backups as $backup) 
               <tr>
                  <td>{{ $backup->id }}</td>
                  <td>{{ $backup->nome_arquivo }}</td>
                  <td>{{ \Carbon\Carbon::parse($backup->data_geracao)->format('d/m/Y H:i:s') }}</td>
                  <td>{{ $backup->tamanho_bytes ? number_format($backup->tamanho_bytes / 1024, 2, ',', '.') . ' KB' : '-' }}</td>
                  <td> @if($backup->status === 'GERADO') <span class="status-badge status-gerado">GERADO</span> @else <span class="status-badge status-erro">ERRO</span> @endif </td>
                  <td>{{ $backup->usuario->usuario ?? '-' }}</td>
                  <td>
                     <div class="actions">
                        <a href="{{ route('backups.download', $backup->id) }}" class="btn-download"> Baixar </a> @if(auth()->user()->tipo === 'MASTER') 
                        <form action="{{ route('backups.restaurar', $backup->id) }}" method="POST" style="display:inline;"> @csrf <button type="submit" class="btn-restore" onclick="return confirm('Tem certeza que deseja restaurar este backup?')"> Restaurar </button> </form>
                        @endif 
                     </div>
                  </td>
               </tr>
               @empty 
               <tr>
                  <td colspan="7" class="empty-row">Nenhum backup encontrado.</td>
               </tr>
               @endforelse 
            </tbody>
         </table>
      </div>
   </div>
</div>
@endsection
