<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'tb_endereco';

    protected $primaryKey = 'codigo_endereco';

    protected $fillable = [
        'codigo_pessoa',
        'codigo_bairro',
        'nome_rua',
        'numero',
        'complemento',
        'cep'
    ];

    public function pessoa()
    {
        return $this->belongsTo(Uf::class, 'codigo_endereco');
    }
}
