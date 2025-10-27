<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nicho extends Model
{
    use HasFactory;

    protected $table = 'nichos';

    protected $fillable = [
        'nicho',
    ];

    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'nicho_id');
    }

}
