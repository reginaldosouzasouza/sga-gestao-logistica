<?php
//use App\Http\Controllers\ImportacaoDespesasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\FormasDePagamentoController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\MovimentacaoController;
use App\Http\Controllers\MovimentacaoItemController;
use App\Http\Controllers\PedidoColetaController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\ContasAPagarController;
use App\Http\Controllers\ContasAReceberController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CaixaController;
use App\Http\Controllers\CaixaAberturaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\OrdemServicoController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\MecanicoController;
use App\Models\Veiculo;
use App\Http\Controllers\OrdemServicoItemController;
use App\Http\Controllers\Padoca\EncomendaController;
use App\Http\Controllers\ModuleEntryController;
use App\Http\Controllers\SGA\SeletorController;
use App\Http\Controllers\OficinaEntryController;
//use App\Http\Controllers\GasEntryController;
use App\Http\Controllers\GerencialEntryController;
use App\Http\Controllers\PadocaEntryController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\MenuController;
use App\Http\Middleware\CheckMaster;
use App\Http\Controllers\Gerencial\DashboardController as GerencialDashboardController;
use App\Http\Controllers\RelCaixaController;
use App\Http\Controllers\CaixaConsultaController;
use App\Http\Controllers\Controller; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatSuporteController;
use App\Http\Controllers\ClienteProdutoDuracaoController;
use App\Http\Controllers\RelatorioGasController;
use App\Http\Controllers\PerfilController; 
 use App\Http\Controllers\BackupController;
 use App\Http\Controllers\RelatorioComprasController;
 use App\Http\Controllers\ControleVasilhameController;
 use App\Http\Controllers\ValeGasController;
 use App\Http\Controllers\DashboardEmissaoController;
 //use App\Http\Controllers\ImportacaoDespesasMensalController;
 use App\Http\Controllers\DashboardEmissaoInteligenteController;
 use App\Http\Controllers\DashboardFinanceiroController;
 use App\Http\Controllers\Financeiro\ImportacaoDespesaController;
 use App\Http\Controllers\RelatorioVendasEmissaoController;
 use App\Http\Controllers\VasilhameEmprestimoController;
 use App\Http\Controllers\RelatorioNaturezaFinanceiraController;
 use App\Http\Controllers\NaturezaFinanceiraController;


 













//rota para o login

// routes/web.php


Route::get('/login-clean', [LoginController::class, 'showLoginForm'])->name('login.clean');




/*Route::get('/login-clean', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});
*/




// ROTA clientes
Route::resource('clientes', ClienteController::class);
Route::get('/clientes-pesquisar', [ClienteController::class, 'pesquisar'])->name('clientes.pesquisar');
Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
Route::get('/buscar-cliente', [ClienteController::class, 'buscar'])->name('buscar.cliente');

// rota auto complete
Route::get('/autocomplete-produtos', [ProdutoController::class, 'autocomplete'])->name('autocomplete.produtos');


// rota para aldo de estoque relatório
Route::get('/relatorios/saldo-estoque', [ProdutoController::class, 'saldoEstoque'])->name('relatorios.saldoEstoque');


// fornecedores
Route::resource('fornecedores', FornecedorController::class);
Route::resource('produtos', ProdutoController::class);

// RELATÓRIO DE MARGEM DE LUCRO
Route::get('/produtos/relatorio/margem', [ProdutoController::class, 'relatorioMargem'])->name('produtos.relatorio.margem');
Route::post('/fornecedores/importarXML', [FornecedorController::class, 'importarXML'])->name('fornecedores.importarXML');


Route::resource('formas_de_pagamento', FormasDePagamentoController::class);


//ROtas Pedidos de coleta
Route::get('/pedido-coleta/create', [PedidoColetaController::class, 'create'])->name('pedido_coleta.create');


