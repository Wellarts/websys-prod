<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
       
            'nome',
            'cpf_cnpj',
            'endereco',
            'estado_id',
            'cidade_id',
            'telefone',
            'email',
            
    ];

    public function Estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function Cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    public function contasReceber()
    {
        return $this->belongsTo(ContasReceber::class);
    }
}
