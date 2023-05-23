

## Trabalho para disciplina de POO com Banco de Dados pela Escola Politécnica - PUCGO

Ambiente que implemnta um CRUD em integração com banco de dados POSTGRESQL.

### Este trabalho está dividido em duas partes, o Banco de dados e a aplicação

> Banco de dados esta presente no arquivo 'Schema.sql', O mesmo deve ser criado usando o ambiente do postgres (PSQL ou PGADMIN)

>Aplicação: O resto desse Repositório :D

Foi desenvolvido em PHP-Laravel + InertiaJS + VueJs e TailWind para estilização.

## Como Subir?

Primeiro as dependências são:
 - PHP 8.2 + dependencias... (php-pgsql...)
 - Composer 2.5.*
 - Node v18.*

1 - Suba o Banco de dados e configure o mesmo no arquivo .env do projeto ( caso não tenha basta copiar o .env.example).

O principal é essa parte configurada:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=postgres

```

2 - rodar o composer para baixar as dependecias:
```
composer install
```
3 - Rodar o node para baixar as dependências

```
npm install
```
4 - Migrar a tabela de usuario padrão do laravel

```
php artisan migrate
```

pronto, basta servir agora

```
php artisan serve
```
+

```
npm run dev
```