// Rota de Compras não é um resource, então mantemos manualmente
// Rota de Compras
Route::get('/compras/create', [ComprasController::class, 'create'])->name('compras.create');
Route::post('/compras', [ComprasController::class, 'store'])->name('compras.store');
Route::get('/compras', [ComprasController::class, 'index'])->name('compras.index');
Route::get('/compras/search', [ComprasController::class, 'search'])->name('compras.search');
Route::delete('/compras/{id}', [ComprasController::class, 'destroy'])->name('compras.destroy');
Route::get('/compras/{id}/edit', [ComprasController::class, 'edit'])->name('compras.edit'); // Adicionada a rota para edição
Route::put('/compras/{id}', [ComprasController::class, 'update'])->name('compras.update');
Route::post('/compras/importarXML', [ComprasController::class, 'importarXML'])->name('compras.importarXML');



//rotas de Estoques
// Rotas para Estoque
Route::resource('estoques', EstoqueController::class);
Route::get('/estoques/total', [EstoqueController::class, 'totalEstoque'])->name('estoques.total');

//ROTAS PARA CONSULTA ESTOQUE
Route::get('/estoques/consulta', [EstoqueController::class, 'consultaEstoque'])->name('estoques.consulta');

//RELATÓRIO PARA ESTOQUE
Route::get('/relatorio-estoque', [ProdutoController::class, 'relatorioEstoqueAtual'])->name('estoques.relatorio');
Route::get('/produtos/buscar', [ProdutoController::class, 'buscar'])->name('produtos.buscar');


// ROTA MOVIMENTACAO
Route::get('/movimentacao', [MovimentacaoController::class, 'index'])->name('movimentacao.index'); // Listar movimentações
Route::get('/movimentacao/create', [MovimentacaoController::class, 'create'])->name('movimentacao.create'); // Criar movimentação
Route::post('/movimentacao/store', [MovimentacaoController::class, 'store'])->name('movimentacao.store'); // Salvar movimentação
Route::resource('movimentacao', MovimentacaoController::class);
Route::get('/movimentacao/{id}', [MovimentacaoController::class, 'show'])->name('movimentacao.show');

// Adicione esta linha no seu arquivo web.php
Route::get('/movimentacao/pesquisar', [MovimentacaoController::class, 'pesquisar'])->name('movimentacao.pesquisar');






// ROTA MOVIMENTACAO_ITENS
Route::resource('movimentacao-itens', MovimentacaoItemController::class);

/*RELATÓRIO DE COMPRAS
Route::get('/relatorio-compras', [ComprasController::class, 'relatorioCompras'])->name('relatorio.compras');*/


// ── Adicione ao seu routes/web.php ──────────────────────────────────────────



Route::prefix('relatorios')->name('relatorios.')->group(function () {

    // Listagem com filtros
    Route::get('/compras', [RelatorioComprasController::class, 'index'])
         ->name('compras');

    // Export CSV
    Route::get('/compras/export', [RelatorioComprasController::class, 'export'])
         ->name('compras.export');

});

// rota de RELATÓRIO DE vendas 1
Route::get('/relatorios/vendas', [RelatorioController::class, 'vendas'])->name('relatorios.vendas');

// rota relatorio vendas por produto
Route::get('/relatorios/vendas-por-produto', [RelatorioController::class, 'vendasPorProduto'])->name('relatorios.vendasPorProduto');

// rota relatório de saldo de produto
Route::get('/relatorios/saldo_estoque', [RelatorioController::class, 'saldoEstoque'])->name('relatorios.saldoEstoque');




// ROTA VERIFICAR ESTOQUE DO PRODUTO NO MOMENTO DA VENDA
Route::get('/verificar-estoque', [ProdutoController::class, 'verificarEstoque']);




















//rotas financeiro
Route::post('/contas_a_pagar/store', [ContasAPagarController::class, 'store'])->name('contas_a_pagar.store');
Route::resource('contas_a_pagar', ContasAPagarController::class);
Route::get('/contas-a-pagar', [ContasAPagarController::class, 'index'])->name('contas_a_pagar.index');
Route::get('/contas-a-pagar/{id}/edit', [ContasAPagarController::class, 'edit'])->name('contas_a_pagar.edit');
Route::put('/contas-a-pagar/{id}', [ContasAPagarController::class, 'update'])->name('contas_a_pagar.update');
Route::resource('contas-a-pagar', ContasAPagarController::class);

