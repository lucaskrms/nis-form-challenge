
# Desafio: Cadastro de Cidadãos com NIS

Este é um sistema simples desenvolvido em **PHP**, com objetivo de cadastrar cidadãos, gerar um número **NIS (Número de Identificação Social)** único, e permitir a busca por esse número.

## Regras de Negócio

### Cadastro de Cidadão

- O nome do cidadão é obrigatório.
- O nome deve conter **pelo menos duas palavras** (ex: `João Silva`).
- Nomes compostos por apenas espaços em branco ou palavras únicas são considerados inválidos.
- Não há validação de tipo de caractere (nomes como `a b` são permitidos).
- Um NIS único de **11 dígitos** é gerado automaticamente no momento do cadastro.
- O cidadão é salvo em uma base de dados SQLite.

### Consulta de Cidadão

- Preenchimento do NIS é obrigatório.
- O NIS para ser considerado válido nesse contexto, deve possuir **exatamente 11 caracteres numéricos**.

## Como executar o projeto

📌 Requisitos

* PHP 8.0+
* SQLite 3
* Composer

Clone o projeto

```bash
  git clone https://github.com/lucaskrms/nis-form-challenge.git
```

Entre no diretório do projeto

```bash
  cd nis-form-challenge
```

Instale as dependências

```bash
  composer install
```

Inicie o servidor PHP

```bash
  php -S localhost:8000 -t public
```

## Como executar os testes com PHPUnit

Execute

```bash
  ./vendor/bin/phpunit --testdox
```
