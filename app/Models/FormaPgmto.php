<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPgmto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome'
    ];

    public function venda()
    {
        return $this->hasMany(Venda::class);
    }
}