// RELATÓRIO CONTAS A RECEBER

Route::get('/contas_a_receber/exportar', [ContasAReceberController::class, 'exportarCsv'])
    ->name('contas_a_receber.exportar');


Route::get('/contas_a_receber/relatorio', [ContasAReceberController::class, 'relatorio'])
    ->name('contas_a_receber.relatorio');



Route::resource('contas_a_receber', ContasAReceberController::class);
Route::resource('contas-a-receber', ContasAReceberController::class)->names('contas_a_receber');
Route::get('/contas_a_receber/{id}/edit', [ContasAReceberController::class, 'edit'])->name('contas_a_receber.edit');
Route::put('/contas_a_receber/{id}', [ContasAReceberController::class, 'update'])->name('contas_a_receber.update');
Route::delete('/contas_a_receber/{id}', [ContasAReceberController::class, 'destroy'])->name('contas_a_receber.destroy');
Route::get('/movimentacoes', [MovimentacaoController::class, 'index'])->name('movimentacoes.index');

// Rota para atualizar o contas a receber de pendente para atrasado
Route::post('/contas_a_receber/atualizar-status', [ContasAReceberController::class, 'atualizarStatus'])->name('contas_a_receber.atualizar-status');


//ROTAS PARA CÓDIGO DE BARRAS
Route::post('/api/produto/buscar', [ProdutoController::class, 'buscarPorCodigo']);

//RELATÓRIO DE CONTAS A PAGAR
Route::get('/relatorio-contas-a-pagar', [ContasAPagarController::class, 'relatorioContasAPagar'])->name('contas_a_pagar.relatorio');

//ROTAS DOS USERS
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'master'])->group(function () {
    Route::get('/menu.html', function () {
        return view('menu.html');
    })->name('menu');
   
});

/*Route::get('/menu', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }
    return view('menu');
});*/


// ROTA PARA ACESSAR O SISTEMA


/*Route::middleware(['auth'])->group(function () {
    Route::get('/menu', function () {
        return view('menu'); // Certifique-se de que o nome do arquivo é menu.blade.php
    })->name('menu');
});*/

// ROTAS DO CAIXA 
   

    Route::middleware(['auth'])->group(function () {

    // ===============================
    // ABERTURA DE CAIXA
    // ===============================
 // Route::get('/caixa', [CaixaController::class, 'index'])->name('caixa.index');

Route::get('/caixa/abrir', [CaixaController::class, 'abrir']) 
   ->name('caixa.abrir');

   // ===============================
    // ROTA -  RELATÓRIO COMPLETO CAIXA
    // ===============================

Route::get('/relatorios/movimentacao',
    [\App\Http\Controllers\RelatorioMovimentacaoController::class, 'index'])
    ->name('relatorios.movimentacao');

Route::get('/relatorios/movimentacao/exportar',
    [\App\Http\Controllers\RelatorioMovimentacaoController::class, 'exportar'])
    ->name('relatorios.movimentacao.exportar');


    // ===============================
    // CAIXA OPERACIONAL
    // ===============================
    Route::get('/caixa', [CaixaController::class, 'index'])
        ->name('caixa.index');

    Route::post('/caixa/fechar', [CaixaController::class, 'fecharCaixa'])
        ->name('caixa.fechar');

    Route::post('/caixa/ajuste', [CaixaController::class, 'ajuste'])
        ->name('caixa.ajuste');

    Route::get('/caixa/consultas', [CaixaController::class, 'consultas'])
        ->name('caixa.consultas');

    // ===============================
    // CONSULTA POR DATA (SEMPRE ÚLTIMA)
    // ===============================
    Route::get('/caixa/{data}', [CaixaController::class, 'visualizar'])
        ->where('data', '\d{4}-\d{2}-\d{2}')
        ->name('caixa.visualizar');









/*
|--------------------------------------------------------------------------
| Rotas do Relatório de Caixa
|--------------------------------------------------------------------------
|
| Adicione estas rotas ao seu arquivo routes/web.php
|
*/

// Grupo de rotas para relatórios
Route::prefix('relatorios')->name('rel-caixa.')->group(function () {
    
    // Visualizar relatório (HTML)
    Route::get('/rel-caixa', [RelCaixaController::class, 'index'])->name('index');
    
    // Exportar CSV
    Route::get('/rel-caixa/exportar', [RelCaixaController::class, 'exportar'])->name('exportar');
    
    // Imprimir
    Route::get('/rel-caixa/imprimir', [RelCaixaController::class, 'imprimir'])->name('imprimir');
});

/*
|--------------------------------------------------------------------------
| Rotas da API
|--------------------------------------------------------------------------
|
| Adicione estas rotas ao seu arquivo routes/api.php
|
*/

// API JSON
Route::prefix('api')->group(function () {
    Route::get('/relatorios/rel-caixa', [RelCaixaController::class, 'api']);
});

});

 // ROTAS PARA EXCLUIR LANÇAMENTOS DO CAIXA

