<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'cpfCnpj', 
        'nome', 
        'email', 
        'celular', 
        'data_nascimento', 
        'sexo', 
        'cidade_id'
    ];

    /**
     * Relacionamento com a cidade.
     */
    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }
}
