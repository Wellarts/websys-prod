<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [

            'fornecedor_id',
            'data_compra',
            'outros_custos',
            'valor_total',
            'obs',
        ];

        public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }

    public function itensCompra() 
    {
        return $this->hasMany(ItensCompra::class);
    }

    public function ProdutoFornecedor() 
    {
        return $this->hasMany(ProdutoFornecedor::class);
    }

    public function contasPagar() 
    {
        return $this->hasMany(contasPagar::class);
    }
}