// Caixa (Dinheiro)
Route::delete('/caixa/movimentacao/{id}', 
    [CaixaController::class, 'destroyCaixa']
)->name('caixa.destroy');

// Caixa Banco (PIX)
Route::delete('/caixa-banco/movimentacao/{id}', 
    [CaixaController::class, 'destroyCaixaBanco']
)->name('caixa.banco.destroy');

//  CAIXA - ESTORNO
Route::post('/caixa/estornar/{id}', 
    [CaixaController::class, 'estornarCaixa']
)->name('caixa.estornar');

Route::post('/caixa-banco/estornar/{id}', 
    [CaixaController::class, 'estornarCaixaBanco']
)->name('caixa.banco.estornar');

// EXCLUI MOVIMENTACAO
Route::delete(
    '/caixa-banco/movimentacao/{id}',
    [CaixaController::class, 'destroyCaixaBanco']
)->name('caixa.banco.destroy');




//ROTAS DE RELATÓRIO E CONSULTA MODULO CAIXA

Route::get('/caixa/consulta', [CaixaConsultaController::class, 'index'])
    ->name('caixa.consulta');







/*
|--------------------------------------------------------------------------
| S.G.A — Rotas do Dashboard
|--------------------------------------------------------------------------
| Adicione essas rotas no seu arquivo routes/api.php
|
| Acesso: https://seusite.com.br/api/dashboard/financeiro
|         https://seusite.com.br/api/dashboard/clientes
|         https://seusite.com.br/api/dashboard/estoque
|         https://seusite.com.br/api/dashboard/metas
|         https://seusite.com.br/api/dashboard/resumo
|
| Parâmetros opcionais via query string:
|   ?meses=6  → filtra os últimos 6 meses (padrão: 12)
|--------------------------------------------------------------------------
*/

Route::prefix('dashboard')->group(function () {

    // Resumo geral — página inicial
    Route::get('/resumo',      [DashboardController::class, 'resumo']);

    // Módulo 1 — Financeiro
    // DRE, Fluxo de Caixa, Contas a Pagar e Receber, Top Saídas
    Route::get('/financeiro',  [DashboardController::class, 'financeiro']);

    // Módulo 2 — Clientes
    // Carteira, Top clientes, Crescimento, Inadimplência
    Route::get('/clientes',    [DashboardController::class, 'clientes']);

    // Módulo 3 — Estoque
    // Posição atual, Críticos, Giro mensal, Top produtos
    Route::get('/estoque',     [DashboardController::class, 'estoque']);

    // Módulo 4 — Metas
    // Atingimento de receita, clientes, movimentações e inadimplência
    Route::get('/metas',       [DashboardController::class, 'metas']);

   
});



Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard.index');

    Route::get('/dashboard/previsao-financeira', [DashboardController::class, 'previsaoFinanceira'])
    ->middleware('auth')
    ->name('dashboard.previsao-financeira');

    Route::get('/dashboard/previsao-financeira',
[DashboardController::class,'previsaoFinanceira'])
->name('dashboard.previsao');

