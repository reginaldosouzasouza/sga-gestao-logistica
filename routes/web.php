<?php

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
use App\Http\Controllers\CaixaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrdemServicoController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\MecanicoController;
use App\Http\Controllers\OrdemServicoItemController;
use App\Http\Controllers\Padoca\EncomendaController;
use App\Http\Controllers\SGA\SeletorController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\MenuController;
use App\Http\Middleware\CheckMaster;
use App\Http\Controllers\RelCaixaController;
use App\Http\Controllers\CaixaConsultaController;
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
use App\Http\Controllers\DashboardEmissaoInteligenteController;
use App\Http\Controllers\DashboardFinanceiroController;
use App\Http\Controllers\Financeiro\ImportacaoDespesaController;
use App\Http\Controllers\RelatorioVendasEmissaoController;
use App\Http\Controllers\VasilhameEmprestimoController;
use App\Http\Controllers\RelatorioNaturezaFinanceiraController;
use App\Http\Controllers\NaturezaFinanceiraController;
use App\Http\Controllers\DashboardFechamentoFinanceiroController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ImportacaoClientesController;
use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\RelatorioComissaoController;
use App\Http\Controllers\EmpresaAtendimentoController;
use App\Http\Controllers\ClienteAniversarioController;
use App\Http\Controllers\ConfiguracaoPrevisaoVendaController;
use App\Services\PrevisaoGiroService;
use App\Models\Produto;
use Carbon\Carbon;
use App\Http\Controllers\RelatorioComparativoNaturezaController;
use App\Http\Controllers\RelatorioComparativoFluxoController;
use App\Http\Controllers\RelatorioMargemEmissaoController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;



/*
|--------------------------------------------------------------------------
| ROTAS PÚBLICAS
|--------------------------------------------------------------------------
| Somente login, logout, redirecionamento inicial e busca do usuário do
| formulário de login ficam fora do grupo auth.
|--------------------------------------------------------------------------
*/

Route::get('/abrir-sistema', function (\Illuminate\Http\Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('status', 'Sessão anterior encerrada. Faça login novamente.');
})->name('abrir.sistema');




Route::get('/login-clean', [LoginController::class, 'showLoginForm'])->name('login.clean');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/buscar-usuario/{id}', function ($id) {
    $user = \App\Models\User::where('id', $id)->first();

    return response()->json([
        'usuario' => $user?->usuario ?? '',
    ]);
})->name('buscar.usuario');


// rotas previsao de venda controller
Route::middleware(['auth'])->group(function () {

    Route::get('/configuracao-previsao-vendas', [ConfiguracaoPrevisaoVendaController::class, 'index'])
        ->name('configuracao-previsao-vendas.index');

    Route::put('/configuracao-previsao-vendas/{id}', [ConfiguracaoPrevisaoVendaController::class, 'update'])
        ->name('configuracao-previsao-vendas.update');

});














/*
|--------------------------------------------------------------------------
| SITE PÚBLICO DO S.G.A.
|--------------------------------------------------------------------------
| Página inicial de apresentação do sistema.
| O login continua acessível por /abrir-sistema.
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('site.index');
})->name('site.index');

/*
|--------------------------------------------------------------------------
| ROTAS PROTEGIDAS DO SISTEMA
|--------------------------------------------------------------------------
| Tudo abaixo exige usuário autenticado.
|
| Observação: se você já criou e registrou o middleware NoCache, pode trocar
| ['auth'] por ['auth', 'nocache'] neste grupo principal.
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'nocache', 'empresa.ativa'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | S.G.A — SELETOR E MENU DE MÓDULOS
    |--------------------------------------------------------------------------
    */

    Route::get('/sga', [SeletorController::class, 'index'])
        ->name('sga.seletor');

    Route::get('/menu/{modulo}', [MenuController::class, 'index'])
        ->name('menu.index')
        ->where('modulo', 'oficina|gas|gerencial|padoca|caixa');

    Route::get('/modulos', [ModuloController::class, 'index'])
        ->middleware(CheckMaster::class)
        ->name('modulos.index');

    Route::get('/menu.html', function () {
        return view('menu.html');
    })
        ->middleware('master')
        ->name('menu');


// rotas de aniversário cliente;

Route::middleware(['auth'])->group(function () {
    Route::get('/clientes/aniversariantes', [ClienteAniversarioController::class, 'index'])
        ->name('clientes.aniversariantes');
});






/*
|--------------------------------------------------------------------------
| CLIENTES - ROTAS COM PERMISSÃO
|--------------------------------------------------------------------------
*/

Route::get('/clientes', [ClienteController::class, 'index'])
    ->middleware('permissao:cliente_visualizar')
    ->name('clientes.index');

Route::get('/clientes/create', [ClienteController::class, 'create'])
    ->middleware('permissao:cliente_cadastrar')
    ->name('clientes.create');

/* ROTAS IMPORTAÇÃO DE CLIENTES */
Route::get('/clientes/importar', [ImportacaoClientesController::class, 'index'])
    ->middleware('auth')
    ->name('clientes.importar');

Route::post('/clientes/importar', [ImportacaoClientesController::class, 'importar'])
    ->middleware('auth')
    ->name('clientes.importar.processar');
