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
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CaixaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\VeiculoController;




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

//RELATÓRIO DE COMPRAS
Route::get('/relatorio-compras', [ComprasController::class, 'relatorioCompras'])->name('relatorio.compras');

// rota de RELATÓRIO DE vendas 1
Route::get('/relatorios/vendas', [RelatorioController::class, 'vendas'])->name('relatorios.vendas');

// rota relatorio vendas por produto
Route::get('/relatorios/vendas-por-produto', [RelatorioController::class, 'vendasPorProduto'])->name('relatorios.vendasPorProduto');

// rota relatório de saldo de produto
Route::get('/relatorios/saldo_estoque', [RelatorioController::class, 'saldoEstoque'])->name('relatorios.saldoEstoque');




// ROTA VERIFICAR ESTOQUE DO PRODUTO NO MOMENTO DA VENDA
Route::get('/verificar-estoque', [ProdutoController::class, 'verificarEstoque']);

// rotas financeiro
Route::post('/contas_a_pagar/store', [ContasAPagarController::class, 'store'])->name('contas_a_pagar.store');
Route::resource('contas_a_pagar', ContasAPagarController::class);
Route::get('/contas-a-pagar', [ContasAPagarController::class, 'index'])->name('contas_a_pagar.index');
Route::get('/contas-a-pagar/{id}/edit', [ContasAPagarController::class, 'edit'])->name('contas_a_pagar.edit');
Route::put('/contas-a-pagar/{id}', [ContasAPagarController::class, 'update'])->name('contas_a_pagar.update');
Route::resource('contas-a-pagar', ContasAPagarController::class);
Route::resource('contas_a_receber', ContasAReceberController::class);
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

Route::get('/menu', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }
    return view('menu');
});


// ROTA PARA ACESSAR O SISTEMA


Route::middleware(['auth'])->group(function () {
    Route::get('/menu', function () {
        return view('menu'); // Certifique-se de que o nome do arquivo é menu.blade.php
    })->name('menu');
});

// ROTAS DO CAIXA 
Route::middleware(['auth'])->group(function () {
    Route::get('/caixa', [CaixaController::class, 'index'])->name('caixa.index');
    Route::post('/caixa/abrir', [CaixaController::class, 'abrirCaixa'])->name('caixa.abrir');
    Route::post('/caixa/fechar', [CaixaController::class, 'fecharCaixa'])->name('caixa.fechar');
    Route::post('/caixa/movimentacao', [CaixaController::class, 'registrarMovimentacao'])->name('caixa.movimentacao');
});

//DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

//EXCLUSAO DE LANÇAMENTOS DO CAIXA
Route::delete('/caixa/movimentacao/{id}', [CaixaController::class, 'destroy'])
    ->name('caixa.destroy');


// VEÍCULOS

Route::resource('veiculos', VeiculoController::class);