Route::get('/dashboard/vendas-por-dia', [DashboardController::class, 'vendasPorDia'])
    ->name('dashboard.vendas-por-dia');

    Route::get('/dashboard/produtos-mais-vendidos',
[DashboardController::class,'produtosMaisVendidos']);

Route::get('/dashboard/vendas-por-bairro', [DashboardController::class, 'vendasPorBairro']);

Route::get('/dashboard/vendas-por-cliente', [DashboardController::class, 'vendasPorCliente']);

Route::get('/dashboard/ticket-medio-clientes', [DashboardController::class, 'ticketMedioClientes']);

Route::get('/dashboard/previsao-ruptura', [DashboardController::class, 'previsaoRupturaEstoque']);










/*
|--------------------------------------------------------------------------
| CORS — config/cors.php
|--------------------------------------------------------------------------
| Adicione ou ajuste no seu config/cors.php:
|
| 'paths' => ['api/*'],
| 'allowed_origins' => ['http://localhost:3000', 'https://seusite.com.br'],
| 'allowed_methods' => ['*'],
| 'allowed_headers' => ['*'],
|--------------------------------------------------------------------------
*/


// ROTAS USUARIO NOVOS E ALTERAÇÕES
Route::middleware(['auth'])->group(function () {
    Route::resource('usuarios', UserController::class)->except(['show']);
});
Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');



Route::get('/buscar-usuario/{id}', function ($id) {
    $user = User::where('id', $id)->first();

    if ($user) {
        return response()->json(['usuario' => $user->usuario]);
    } else {
        return response()->json(['usuario' => 'Usuário não encontrado']);
    }
});

// Rotas disponíveis apenas para usuários autenticados (SEM middleware funcionario)
Route::middleware(['auth'])->group(function () {
    Route::get('/caixa', [CaixaController::class, 'index'])->name('caixa.index');
    Route::get('/pedidos', [MovimentacaoController::class, 'index'])->name('pedidos');
});




// módulo OFICINA

   //Route::resource('ordens-servico', OrdemServicoController::class);
   Route::resource('ordens-servico', OrdemServicoController::class)->except(['show']);

  
  Route::get('/buscar-veiculo/{placa}', function($placa) {
    $veiculo = App\Models\Veiculo::whereRaw('UPPER(TRIM(placa)) = ?', [strtoupper(trim($placa))])->first();

    if ($veiculo) {
        return response()->json([
            'success' => true,
            'marca' => $veiculo->marca,
            'veiculo' => $veiculo->veiculo,
            'cliente' => $veiculo->cliente,
        ]);
    } else {
        return response()->json(['success' => false]);
    }
});

 Route::get('/testar-dados', [OrdemServicoController::class, 'testarDados']);




// VEICULOS
Route::resource('veiculos', VeiculoController::class);
Route::get('/veiculo/buscar/{placa}', [VeiculoController::class, 'buscarPorPlaca']);


//  MECANICOS
Route::resource('mecanicos', MecanicoController::class);

// MODULOS
Route::resource('modulos', ModuloController::class);

// ORDEM DE SERVICO ITENS
Route::resource('ordem_servico_itens', OrdemServicoItemController::class);






// ========================================
// MÓDULOS - ROTAS DE ENTRADA E ACESSO
// ========================================
// IMPORTANTE: Essas rotas devem vir ANTES do Route::redirect('/', '/sga')