/*  -------------------------------------------------------   */


Route::post('/clientes', [ClienteController::class, 'store'])
    ->middleware('permissao:cliente_cadastrar')
    ->name('clientes.store');

Route::get('/clientes/{cliente}', [ClienteController::class, 'show'])
    ->middleware('permissao:cliente_visualizar')
    ->name('clientes.show');

Route::get('/clientes/{cliente}/edit', [ClienteController::class, 'edit'])
    ->middleware('permissao:cliente_editar')
    ->name('clientes.edit');

Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])
    ->middleware('permissao:cliente_editar')
    ->name('clientes.update');

Route::patch('/clientes/{cliente}', [ClienteController::class, 'update'])
    ->middleware('permissao:cliente_editar')
    ->name('clientes.update.patch');

Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])
    ->middleware('permissao:cliente_excluir')
    ->name('clientes.destroy');

Route::get('/clientes-pesquisar', [ClienteController::class, 'pesquisar'])
    ->middleware('permissao:cliente_visualizar')
    ->name('clientes.pesquisar');

Route::get('/buscar-cliente', [ClienteController::class, 'buscar'])
    ->middleware('permissao:cliente_visualizar')
    ->name('buscar.cliente');

   /*
|--------------------------------------------------------------------------
| FORNECEDORES - ROTAS COM PERMISSÃO
|--------------------------------------------------------------------------
*/

/*
| Importação XML
| Precisa ficar antes das rotas com {fornecedor}, por segurança.
*/
Route::post('/fornecedores/importarXML', [FornecedorController::class, 'importarXML'])
    ->middleware('permissao:fornecedor_cadastrar')
    ->name('fornecedores.importarXML');


/*
| CRUD de fornecedores
*/
Route::get('/fornecedores', [FornecedorController::class, 'index'])
    ->middleware('permissao:fornecedor_visualizar')
    ->name('fornecedores.index');

Route::get('/fornecedores/create', [FornecedorController::class, 'create'])
    ->middleware('permissao:fornecedor_cadastrar')
    ->name('fornecedores.create');

Route::post('/fornecedores', [FornecedorController::class, 'store'])
    ->middleware('permissao:fornecedor_cadastrar')
    ->name('fornecedores.store');

Route::get('/fornecedores/{fornecedor}', [FornecedorController::class, 'show'])
    ->middleware('permissao:fornecedor_visualizar')
    ->name('fornecedores.show');

Route::get('/fornecedores/{fornecedor}/edit', [FornecedorController::class, 'edit'])
    ->middleware('permissao:fornecedor_editar')
    ->name('fornecedores.edit');

Route::put('/fornecedores/{fornecedor}', [FornecedorController::class, 'update'])
    ->middleware('permissao:fornecedor_editar')
    ->name('fornecedores.update');

Route::patch('/fornecedores/{fornecedor}', [FornecedorController::class, 'update'])
    ->middleware('permissao:fornecedor_editar')
    ->name('fornecedores.update.patch');

Route::delete('/fornecedores/{fornecedor}', [FornecedorController::class, 'destroy'])
    ->middleware('permissao:fornecedor_excluir')
    ->name('fornecedores.destroy');


   
/*
|--------------------------------------------------------------------------
| PRODUTOS - ROTAS COM PERMISSÃO
|--------------------------------------------------------------------------
*/

/*
| Rotas auxiliares/consultas de produtos
| Precisam ficar antes das rotas com {produto}, para evitar conflito.
*/

Route::get('/autocomplete-produtos', [ProdutoController::class, 'autocomplete'])
    ->middleware('permissao:produto_visualizar')
    ->name('autocomplete.produtos');

Route::get('/produtos/buscar', [ProdutoController::class, 'buscar'])
    ->middleware('permissao:produto_visualizar')
    ->name('produtos.buscar');

Route::get('/verificar-estoque', [ProdutoController::class, 'verificarEstoque'])
    ->middleware('permissao:produto_visualizar');

Route::post('/api/produto/buscar', [ProdutoController::class, 'buscarPorCodigo'])
    ->middleware('permissao:produto_visualizar');

Route::get('/produtos/relatorio/margem', [ProdutoController::class, 'relatorioMargem'])
    ->middleware('permissao:relatorio_estoque')
    ->name('produtos.relatorio.margem');

Route::get('/relatorios/saldo-estoque', [ProdutoController::class, 'saldoEstoque'])
    ->middleware('permissao:relatorio_estoque')
    ->name('relatorios.saldoEstoque');

Route::get('/relatorio-estoque', [ProdutoController::class, 'relatorioEstoqueAtual'])
    ->middleware('permissao:relatorio_estoque')
    ->name('estoques.relatorio');


/*
| CRUD de produtos
*/

Route::get('/produtos', [ProdutoController::class, 'index'])
    ->middleware('permissao:produto_visualizar')
    ->name('produtos.index');

Route::get('/produtos/create', [ProdutoController::class, 'create'])
    ->middleware('permissao:produto_cadastrar')
    ->name('produtos.create');

