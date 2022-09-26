<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'tb_pessoa';

    public $incrementing = true;

    protected $primaryKey = 'codigo_pessoa';

    protected $fillable = [
        'nome',
        'sobrenome',
        'idade',
        'login',
        'senha',
        'status'
    ];

    public function enderecos()
    {
        return $this->hasMany(Endereco::class, 'codigo_pessoa');
    }
}