Route::middleware(['auth'])->group(function () {

    // Tela de seleção de módulos (só MASTER)
    Route::get('/modulos', [ModuloController::class, 'index'])
        ->middleware(CheckMaster::class)
        ->name('modulos.index');

    /* Entradas reais dos módulos (só MASTER)
    Route::middleware(CheckMaster::class)->group(function () {
        Route::get('/oficina',   [OficinaEntryController::class,   'index'])->name('oficina.entry');
        Route::get('/gas',       [GasEntryController::class,       'index'])->name('gas.entry');
        Route::get('/gerencial', [GerencialEntryController::class, 'index'])->name('gerencial.entry');
        Route::get('/padoca',    [PadocaEntryController::class,    'index'])->name('padoca.entry');
    });*/

    // ✅ AQUI ESTÁ O NOVO MENU COM PARÂMETRO OPCIONAL
   Route::get('/menu/{modulo}', [App\Http\Controllers\MenuController::class, 'index'])
    ->name('menu.index')
    ->where('modulo', 'oficina|gas|gerencial|padoca|caixa');



        //rotas da podaca 

    Route::prefix('padoca')->name('padoca.')->group(function () {

        // Encomendas
        Route::get('/encomendas', [EncomendaController::class, 'index'])->name('encomendas.index');
        Route::get('/encomendas/create', [EncomendaController::class, 'create'])->name('encomendas.create');
        Route::post('/encomendas', [EncomendaController::class, 'store'])->name('encomendas.store');
        Route::get('/encomendas/{encomenda}', [EncomendaController::class, 'show'])->name('encomendas.show');
        Route::get('/encomendas/{encomenda}/edit', [EncomendaController::class, 'edit'])->name('encomendas.edit');
        Route::put('/encomendas/{encomenda}', [EncomendaController::class, 'update'])->name('encomendas.update');
        Route::delete('/encomendas/{encomenda}', [EncomendaController::class, 'destroy'])->name('encomendas.destroy');
    });     
});


// SELETOR DE MÓDULOS
Route::middleware('auth')
    ->get('/sga', [SeletorController::class, 'index'])
    ->name('sga.seletor');

/* Redirect da raiz - DEVE VIR POR ÚLTIMO
Route::redirect('/', '/sga');*/


// SÓ PRA IMPORTAR O ARQUIVO DE DESPESAS

//Route::get('/importar-despesas', [ImportacaoDespesasController::class, 'importar']);


// RELATÓRIO GERENCIAL DE MARGEM
Route::get('/relatorios/gerencial/margem', [RelatorioController::class, 'gerencialMargem'])
     ->name('relatorios.gerencial.margem');


   //  chat suporte  inteligente

Route::post('/chat-suporte', [ChatSuporteController::class, 'perguntar'])->name('chat.suporte');


// duracao do gás pelo cliente

Route::resource('duracao', ClienteProdutoDuracaoController::class);

Route::get('relatorio/gas', [RelatorioGasController::class, 'index'])->name('relatorio.gas');
Route::get('relatorio/gas/excel', [RelatorioGasController::class, 'exportarExcel'])->name('relatorio.gas.excel');

// ROTAS DO MANUAL
Route::get('/manual', function () {
    return view('manual.index');
})->name('manual.index');



Route::get('/manual', function () {
    return view('manual.index');
});


Route::redirect('/', '/login');


// TELAS DE PERMISSAO DE USUÁRIOS

Route::get('/perfis/{perfil}/permissoes', [PerfilController::class, 'permissoes'])
    ->middleware(['auth'])
    ->name('perfis.permissoes');

Route::post('/perfis/{perfil}/permissoes', [PerfilController::class, 'salvarPermissoes'])
    ->middleware(['auth']);

   

Route::get('/perfis/administrador', [PerfilController::class, 'administrador'])->name('perfis.administrador');
Route::get('/perfis/gerente', [PerfilController::class, 'gerente'])->name('perfis.gerente');
Route::get('/perfis/operacional', [PerfilController::class, 'operacional'])->name('perfis.operacional');
Route::get('/perfis/financeiro', [PerfilController::class, 'financeiro'])->name('perfis.financeiro');

    // ROTAS DO BACKUP DO SISTEMA 