Route::post('/produtos', [ProdutoController::class, 'store'])
    ->middleware('permissao:produto_cadastrar')
    ->name('produtos.store');

Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])
    ->middleware('permissao:produto_visualizar')
    ->name('produtos.show');

Route::get('/produtos/{produto}/edit', [ProdutoController::class, 'edit'])
    ->middleware('permissao:produto_editar')
    ->name('produtos.edit');

Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])
    ->middleware('permissao:produto_editar')
    ->name('produtos.update');

Route::patch('/produtos/{produto}', [ProdutoController::class, 'update'])
    ->middleware('permissao:produto_editar')
    ->name('produtos.update.patch');

Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])
    ->middleware('permissao:produto_excluir')
    ->name('produtos.destroy');


    /*
    |--------------------------------------------------------------------------
    | FORMAS DE PAGAMENTO
    |--------------------------------------------------------------------------
    */

    Route::resource('formas_de_pagamento', FormasDePagamentoController::class);


    /*
    |--------------------------------------------------------------------------
    | COMPRAS
    |--------------------------------------------------------------------------
    */

    Route::get('/compras', [ComprasController::class, 'index'])->name('compras.index');
    Route::get('/compras/create', [ComprasController::class, 'create'])->name('compras.create');
    Route::post('/compras', [ComprasController::class, 'store'])->name('compras.store');
    Route::get('/compras/search', [ComprasController::class, 'search'])->name('compras.search');
    Route::get('/compras/{id}/edit', [ComprasController::class, 'edit'])->name('compras.edit');
    Route::put('/compras/{id}', [ComprasController::class, 'update'])->name('compras.update');
    Route::delete('/compras/{id}', [ComprasController::class, 'destroy'])->name('compras.destroy');
    Route::post('/compras/importarXML', [ComprasController::class, 'importarXML'])
        ->name('compras.importarXML');


    /*
    |--------------------------------------------------------------------------
    | ESTOQUE
    |--------------------------------------------------------------------------
    */

    Route::resource('estoques', EstoqueController::class);
    Route::get('/estoques/total', [EstoqueController::class, 'totalEstoque'])
        ->name('estoques.total');
    Route::get('/estoques/consulta', [EstoqueController::class, 'consultaEstoque'])
        ->name('estoques.consulta');


    /*
    |--------------------------------------------------------------------------
    | MOVIMENTAÇÃO / PEDIDOS
    |--------------------------------------------------------------------------
    */

    Route::get('/pedido-coleta/create', [PedidoColetaController::class, 'create'])
        ->name('pedido_coleta.create');

    Route::get('/movimentacao/pesquisar', [MovimentacaoController::class, 'pesquisar'])
        ->name('movimentacao.pesquisar');

    Route::resource('movimentacao', MovimentacaoController::class);

    Route::get('/movimentacoes', [MovimentacaoController::class, 'index'])
        ->name('movimentacoes.index');

    Route::get('/pedidos', [MovimentacaoController::class, 'index'])
        ->name('pedidos');

    Route::resource('movimentacao-itens', MovimentacaoItemController::class);


//  ROTA DA CONFIRMAÇÃO DO RASTREIO

    Route::get('/movimentacao/{id}/confirmar-rastreio', [MovimentacaoController::class, 'confirmarRastreio'])
    ->name('movimentacao.confirmar-rastreio');

    Route::post('/movimentacao/{id}/gerar-rastreio', [MovimentacaoController::class, 'gerarRastreio'])
    ->name('movimentacao.gerar-rastreio');


   /*
/*
|--------------------------------------------------------------------------
| CONTAS A PAGAR - ROTAS COM PERMISSÃO
|--------------------------------------------------------------------------
*/

/*
| Listagem / visualização
*/
Route::get('/contas-a-pagar', [ContasAPagarController::class, 'index'])
    ->middleware('permissao:conta_pagar_visualizar')
    ->name('contas-a-pagar.index');

Route::get('/contas-a-pagar/create', [ContasAPagarController::class, 'create'])
    ->middleware('permissao:conta_pagar_lancar')
    ->name('contas-a-pagar.create');

Route::post('/contas-a-pagar', [ContasAPagarController::class, 'store'])
    ->middleware('permissao:conta_pagar_lancar')
    ->name('contas-a-pagar.store');

/*
| Rota antiga mantida para não quebrar formulários antigos
*/
Route::post('/contas_a_pagar/store', [ContasAPagarController::class, 'store'])
    ->middleware('permissao:conta_pagar_lancar')
    ->name('contas_a_pagar.store');

Route::get('/contas-a-pagar/{id}', [ContasAPagarController::class, 'show'])
    ->middleware('permissao:conta_pagar_visualizar')
    ->name('contas-a-pagar.show');

Route::get('/contas-a-pagar/{id}/edit', [ContasAPagarController::class, 'edit'])
    ->middleware('permissao:conta_pagar_lancar')
    ->name('contas-a-pagar.edit');

Route::put('/contas-a-pagar/{id}', [ContasAPagarController::class, 'update'])
    ->middleware('permissao:conta_pagar_lancar')
    ->name('contas-a-pagar.update');

Route::patch('/contas-a-pagar/{id}', [ContasAPagarController::class, 'update'])
    ->middleware('permissao:conta_pagar_lancar')
    ->name('contas-a-pagar.update.patch');

