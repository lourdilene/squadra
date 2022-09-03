<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'tb_municipio';

    public $incrementing = true;

    protected $primaryKey = 'codigo_municipio';

    protected $fillable = [
        'codigo_uf',
        'nome',
        'status'
    ];

//    public function enderecos()
//    {
//        return $this->hasMany(Endereco::class, 'codigo_pessoa');
//    }
}