Route::middleware(['auth'])->group(function () {
    Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
    Route::post('/backups/gerar', [BackupController::class, 'gerar'])->name('backups.gerar');
    Route::get('/backups/download/{id}', [BackupController::class, 'download'])->name('backups.download');
Route::post('/backups/restaurar/{id}', [BackupController::class, 'restaurar'])->name('backups.restaurar');

});

// rotas do relatóro contas a pagar
Route::get('/relatorio-contas-a-pagar/exportar', [ContasAPagarController::class, 'exportarExcel'])
    ->name('contas-a-pagar.exportar');


//  CONTROLE DE VASILHAMES - GÁS
Route::resource('controle-vasilhames', ControleVasilhameController::class);


// tela do vale gás
Route::prefix('vale-gas')->name('vale-gas.')->group(function () {
    Route::get('/', [ValeGasController::class, 'index'])->name('index');
    Route::get('/novo', [ValeGasController::class, 'create'])->name('create');
    Route::post('/', [ValeGasController::class, 'store'])->name('store');
    Route::get('/{id}', [ValeGasController::class, 'show'])->name('show');
    Route::get('/{id}/editar', [ValeGasController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ValeGasController::class, 'update'])->name('update');
    Route::post('/{id}/cancelar', [ValeGasController::class, 'cancelar'])->name('cancelar');
    Route::post('/{id}/iniciar-retirada', [ValeGasController::class, 'iniciarRetirada'])->name('iniciar-retirada');

});


// DASHBOARD EMISSÃO 
Route::get('/dashboard-gerencial-emissao', [DashboardEmissaoController::class, 'index'])->name('dashboard.emissao');

// DASHBOARD EMISSÃO  GÁS E ÁGUA  INTELIGENTE RELATÓRIO

Route::get('/dashboard/emissao/gas', [DashboardEmissaoInteligenteController::class, 'gas'])
    ->name('dashboard.emissao.gas');

Route::get('/dashboard/emissao/agua', [DashboardEmissaoInteligenteController::class, 'agua'])
    ->name('dashboard.emissao.agua');


    
// DASHBOARD FINANCEIRO INTELIGENTE -  RELATÓRIO


Route::get('/dashboard-financeiro', [DashboardFinanceiroController::class, 'index'])
    ->name('dashboard.financeiro');

// IMPORTACAO DE DESPESAS PELO EXCEL PARA O SISTEMA

Route::middleware(['auth'])->prefix('financeiro/contas-a-pagar')->group(function () {
   Route::get('/importar-despesas', [ImportacaoDespesaController::class, 'index'])
       ->name('contas-pagar.importacao.index');

   Route::post('/importar-despesas', [ImportacaoDespesaController::class, 'importar'])
        ->name('contas-pagar.importacao.importar');
});  

// RELATÓRIO POR EMISSAO AGRUPADO POR DATA
Route::get('/relatorio-vendas-emissao', [RelatorioVendasEmissaoController::class, 'index'])
    ->name('relatorio.vendas-emissao');

Route::get('/relatorio-vendas-emissao/exportar', [RelatorioVendasEmissaoController::class, 'exportar'])
    ->name('relatorio.vendas-emissao.exportar');


// CONTROLE DE VASILHAME POR CLIENTE


Route::prefix('vasilhame-emprestimos')->name('vasilhame-emprestimos.')->group(function () {
    Route::get('/',             [VasilhameEmprestimoController::class, 'index'])              ->name('index');
    Route::post('/',            [VasilhameEmprestimoController::class, 'store'])              ->name('store');
    Route::patch('/{id}/devolver', [VasilhameEmprestimoController::class, 'registrarDevolucao'])->name('devolver');
    Route::delete('/{id}',      [VasilhameEmprestimoController::class, 'destroy'])            ->name('destroy');
});


// RELATORIO POR NATUREZA financeira



Route::get('/relatorios/natureza-financeira', [RelatorioNaturezaFinanceiraController::class, 'index'])
    ->name('relatorios.natureza-financeira');


   //  cadastrar natureza financeira


Route::resource('naturezas-financeiras', NaturezaFinanceiraController::class);