Route::delete('/contas-a-pagar/{id}', [ContasAPagarController::class, 'destroy'])
    ->middleware('permissao:conta_pagar_lancar')
    ->name('contas-a-pagar.destroy');


/*
| Baixa de contas a pagar
*/
Route::post('/contas-a-pagar/{id}/baixar', [ContasAPagarController::class, 'baixar'])
    ->middleware('permissao:conta_pagar_baixar')
    ->name('contas-a-pagar.baixar');


/*
| Relatórios de contas a pagar
*/
Route::get('/relatorio-contas-a-pagar', [ContasAPagarController::class, 'relatorioContasAPagar'])
    ->middleware('permissao:relatorio_financeiro')
    ->name('contas-a-pagar.relatorio');

Route::get('/relatorio-contas-a-pagar/exportar', [ContasAPagarController::class, 'exportarExcel'])
    ->middleware('permissao:relatorio_financeiro')
    ->name('contas-a-pagar.exportar');


/*
| Importação de despesas
*/
Route::prefix('financeiro/contas-a-pagar')->group(function () {
    Route::get('/importar-despesas', [ImportacaoDespesaController::class, 'index'])
        ->middleware('permissao:conta_pagar_lancar')
        ->name('contas-pagar.importacao.index');

    Route::post('/importar-despesas', [ImportacaoDespesaController::class, 'importar'])
        ->middleware('permissao:conta_pagar_lancar')
        ->name('contas-pagar.importacao.importar');
});

    /*
|--------------------------------------------------------------------------
| CONTAS A RECEBER - ROTAS COM PERMISSÃO
|--------------------------------------------------------------------------
*/

/*
| Relatório e exportação
*/
Route::get('/contas_a_receber/exportar', [ContasAReceberController::class, 'exportarCsv'])
    ->middleware('permissao:relatorio_financeiro')
    ->name('contas_a_receber.exportar');

Route::get('/contas_a_receber/relatorio', [ContasAReceberController::class, 'relatorio'])
    ->middleware('permissao:relatorio_financeiro')
    ->name('contas_a_receber.relatorio');


/*
| Atualização de status / baixa
| Como altera situação financeira, protegemos como baixa.
*/
Route::post('/contas_a_receber/atualizar-status', [ContasAReceberController::class, 'atualizarStatus'])
    ->middleware('permissao:conta_receber_baixar')
    ->name('contas_a_receber.atualizar-status');


/*
| CRUD de contas a receber
*/
Route::get('/contas_a_receber', [ContasAReceberController::class, 'index'])
    ->middleware('permissao:conta_receber_visualizar')
    ->name('contas_a_receber.index');

Route::get('/contas_a_receber/create', [ContasAReceberController::class, 'create'])
    ->middleware('permissao:conta_receber_lancar')
    ->name('contas_a_receber.create');

Route::post('/contas_a_receber', [ContasAReceberController::class, 'store'])
    ->middleware('permissao:conta_receber_lancar')
    ->name('contas_a_receber.store');

Route::get('/contas_a_receber/{id}', [ContasAReceberController::class, 'show'])
    ->middleware('permissao:conta_receber_visualizar')
    ->name('contas_a_receber.show');

Route::get('/contas_a_receber/{id}/edit', [ContasAReceberController::class, 'edit'])
    ->middleware('permissao:conta_receber_lancar')
    ->name('contas_a_receber.edit');

Route::put('/contas_a_receber/{id}', [ContasAReceberController::class, 'update'])
    ->middleware('permissao:conta_receber_lancar')
    ->name('contas_a_receber.update');

Route::patch('/contas_a_receber/{id}', [ContasAReceberController::class, 'update'])
    ->middleware('permissao:conta_receber_lancar')
    ->name('contas_a_receber.update.patch');

Route::delete('/contas_a_receber/{id}', [ContasAReceberController::class, 'destroy'])
    ->middleware('permissao:conta_receber_lancar')
    ->name('contas_a_receber.destroy');


/*
| Rota alternativa com hífen
| Mantida somente para compatibilidade de URL.
| Os nomes continuam no padrão contas_a_receber.*
*/
Route::get('/contas-a-receber', [ContasAReceberController::class, 'index'])
    ->middleware('permissao:conta_receber_visualizar');

Route::get('/contas-a-receber/create', [ContasAReceberController::class, 'create'])
    ->middleware('permissao:conta_receber_lancar');

Route::get('/contas-a-receber/{id}/edit', [ContasAReceberController::class, 'edit'])
    ->middleware('permissao:conta_receber_lancar');

Route::put('/contas-a-receber/{id}', [ContasAReceberController::class, 'update'])
    ->middleware('permissao:conta_receber_lancar');

Route::patch('/contas-a-receber/{id}', [ContasAReceberController::class, 'update'])
    ->middleware('permissao:conta_receber_lancar');

Route::delete('/contas-a-receber/{id}', [ContasAReceberController::class, 'destroy'])
    ->middleware('permissao:conta_receber_lancar');



    /*
|--------------------------------------------------------------------------
| CAIXA OPERACIONAL - ROTAS COM PERMISSÃO
|--------------------------------------------------------------------------
*/

