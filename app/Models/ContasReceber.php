<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContasReceber extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'venda_id',
        'parcelas',
        'ordem_parcela',
        'data_vencimento',
        'data_pagamento',
        'status',
        'valor_total',
        'valor_parcela',
        'valor_recebido',
        'obs'
    ];

    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
