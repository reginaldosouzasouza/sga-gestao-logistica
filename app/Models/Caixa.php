<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Caixa extends Model
{
    use HasFactory;

    protected $table = 'caixa';

    protected $fillable = [
        'data_movimentacao',
        'tipo',
        'valor',
        'origem',
        'descricao',
        'referencia_id',
        'forma'
    ];

    protected $casts = [
        'data_movimentacao' => 'datetime',
        'valor' => 'decimal:2',
    ];

     // ✅ SCOPE DO DIA
    public function scopeDoDia($query, $data)
    {
        return $query->whereDate('data_movimentacao', $data);
    }

    /**
     * Scope para filtrar por data
     */
    public function scopePorData($query, $data)
    {
        return $query->whereDate('data_movimentacao', $data);
    }

    /**
     * Scope para filtrar por período
     */
    public function scopePorPeriodo($query, $dataInicio, $dataFim)
    {
        return $query->whereBetween('data_movimentacao', [$dataInicio, $dataFim]);
    }

    /**
     * Scope para entradas
     */
    public function scopeEntradas($query)
    {
        return $query->where('tipo', 'entrada');
    }

    /**
     * Scope para saídas
     */
    public function scopeSaidas($query)
    {
        return $query->where('tipo', 'saida');
    }

    /**
     * Accessor para forma de pagamento
     */
    public function getFormaPagamentoAttribute()
    {
        return 'Dinheiro';
    }

    /**
     * Accessor para identificar origem da tabela
     */
    public function getOrigemTabelaAttribute()
    {
        return 'caixa';
    }


    public function destroyCaixaBanco($id)
{
    DB::transaction(function () use ($id) {

        $lancamento = CaixaBanco::findOrFail($id);

        // 🔒 BLOQUEIO OPCIONAL
        /*
        if ($lancamento->origem === 'venda') {
            abort(403, 'Lançamentos de venda não podem ser excluídos.');
        }
        */

        $lancamento->delete();
    });

    return redirect()->back()->with('success', 'Lançamento do banco excluído.');
}

}