Route::get('/caixa', [CaixaController::class, 'index'])
    ->middleware('permissao:caixa_visualizar')
    ->name('caixa.index');

Route::get('/caixa/abrir', [CaixaController::class, 'abrir'])
    ->middleware('permissao:caixa_abrir')
    ->name('caixa.abrir');

Route::post('/caixa/fechar', [CaixaController::class, 'fecharCaixa'])
    ->middleware('permissao:caixa_fechar')
    ->name('caixa.fechar');

/*
| Ajuste manual do caixa.
| Por enquanto protegido com caixa_fechar, pois é uma ação sensível.
| Futuramente podemos criar a permissão caixa_ajustar.
*/
Route::post('/caixa/ajuste', [CaixaController::class, 'ajuste'])
    ->middleware('permissao:caixa_fechar')
    ->name('caixa.ajuste');

Route::get('/caixa/consultas', [CaixaController::class, 'consultas'])
    ->middleware('permissao:caixa_visualizar')
    ->name('caixa.consultas');

Route::get('/caixa/consulta', [CaixaConsultaController::class, 'index'])
    ->middleware('permissao:caixa_visualizar')
    ->name('caixa.consulta');

Route::get('/caixa/{data}', [CaixaController::class, 'visualizar'])
    ->middleware('permissao:caixa_visualizar')
    ->where('data', '\d{4}-\d{2}-\d{2}')
    ->name('caixa.visualizar');

/*
| Exclusão e estorno são ações sensíveis.
| Por enquanto ficam protegidas por caixa_fechar.
| Futuramente podemos criar permissões próprias:
| caixa_estornar
| caixa_excluir_movimentacao
*/
Route::delete('/caixa/movimentacao/{id}', [CaixaController::class, 'destroyCaixa'])
    ->middleware('permissao:caixa_fechar')
    ->name('caixa.destroy');

Route::delete('/caixa-banco/movimentacao/{id}', [CaixaController::class, 'destroyCaixaBanco'])
    ->middleware('permissao:caixa_fechar')
    ->name('caixa.banco.destroy');

Route::post('/caixa/estornar/{id}', [CaixaController::class, 'estornarCaixa'])
    ->middleware('permissao:caixa_fechar')
    ->name('caixa.estornar');

Route::post('/caixa-banco/estornar/{id}', [CaixaController::class, 'estornarCaixaBanco'])
    ->middleware('permissao:caixa_fechar')
    ->name('caixa.banco.estornar');


/*
|--------------------------------------------------------------------------
| RELATÓRIOS DE CAIXA - ROTAS COM PERMISSÃO
|--------------------------------------------------------------------------
*/

Route::get('/relatorios/movimentacao', [\App\Http\Controllers\RelatorioMovimentacaoController::class, 'index'])
    ->middleware('permissao:relatorio_financeiro')
    ->name('relatorios.movimentacao');

Route::get('/relatorios/movimentacao/exportar', [\App\Http\Controllers\RelatorioMovimentacaoController::class, 'exportar'])
    ->middleware('permissao:relatorio_financeiro')
    ->name('relatorios.movimentacao.exportar');

Route::prefix('relatorios')->name('rel-caixa.')->group(function () {
    Route::get('/rel-caixa', [RelCaixaController::class, 'index'])
        ->middleware('permissao:relatorio_financeiro')
        ->name('index');

    Route::get('/rel-caixa/exportar', [RelCaixaController::class, 'exportar'])
        ->middleware('permissao:relatorio_financeiro')
        ->name('exportar');

    Route::get('/rel-caixa/imprimir', [RelCaixaController::class, 'imprimir'])
        ->middleware('permissao:relatorio_financeiro')
        ->name('imprimir');
});

