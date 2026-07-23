@php
    $user = auth()->user();

    /*
     * MASTER vê tudo.
     * Os demais usuários obedecem ao perfil/permissões.
     */
    $isMaster = $user && strtoupper(trim($user->tipo ?? '')) === 'MASTER';

    /*
     * Usuários
     */
    $podeVerUsuarios =
        $isMaster ||
        ($user && $user->temPermissao('usuario_visualizar'));

    $podeCadastrarUsuarios =
        $isMaster ||
        ($user && $user->temPermissao('usuario_cadastrar'));

    /*
     * Perfis e permissões
     */
    $podeVerPerfis =
        $isMaster ||
        ($user && $user->temPermissao('perfil_visualizar'));

    $podeEditarPerfis =
        $isMaster ||
        ($user && $user->temPermissao('perfil_editar'));

    /*
     * Empresas
     */
    $podeVerEmpresas =
        $isMaster ||
        ($user && $user->temPermissao('empresa_visualizar'));

    /*
     * Importação de Despesas
     */
    $podeVerImportacaoDespesas =
        $isMaster ||
        ($user && $user->temPermissao('importacao_despesas_visualizar')) ||
        ($user && $user->temPermissao('importacao_despesas_importar'));

    /*
     * Backup do Sistema
     */
    $podeVerBackup =
        $isMaster ||
        ($user && $user->temPermissao('backup_visualizar')) ||
        ($user && $user->temPermissao('backup_gerar')) ||
        ($user && $user->temPermissao('backup_excluir'));

    /*
     * Emissão de NF-e
     */
    $podeVerEmissaoNfe =
        $isMaster ||
        ($user && $user->temPermissao('nfe_visualizar'));
@endphp


{{-- Usuários --}}
@if($podeVerUsuarios || $podeCadastrarUsuarios || $isMaster)
    <a
        href="#"
        class="menu-link"
        id="config-usuarios-link"
    >
        Usuários

        <i
            class="bi bi-caret-right-fill"
            style="margin-left:auto"
        ></i>
    </a>

    <div
        class="dropdown-submenu"
        id="config-usuarios-submenu"
    >
        @if($podeCadastrarUsuarios)
            <a
                href="{{ url('/usuarios/create') }}"
                target="_blank"
                rel="noopener noreferrer"
            >
                Cadastrar Usuário
            </a>
        @endif

        @if($podeVerUsuarios)
            <a
                href="{{ url('/usuarios') }}"
                target="_blank"
                rel="noopener noreferrer"
            >
                Gerenciar Usuários
            </a>
        @endif

        @if($isMaster)
            <a
                href="{{ route('usuarios.monitor-acessos') }}"
                target="_blank"
                rel="noopener noreferrer"
            >
                Monitor de Acessos
            </a>
        @endif
    </div>
@endif


{{-- Perfis do Sistema --}}
@if($podeVerPerfis || $podeEditarPerfis)
    <a
        href="#"
        class="menu-link"
        id="config-perfis-link"
    >
        Perfis do Sistema

        <i
            class="bi bi-caret-right-fill"
            style="margin-left:auto"
        ></i>
    </a>

    <div
        class="dropdown-submenu"
        id="config-perfis-submenu"
    >
        @if($podeVerPerfis)
            <a
                href="{{ url('/perfis') }}"
                target="_blank"
                rel="noopener noreferrer"
            >
                Listar Perfis
            </a>
        @endif

        @if($podeEditarPerfis)
            <a
                href="{{ url('/perfis/1/permissoes') }}"
                target="_blank"
                rel="noopener noreferrer"
            >
                Perfil - Administrador
            </a>

            <a
                href="{{ url('/perfis/2/permissoes') }}"
                target="_blank"
                rel="noopener noreferrer"
            >
                Perfil - Gerente
            </a>

            <a
                href="{{ url('/perfis/3/permissoes') }}"
                target="_blank"
                rel="noopener noreferrer"
            >
                Perfil - Operacional
            </a>

            <a
                href="{{ url('/perfis/4/permissoes') }}"
                target="_blank"
                rel="noopener noreferrer"
            >
                Perfil - Financeiro
            </a>

            <a
                href="{{ route('perfis.administrador-salao') }}"
                target="_blank"
                rel="noopener noreferrer"
            >
                Perfil - Administrador do Salão
            </a>
        @endif
    </div>
@endif


{{-- Cadastro de Empresas --}}
@if($podeVerEmpresas)
    <a
        href="{{ url('/empresas') }}"
        target="_blank"
        rel="noopener noreferrer"
    >
        Cadastro de Empresas
    </a>
@endif


{{-- Importação de Clientes - Somente MASTER --}}
@if($isMaster)
    <a
        href="{{ route('clientes.importar') }}"
        target="_blank"
        rel="noopener noreferrer"
    >
        Importação de Clientes
    </a>
@endif


{{-- Importação de Despesas --}}
@if($podeVerImportacaoDespesas)
    <a
        href="{{ url('/financeiro/contas-a-pagar/importar-despesas') }}"
        target="_blank"
        rel="noopener noreferrer"
    >
        Importação de Despesas
    </a>
@endif


{{-- Backup do Sistema --}}
@if($podeVerBackup)
    <a
        href="{{ route('backups.index') }}"
        target="_blank"
        rel="noopener noreferrer"
    >
        Backup do Sistema
    </a>
@endif


{{-- Emissão de NF-e externa --}}
@if($podeVerEmissaoNfe)
    <a
        href="https://emissornfe.sebrae.com.br/"
        target="_blank"
        rel="noopener noreferrer"
    >
        Emissão de NF-e
    </a>
@endif