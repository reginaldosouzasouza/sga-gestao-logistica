@if(auth()->user()->temPermissao('backup_visualizar'))
    <a href="{{ route('backups.index') }}" target="_blank">

        Backup do Sistema
    </a>
@endif

<!-- importação de despesas -->
@if(auth()->user()->temPermissao('perfil_administrador_visualizar'))
   <a href="/financeiro/contas-a-pagar/importar-despesas"  target="_blank">
    
        Importação de Despesas
     
    </a>
@endif





<!-- PERFIS DO SISTEMA CONFIGURAÇÃO-->

@if(auth()->user()->temPermissao('perfil_administrador_visualizar'))
   <a href="/perfis/1/permissoes"  target="_blank">
    
        Perfil - Administrador
     
    </a>
@endif

@if(auth()->user()->temPermissao('perfil_gerente_visualizar'))
    <a href="/perfis/2/permissoes"  target="_blank">
        Perfil - Gerente
       
    </a>
@endif

@if(auth()->user()->temPermissao('perfil_operacional_visualizar'))

      <a href="/perfis/3/permissoes" target="_blank">
        Perfil - Operacional
        
    </a>
@endif

@if(auth()->user()->temPermissao('perfil_financeiro_visualizar'))
  <a href="/perfis/4/permissoes"  target="_blank">
        Perfil - Financeiro
      
    </a>
@endif


@if(auth()->user()->temPermissao('backup_visualizar'))
    <a href="/vale-gas" target="_blank">

       Vale GÁS
    </a>
@endif


@if(auth()->user()->temPermissao('backup_visualizar'))
    <a href="https://emissornfe.sebrae.com.br/ " target="_blank">

       Emissão de NF-e
    </a>
@endif