Route::prefix('api')->group(function () {
    Route::get('/relatorios/rel-caixa', [RelCaixaController::class, 'api'])
        ->middleware('permissao:relatorio_financeiro');
});
    
   /*
|--------------------------------------------------------------------------
| DASHBOARDS — PROTEGIDOS
|--------------------------------------------------------------------------
| Este bloco substitui todas as rotas antigas/duplicadas de dashboard.
| Não deixe outras rotas /dashboard fora deste grupo.
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'nocache', 'permissao:dashboard_visualizar'])
    ->name('dashboard.index');

Route::prefix('dashboard')
    ->middleware(['auth', 'nocache', 'permissao:dashboard_visualizar'])
    ->group(function () {

        Route::get('/resumo', [DashboardController::class, 'resumo'])
            ->name('dashboard.resumo');

        Route::get('/financeiro', [DashboardController::class, 'financeiro'])
            ->name('dashboard.financeiro.api');

        Route::get('/clientes', [DashboardController::class, 'clientes'])
            ->name('dashboard.clientes');

        Route::get('/estoque', [DashboardController::class, 'estoque'])
            ->name('dashboard.estoque');

        Route::get('/metas', [DashboardController::class, 'metas'])
            ->name('dashboard.metas');

        Route::get('/previsao-financeira', [DashboardController::class, 'previsaoFinanceira'])
            ->name('dashboard.previsao');

        Route::get('/vendas-por-dia', [DashboardController::class, 'vendasPorDia'])
            ->name('dashboard.vendas-por-dia');

        Route::get('/produtos-mais-vendidos', [DashboardController::class, 'produtosMaisVendidos'])
            ->name('dashboard.produtos-mais-vendidos');

        Route::get('/vendas-por-bairro', [DashboardController::class, 'vendasPorBairro'])
            ->name('dashboard.vendas-por-bairro');

        Route::get('/vendas-por-cliente', [DashboardController::class, 'vendasPorCliente'])
            ->name('dashboard.vendas-por-cliente');

        Route::get('/ticket-medio-clientes', [DashboardController::class, 'ticketMedioClientes'])
            ->name('dashboard.ticket-medio-clientes');

        Route::get('/previsao-ruptura', [DashboardController::class, 'previsaoRupturaEstoque'])
            ->name('dashboard.previsao-ruptura');

        Route::get('/emissao/gas', [DashboardEmissaoInteligenteController::class, 'gas'])
            ->name('dashboard.emissao.gas');

        Route::get('/emissao/agua', [DashboardEmissaoInteligenteController::class, 'agua'])
            ->name('dashboard.emissao.agua');

        Route::get('/fechamento-financeiro', [DashboardFechamentoFinanceiroController::class, 'index'])
            ->name('dashboard.fechamento-financeiro');
    });

Route::get('/dashboard-gerencial-emissao', [DashboardEmissaoController::class, 'index'])
    ->middleware(['auth', 'nocache', 'permissao:dashboard_visualizar'])
    ->name('dashboard.emissao');

Route::get('/dashboard-financeiro', [DashboardFinanceiroController::class, 'index'])
    ->middleware(['auth', 'nocache', 'permissao:dashboard_visualizar'])
    ->name('dashboard.financeiro');

    Route::get('/dashboard-gerencial-emissao', [DashboardEmissaoController::class, 'index'])
        ->middleware('auth')
        ->name('dashboard.emissao');

    Route::get('/dashboard-financeiro', [DashboardFinanceiroController::class, 'index'])
        ->middleware('auth')
        ->name('dashboard.financeiro');


    /*
    |--------------------------------------------------------------------------
    | RELATÓRIOS GERAIS
    |--------------------------------------------------------------------------
    */

    Route::prefix('relatorios')->name('relatorios.')->group(function () {
        Route::get('/compras', [RelatorioComprasController::class, 'index'])
            ->name('compras');

        Route::get('/compras/export', [RelatorioComprasController::class, 'export'])
            ->name('compras.export');

        Route::get('/vendas', [RelatorioController::class, 'vendas'])
            ->name('vendas');

        Route::get('/vendas-por-produto', [RelatorioController::class, 'vendasPorProduto'])
            ->name('vendasPorProduto');

        Route::get('/saldo_estoque', [RelatorioController::class, 'saldoEstoque'])
            ->name('saldoEstoque');

        Route::get('/gerencial/margem', [RelatorioController::class, 'gerencialMargem'])
            ->name('gerencial.margem');

        Route::get('/natureza-financeira', [RelatorioNaturezaFinanceiraController::class, 'index'])
            ->name('natureza-financeira');

        Route::get('/comparativo-natureza', [RelatorioComparativoNaturezaController::class, 'index'])
            ->name('comparativo-natureza');

        Route::get('/comparativo-fluxo', [RelatorioComparativoFluxoController::class, 'index'])
            ->name('comparativo-fluxo');      



    });

    Route::get('/relatorio-vendas-emissao', [RelatorioVendasEmissaoController::class, 'index'])
        ->name('relatorio.vendas-emissao');

    Route::get('/relatorio-vendas-emissao/exportar', [RelatorioVendasEmissaoController::class, 'exportar'])
        ->name('relatorio.vendas-emissao.exportar');

    Route::get('/relatorio/gas', [RelatorioGasController::class, 'index'])
        ->name('relatorio.gas');

    Route::get('/relatorio/gas/excel', [RelatorioGasController::class, 'exportarExcel'])
        ->name('relatorio.gas.excel');


    /*
    |--------------------------------------------------------------------------
    | CONTROLE DE VASILHAMES E VALE GÁS
    |--------------------------------------------------------------------------
    */

    Route::resource('controle-vasilhames', ControleVasilhameController::class);

    Route::prefix('vasilhame-emprestimos')->name('vasilhame-emprestimos.')->group(function () {
        Route::get('/', [VasilhameEmprestimoController::class, 'index'])->name('index');
        Route::post('/', [VasilhameEmprestimoController::class, 'store'])->name('store');
        Route::patch('/{id}/devolver', [VasilhameEmprestimoController::class, 'registrarDevolucao'])->name('devolver');
        Route::delete('/{id}', [VasilhameEmprestimoController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('vale-gas')->name('vale-gas.')->group(function () {
        Route::get('/', [ValeGasController::class, 'index'])->name('index');
        Route::get('/novo', [ValeGasController::class, 'create'])->name('create');
        Route::post('/', [ValeGasController::class, 'store'])->name('store');
        Route::get('/{id}', [ValeGasController::class, 'show'])->name('show');
        Route::get('/{id}/editar', [ValeGasController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ValeGasController::class, 'update'])->name('update');
        Route::post('/{id}/cancelar', [ValeGasController::class, 'cancelar'])->name('cancelar');
        Route::post('/{id}/iniciar-retirada', [ValeGasController::class, 'iniciarRetirada'])
            ->name('iniciar-retirada');
    });


    /*
    |--------------------------------------------------------------------------
    | NATUREZAS FINANCEIRAS
    |--------------------------------------------------------------------------
    */

    Route::resource('naturezas-financeiras', NaturezaFinanceiraController::class);


    /*
    |--------------------------------------------------------------------------
    | USUÁRIOS, PERFIS E EMPRESAS
    |--------------------------------------------------------------------------
    */

    Route::resource('usuarios', UserController::class)->except(['show']);

    Route::resource('empresas', EmpresaController::class);

    Route::get('/perfis/{perfil}/permissoes', [PerfilController::class, 'permissoes'])
        ->name('perfis.permissoes');

    Route::post('/perfis/{perfil}/permissoes', [PerfilController::class, 'salvarPermissoes']);

    Route::get('/perfis/administrador', [PerfilController::class, 'administrador'])
        ->name('perfis.administrador');

    Route::get('/perfis/gerente', [PerfilController::class, 'gerente'])
        ->name('perfis.gerente');

    Route::get('/perfis/operacional', [PerfilController::class, 'operacional'])
        ->name('perfis.operacional');

    Route::get('/perfis/financeiro', [PerfilController::class, 'financeiro'])
        ->name('perfis.financeiro');
        

        // Monitor de Acessos
// Coloque junto das rotas de usuários, dentro do middleware auth.
    Route::get('/usuarios/monitor-acessos', [UserController::class, 'monitorAcessos'])
        ->name('usuarios.monitor-acessos');

    /*
    |--------------------------------------------------------------------------
    | BACKUP
    |--------------------------------------------------------------------------
    */

    Route::get('/backups', [BackupController::class, 'index'])
        ->name('backups.index');

    Route::post('/backups/gerar', [BackupController::class, 'gerar'])
        ->name('backups.gerar');

    Route::get('/backups/download/{id}', [BackupController::class, 'download'])
        ->name('backups.download');

    Route::post('/backups/restaurar/{id}', [BackupController::class, 'restaurar'])
        ->name('backups.restaurar');






        // rotas veiculo da revenda de gas
        Route::middleware(['auth'])->group(function () {
    Route::resource('motoristas', MotoristaController::class);
    Route::resource('veiculos', VeiculoController::class);
});
    /*
    |--------------------------------------------------------------------------
    | OFICINA
    |--------------------------------------------------------------------------
    

    Route::resource('ordens-servico', OrdemServicoController::class)->except(['show']);

    Route::get('/buscar-veiculo/{placa}', function ($placa) {
        $veiculo = \App\Models\Veiculo::whereRaw(
            'UPPER(TRIM(placa)) = ?',
            [strtoupper(trim($placa))]
        )->first();

        if ($veiculo) {
            return response()->json([
                'success' => true,
                'marca' => $veiculo->marca,
                'veiculo' => $veiculo->veiculo,
                'cliente' => $veiculo->cliente,
            ]);
        }

        return response()->json(['success' => false]);
    });

    Route::get('/testar-dados', [OrdemServicoController::class, 'testarDados']);

    Route::resource('veiculos', VeiculoController::class);
    Route::get('/veiculo/buscar/{placa}', [VeiculoController::class, 'buscarPorPlaca']);

    Route::resource('mecanicos', MecanicoController::class);
    Route::resource('modulos', ModuloController::class);
    Route::resource('ordem_servico_itens', OrdemServicoItemController::class);
    /

    /*
    |--------------------------------------------------------------------------
    | PADOCA
    |--------------------------------------------------------------------------
    */

    Route::prefix('padoca')->name('padoca.')->group(function () {
        Route::get('/encomendas', [EncomendaController::class, 'index'])
            ->name('encomendas.index');

        Route::get('/encomendas/create', [EncomendaController::class, 'create'])
            ->name('encomendas.create');

        Route::post('/encomendas', [EncomendaController::class, 'store'])
            ->name('encomendas.store');

        Route::get('/encomendas/{encomenda}', [EncomendaController::class, 'show'])
            ->name('encomendas.show');

        Route::get('/encomendas/{encomenda}/edit', [EncomendaController::class, 'edit'])
            ->name('encomendas.edit');

        Route::put('/encomendas/{encomenda}', [EncomendaController::class, 'update'])
            ->name('encomendas.update');

        Route::delete('/encomendas/{encomenda}', [EncomendaController::class, 'destroy'])
            ->name('encomendas.destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | SUPORTE, MANUAL E DURAÇÃO
    |--------------------------------------------------------------------------
    */

    Route::post('/chat-suporte', [ChatSuporteController::class, 'perguntar'])
        ->name('chat.suporte');

    Route::resource('duracao', ClienteProdutoDuracaoController::class);

    Route::get('/manual', function () {
        return view('manual.index');
    })->name('manual.index');
});

// ROTA MOTORISTA
Route::middleware(['auth'])->group(function () {
    Route::resource('motoristas', MotoristaController::class);
});
// comissao motorista
Route::middleware(['auth'])->group(function () {
    Route::get('/relatorios/comissoes', [RelatorioComissaoController::class, 'index'])
        ->name('relatorios.comissoes.index');

       
Route::get('/relatorios/comissoes/pdf', [RelatorioComissaoController::class, 'pdf'])
    ->name('relatorios.comissoes.pdf');
});


// EMPRESA DE ATENDIMENTO MASTER

Route::post('/empresa-atendimento/trocar', [EmpresaAtendimentoController::class, 'trocar'])
    ->name('empresa-atendimento.trocar')
    ->middleware('auth');

Route::post('/empresa-atendimento/limpar', [EmpresaAtendimentoController::class, 'limpar'])
    ->name('empresa-atendimento.limpar')
    ->middleware('auth');


 // rota  previsão de giro e caixa
Route::get('/dashboard/previsao-giro-caixa', [DashboardController::class, 'previsaoGiroCaixa'])
    ->name('dashboard.previsao-giro-caixa');

// TORA PARA RELATÓRIO DE MARGEM POR EMISSÃO
    Route::get('/relatorios/margem-emissao', [RelatorioMargemEmissaoController::class, 'index'])
    ->name('relatorios.margem-emissao');

    Route::get('/relatorios/margem-emissao/exportar', [RelatorioMargemEmissaoController::class, 'exportar'])
    ->name('relatorios.margem-emissao.exportar');


   //   rota salao do seletor de modulos
   

Route::middleware('auth')->get('/menu/salao', function () {
    $usuario = auth()->user();

    if (!$usuario || !$usuario->temPermissao('salao_acessar')) {
        return redirect('/sga')
            ->with(
                'error',
                'Você não possui permissão para acessar o módulo Salão / Barbearia.'
            );
    }

    /*
     * MASTER usa a empresa escolhida no seletor.
     * Os demais usuários usam sua própria empresa.
     */
    $empresa = $usuario->isMaster()
        ? (empresaAtual() ?? $usuario->empresa)
        : $usuario->empresa;

    if (!$empresa) {
        return redirect('/sga')
            ->with(
                'error',
                'Nenhuma empresa foi identificada para o acesso ao Salão.'
            );
    }

    $secret = config('services.salao_sso.secret');
    $salaoUrl = rtrim(
        (string) config('services.salao_sso.url'),
        '/'
    );

    if (!$secret || !$salaoUrl) {
        return redirect('/sga')
            ->with(
                'error',
                'A integração com o Salão não está configurada.'
            );
    }

    /*
     * MASTER recebe todas as permissões cadastradas
     * para o módulo Salão.
     */
    if ($usuario->isMaster()) {
        $permissoes = DB::table('permissoes')
            ->where('modulo', 'salao')
            ->orderBy('nome')
            ->pluck('nome')
            ->toArray();
    } else {
        /*
         * Usuário comum recebe somente as permissões
         * vinculadas ao perfil dele.
         */
        $permissoes = DB::table('perfil_permissoes as pp')
            ->join(
                'permissoes as p',
                'p.id',
                '=',
                'pp.permissao_id'
            )
            ->where('pp.perfil_id', $usuario->perfil_id)
            ->where('p.modulo', 'salao')
            ->orderBy('p.nome')
            ->pluck('p.nome')
            ->toArray();
    }

    $permissoes = array_values(
        array_unique(
            array_map('strval', $permissoes)
        )
    );

    /*
     * Codifica a lista para ser transportada pela URL.
     * Ela também será incluída na assinatura.
     */
    $permissoesCodificadas = base64_encode(
        json_encode(
            $permissoes,
            JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
        )
    );

    $dados = [
        'user_id' => $usuario->id,
        'empresa_id' => $empresa->id,
        'nome' => $usuario->nome_completo
            ?? $usuario->usuario
            ?? 'Usuário',
        'usuario' => $usuario->usuario ?? '',
        'email' => $usuario->email,
        'tipo' => strtoupper(
            $usuario->tipo ?? 'FUNCIONARIO'
        ),
        'perfil_id' => $usuario->perfil_id ?? '',
        'permissoes' => $permissoesCodificadas,
        'expires' => now()->addSeconds(60)->timestamp,
        'nonce' => (string) Str::uuid(),
    ];

    /*
     * A ordem precisa ser idêntica à utilizada
     * no SgaLoginController do Salão.
     */
    $payload = implode('|', [
        (string) $dados['user_id'],
        (string) $dados['empresa_id'],
        (string) $dados['nome'],
        (string) $dados['usuario'],
        (string) $dados['email'],
        (string) $dados['tipo'],
        (string) $dados['perfil_id'],
        (string) $dados['permissoes'],
        (string) $dados['expires'],
        (string) $dados['nonce'],
    ]);

    $dados['signature'] = hash_hmac(
        'sha256',
        $payload,
        $secret
    );

    return redirect()->away(
        $salaoUrl
        . '/acesso-sga?'
        . http_build_query($dados)
    );
})->name('menu.salao');