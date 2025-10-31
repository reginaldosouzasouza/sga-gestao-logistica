<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
   protected $fillable = [
    'cliente',
    'marca',
    'veiculo',
    'placa',
    'cor',
    'ano',
    'combustivel',
    'observacoes',
];

}
