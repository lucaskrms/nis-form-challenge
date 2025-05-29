
# Cadastro de Cidadãos com NIS

Este é um sistema simples desenvolvido em **PHP**, com objetivo de cadastrar cidadãos, gerar um número **NIS (Número de Identificação Social)** único, e permitir a busca por esse número.

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

Acesse no navegador
* http://localhost:8000

## Como executar os testes com PHPUnit

Na raiz do projeto, execute:

```bash
  ./vendor/bin/phpunit --testdox
```

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

## Arquitetura

Este projeto segue uma arquitetura MVC com adição de camadas de serviço e repository para maior separação de responsabilidades:
- Entity: Representa os dados e estrutura do domínio.
- Repository: Responsável pela persistência e recuperação dos dados.
- Service: Camada de lógica de negócio, como geração do NIS e validações.
- Controller: Lida com a entrada do usuário, manipula os dados via service e define a view.
- Router: Direciona as requisições.
- View: Telas HTML que exibem os formulários e os resultados.

## Banco de Dados 

Para o contexto desse desafio, foi escolhido o banco SQLite.
Ao iniciar o servidor PHP, a tabela contendo cidadãos (`Citizens`) é inicializada. 
Se o arquivo `/storage/database.sqlite` ainda não existir na raiz do projeto, a tabela será criada.

## Testes Unitários

A aplicação possui uma suíte de testes unitários que cobre as principais funcionalidades do backend. Os testes foram escritos utilizando o framework PHPUnit e focam em:
- Validação da criação (registro) de cidadãos com nomes válidos e inválidos.
- Busca de cidadãos pelo número NIS, incluindo casos de sucesso, falha por NIS inválido e casos em que o cidadão não é encontrado.
- Tratamento de exceções, garantindo que erros inesperados (ex.: falhas no banco de dados) sejam capturados e tratados adequadamente.
