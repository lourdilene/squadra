<?php

namespace App\Repositories;

use App\Http\Requests\StorePessoaRequest;
use App\Http\Requests\UpdatePessoaRequest;
use App\Models\Pessoa;

interface PessoaRepository
{
    public function add(StorePessoaRequest $request): Pessoa;
    public function update(UpdatePessoaRequest $request, int $id): Pessoa;
}
