<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contasPagar extends Model
{
    use HasFactory;

    protected $fillable = [
        'fornecedor_id',
        'compra_id',
        'parcelas',
        'data_vencimento',
        'data_pagamento',
        'status',
        'valor_total',
        'valor_parcela',
        'valor_recebido',
        'obs'
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }
}
