<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
     use HasFactory;

    // Define a tabela
    protected $table = 'clientes';

    // Campos preenchíveis
    protected $fillable = [
        'nomedaempresa',
        'email',
        'telefone',
        'nomedoresponsavel',
        'estagio_de_contato',
        'ultimo_contato_resultado',
        'ultimoContato',
        'quantidadeDeContato',
        'observacao',
        'nicho_id',
    ];

    // Cast para datetime
    protected $dates = [
        'ultimoContato',
    ];

    // Relacionamento: um cliente pertence a um nicho
    public function nicho()
    {
        return $this->belongsTo(Nicho::class, 'nicho_id');
    }
}
