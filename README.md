# Laravel 9 + Swagger

Está aplicação utiliza o Docker containers, eis a lista:

* mysql - Database server
* laravel - API

## Como utilizar

### 1. Preparação

Clone o repositório do github e mude de diretório de trabalho

    git clone https://github.com/lourdilene/squadra.git
    cd squadra
    cp docker-compose.dist.yml docker-compose.yml

Dentro de `docker-compose.yml` você precisa alterar os valores para o que você precisa. 

Execute o seguinte comandando para criar os containers

    sail up

### 2. Instale todas as dependências necessárias

Acesse o container laravel:

    docker-compose exec laravel bash

Instale todas as dependências

    composer install

### 3. Configuração da aplicação

Crie as databases

    php artisan migrate:fresh --seed

### 4. Generate swagger

Gere a documentação da app:

    php artisan l5-swagger:generate

## Fim

Agora é só clicar nesse link [http://localhost/api/documentation](http://localhost/api/documentation) em seu navegador.

Obrigada :)
