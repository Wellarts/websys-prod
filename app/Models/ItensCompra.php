<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItensCompra extends Model
{
    use HasFactory;

    protected $fillable = [
        'compra_id',
        'produto_id',
        'valor_compra',
        'qtd',
        'sub_total',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

}
