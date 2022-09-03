<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bairro extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'tb_bairro';

    public $incrementing = true;

    protected $primaryKey = 'codigo_bairro';

    protected $fillable = [
        'codigo_bairro',
        'codigo_municipio',
        'nome',
        'status'
    ];

//    public function enderecos()
//    {
//        return $this->hasMany(Endereco::class, 'codigo_pessoa');
//    }
}
