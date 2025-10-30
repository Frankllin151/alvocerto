<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstagioContato extends Model
{
    protected $table = 'estagio_contato';

    protected $fillable = [
        'nome',
    ];
}
