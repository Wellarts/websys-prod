<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
            'nome',
            'estoque',
            'valor_compra',
            'lucratividade',
            'valor_venda',
    ];

    public function ProdutoFornecedor() 
    {
        return $this->hasMany(ProdutoFornecedor::class);
    }

    public function itensCompra() 
    {
        return $this->hasMany(ItensCompra::class);
    }
}
