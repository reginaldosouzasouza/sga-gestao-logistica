<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caixa;
use App\Models\CaixaMovimentacao;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CaixaController extends Controller
{
    /**
     * Exibir o status do caixa.
     */
    public function index()
    {
        $caixa = Caixa::where('status', 'aberto')->latest()->first();
        return view('caixa.index', compact('caixa'));
    }

    /**
     * Abrir o caixa.
     */
    public function abrirCaixa(Request $request)
    {
        $request->validate([
            'saldo_inicial' => 'required|numeric',
        ]);
    
        // Substituir vírgula por ponto antes de salvar
        $saldo_inicial = str_replace(',', '.', $request->input('saldo_inicial'));
    
        // Verifica se já existe um caixa aberto
        if (Caixa::where('status', 'aberto')->exists()) {
            return back()->with('error', 'Já existe um caixa aberto!');
        }
    
        // Criar um novo caixa
        Caixa::create([
            'data_abertura' => now(),
            'saldo_inicial' => $saldo_inicial,
            'status' => 'aberto',
            'usuario_id' => auth()->id(),
        ]);
    
        return redirect()->route('caixa.index')->with('success', 'Caixa aberto com sucesso!');
    }
    
    /**
     * Fechar o caixa.
     */
    public function fecharCaixa()
{
    $caixa = Caixa::where('status', 'aberto')->latest()->first();

    if (!$caixa) {
        return back()->with('error', 'Nenhum caixa aberto para fechar.');
    }

    // Calcular saldo final (saldo inicial + entradas - saídas)
    $saldoFinal = $caixa->saldo_inicial + 
                  $caixa->movimentacoes()->where('tipo', 'entrada')->sum('valor') - 
                  $caixa->movimentacoes()->where('tipo', 'saida')->sum('valor');

    // Atualizar o caixa como fechado
    $caixa->update([
        'status' => 'fechado',
        'saldo_final' => $saldoFinal,
        'data_fechamento' => now(),
    ]);

    return redirect()->route('caixa.index')->with('success', 'Caixa fechado com sucesso! Saldo final: R$ ' . number_format($saldoFinal, 2, ',', '.'));
}


    /**
     * Registrar movimentações no caixa.
     */
    public function registrarMovimentacao(Request $request)
    {
        $caixa = Caixa::where('status', 'aberto')->latest()->first();
    
        if (!$caixa) {
            return back()->with('error', 'Nenhum caixa aberto para registrar movimentações!');
        }
    
        // Validação dos campos
        $request->validate([
            'tipo' => 'required|in:entrada,saida',
            'descricao' => 'required|string|max:255',
            'valor' => 'required|string', // Alterado para string para tratamento manual
        ]);
    
        // Substituir vírgula por ponto no valor antes de salvar
        $valorFormatado = str_replace(',', '.', $request->input('valor'));
    
        // Garantir que o valor é numérico
        if (!is_numeric($valorFormatado)) {
            return back()->with('error', 'O valor informado é inválido!');
        }
    
        // Criar o registro da movimentação
        CaixaMovimentacao::create([
            'caixa_id' => $caixa->id,
            'tipo' => $request->input('tipo'),
            'descricao' => $request->input('descricao'),
            'valor' => (float) $valorFormatado, // Converter para número decimal
            'metodo_pagamento' => 'dinheiro', // Melhorar para permitir escolha
            'usuario_id' => auth()->id(),
        ]);
    
        return redirect()->route('caixa.index')->with('success', 'Movimentação registrada com sucesso!');
    }

    public function destroy($id)
    {
        $movimentacao = CaixaMovimentacao::find($id);

        if (!$movimentacao) {
            return redirect()->back()->with('error', 'Movimentação não encontrada!');
        }

        // Atualizar o saldo antes de excluir a movimentação
        if ($movimentacao->tipo === 'Entrada') {
            $movimentacao->caixa->saldo_atual -= $movimentacao->valor;
        } elseif ($movimentacao->tipo === 'Saída') {
            $movimentacao->caixa->saldo_atual += $movimentacao->valor;
        }
        $movimentacao->caixa->save();

        // Excluir a movimentação
        $movimentacao->delete();

        return redirect()->back()->with('success', 'Movimentação excluída com sucesso!');
    }

    
}
