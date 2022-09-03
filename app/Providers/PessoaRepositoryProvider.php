<?php

namespace App\Providers;

use App\Repositories\EloquentPessoaRepository;
use App\Repositories\PessoaRepository;
use Illuminate\Support\ServiceProvider;

class PessoaRepositoryProvider extends ServiceProvider
{
    public array $bindings = [
        PessoaRepository::class => EloquentPessoaRepository::class
    ];
}
