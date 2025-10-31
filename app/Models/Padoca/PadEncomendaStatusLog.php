<?php

namespace App\Models\Padoca;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PadEncomendaStatusLog extends Model
{
    protected $connection = 'padaria';
    protected $table = 'pad_encomenda_status_logs';

    protected $fillable = [
        'encomenda_id',
        'status_anterior',
        'status_novo',
        'user_id',
        'observacao',
    ];

    public function encomenda(): BelongsTo
    {
        return $this->belongsTo(PadEncomenda::class, 'encomenda_id');
    }
}
