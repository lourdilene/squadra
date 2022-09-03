<?php

namespace App\Repositories;

use App\Http\Requests\StoreUpdatePessoaRequest;
use App\Models\Pessoa;

interface PessoaRepository
{
    public function add(StoreUpdatePessoaRequest $request): Pessoa;
}
