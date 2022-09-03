<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uf extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'tb_uf';

    public $incrementing = true;

    protected $primaryKey = 'codigo_uf';

    protected $fillable = [
        'codigo_uf',
        'sigla',
        'nome',
        'status'
    ];

//    public function enderecos()
//    {
//        return $this->hasMany(Endereco::class, 'codigo_pessoa');
//    }
}
