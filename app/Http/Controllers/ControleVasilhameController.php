<?php

namespace App\Http\Controllers;

use App\Models\ControleVasilhame;
use App\Models\HistoricoVasilhame;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ControleVasilhameController extends Controller
{
    public function index()
    {
        $controle = ControleVasilhame::latest('data_referencia')->first();

        $historico = ControleVasilhame::orderBy('data_referencia', 'desc')
            ->paginate(10);

        return view('controle-vasilhames.index', compact('controle', 'historico'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_referencia'   => 'required|date',
            'total_vasilhames'  => 'required|integer|min:0',
            'cheios'            => 'required|integer|min:0',
            'vazios'            => 'required|integer|min:0',
            'emprestados'       => 'required|integer|min:0',
            'vendidos'          => 'required|integer|min:0',
            'retornaram'        => 'nullable|integer|min:0',
            'observacao'        => 'nullable|string',
        ]);

        $controle = ControleVasilhame::create([
            'data_referencia'  => $request->data_referencia,
            'total_vasilhames' => $request->total_vasilhames,
            'cheios'           => $request->cheios,
            'vazios'           => $request->vazios,
            'emprestados'      => $request->emprestados,
            'vendidos'         => $request->vendidos,
            'retornaram'       => $request->retornaram ?? 0,
            'observacao'       => $request->observacao,
        ]);

        HistoricoVasilhame::create([
            'controle_vasilhame_id' => $controle->id,
            'tipo_movimento'        => 'cadastro',
            'quantidade'            => $controle->total_sob_controle,
            'responsavel'           => null,
            'cliente'               => null,
            'descricao'             => 'Cadastro do controle diário em ' . Carbon::parse($controle->data_referencia)->format('d/m/Y'),
        ]);

        return redirect()
            ->route('controle-vasilhames.index')
            ->with('success', 'Controle de vasilhames salvo com sucesso.');
    }

    public function edit($id)
    {
        $controle = ControleVasilhame::findOrFail($id);

        $historico = ControleVasilhame::orderBy('data_referencia', 'desc')
            ->paginate(10);

        return view('controle-vasilhames.index', compact('controle', 'historico'));
    }

    public function update(Request $request, $id)
    {
        $controle = ControleVasilhame::findOrFail($id);

        $request->validate([
            'data_referencia'   => 'required|date',
            'total_vasilhames'  => 'required|integer|min:0',
            'cheios'            => 'required|integer|min:0',
            'vazios'            => 'required|integer|min:0',
            'emprestados'       => 'required|integer|min:0',
            'vendidos'          => 'required|integer|min:0',
            'retornaram'        => 'nullable|integer|min:0',
            'observacao'        => 'nullable|string',
        ]);

        $controle->update([
            'data_referencia'  => $request->data_referencia,
            'total_vasilhames' => $request->total_vasilhames,
            'cheios'           => $request->cheios,
            'vazios'           => $request->vazios,
            'emprestados'      => $request->emprestados,
            'vendidos'         => $request->vendidos,
            'retornaram'       => $request->retornaram ?? 0,
            'observacao'       => $request->observacao,
        ]);

        HistoricoVasilhame::create([
            'controle_vasilhame_id' => $controle->id,
            'tipo_movimento'        => 'edicao',
            'quantidade'            => $controle->total_sob_controle,
            'responsavel'           => null,
            'cliente'               => null,
            'descricao'             => 'Edição do controle diário em ' . Carbon::parse($controle->data_referencia)->format('d/m/Y'),
        ]);

        return redirect()
            ->route('controle-vasilhames.index')
            ->with('success', 'Controle de vasilhames atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $controle = ControleVasilhame::findOrFail($id);

        HistoricoVasilhame::create([
            'controle_vasilhame_id' => $controle->id,
            'tipo_movimento'        => 'exclusao',
            'quantidade'            => $controle->total_sob_controle,
            'responsavel'           => null,
            'cliente'               => null,
            'descricao'             => 'Exclusão do controle diário em ' . Carbon::parse($controle->data_referencia)->format('d/m/Y'),
        ]);

        $controle->delete();

        return redirect()
            ->route('controle-vasilhames.index')
            ->with('success', 'Controle de vasilhames excluído com sucesso.');
    }
}
