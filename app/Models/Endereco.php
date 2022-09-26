<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'tb_endereco';

    protected $primaryKey = 'codigo_endereco';

    protected $fillable = [
        'codigoPessoa',
        'codigoEndereco',
        'codigoBairro',
        'nomeRua',
        'numero',
        'complemento',
        'cep'
    ];

    protected function codigoPessoa(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value),
        );
    }

    protected function nomeRua(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value),
        );
    }

    protected function codigoBairro(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value),
        );
    }

    protected function numero(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value),
        );
    }

    protected function complemento(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value),
        );
    }

    protected function cep(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value),
        );
    }

    public function pessoa()
    {
        return $this->belongsTo(Uf::class, 'codigo_endereco');
    }
}
