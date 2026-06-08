# Handcrafted Items

Sistema de catálogo para produtos artesanais desenvolvido em PHP utilizando arquitetura MVC parcial e banco de dados MariaDB.

## Objetivo

O projeto foi criado com o objetivo de praticar conceitos de desenvolvimento web utilizando PHP moderno, organização de código, acesso a banco de dados com PDO e separação de responsabilidades entre camadas da aplicação.

## Tecnologias Utilizadas

* PHP 8.5
* MariaDB
* PDO
* HTML5
* CSS3
* Bootstrap 5
* Git
* GitHub
* Codeberg

## Estrutura do Projeto

```
Handcrafted-Items/
├── app/
│   └── controllers/
├── config/
│   └── Database.php
├── database/
│   └── Script.sql
├── models/
│   ├── Produto.php
│   ├── Categoria.php
│   └── Usuario.php
├── public/
│   ├── assets/
│   ├── index.php
│   ├── detalhes.php
│   ├── filtrar.php
│   └── login.php
├── cabecalho.php
├── rodape.php
├── secure.php
└── logout.php
```

## Funcionalidades

### Catálogo de Produtos

* Listagem de produtos cadastrados
* Exibição de imagens
* Exibição de preços
* Controle de estoque
* Produtos em destaque

### Filtros

* Filtrar por categoria
* Filtrar produtos em destaque
* Ordenar por nome
* Ordenar por preço crescente
* Ordenar por preço decrescente

### Página de Detalhes

* Visualização completa do produto
* Informações detalhadas
* Categoria do produto
* Status de estoque
* Produtos relacionados

### Autenticação

* Login de usuários
* Controle de acesso a páginas protegidas
* Encerramento de sessão (logout)

## Banco de Dados

O sistema utiliza um banco de dados relacional com as seguintes entidades:

### Categorias

Responsável por armazenar os tipos de produtos.

Exemplos:

* Cerâmica
* Sabonetes
* Velas Artesanais

### Produtos

Responsável por armazenar os itens do catálogo.

Campos principais:

* Nome
* Descrição
* Preço
* Imagem
* Estoque
* Destaque
* Categoria

### Usuários

Responsável pelo controle de autenticação do sistema.

## Arquitetura

O projeto utiliza uma estrutura baseada em MVC parcial.

### Models

Responsáveis pela comunicação com o banco de dados.

Exemplos:

* Produto.php
* Categoria.php
* Usuario.php

### Controllers

Responsáveis pela lógica da aplicação.

Exemplos:

* ProdutoController.php
* CategoriaController.php
* UsuarioController.php

### Views

Responsáveis pela interface apresentada ao usuário.

## Relacionamento entre Tabelas

Cada produto pertence a uma categoria.

```
categorias
    |
    | 1:N
    |
produtos
```

A consulta dos produtos é realizada utilizando JOIN para recuperar também o nome da categoria associada.

## Configuração

### 1. Criar o banco de dados

Execute o script localizado em:

```
database/Script.sql
```

### 2. Configurar acesso ao banco

Arquivo:

```
config/Database.php
```

Exemplo:

```php
private string $host = "localhost";
private string $dbname = "handcrafted_items";
private string $user = "seu_usuario";
private string $password = "sua_senha";
```

### 3. Iniciar servidor local

A partir da raiz do projeto:

```bash
php -S localhost:8000 -t public
```

Acesse:

```
http://localhost:8000
```

## Aprendizados

Durante o desenvolvimento deste projeto foram aplicados conceitos como:

* Organização de projetos PHP
* Programação orientada a objetos
* PDO
* Relacionamentos em banco de dados
* SQL JOIN
* Estrutura MVC
* Controle de sessões
* Versionamento com Git
* Hospedagem de código no GitHub e Codeberg

## Autor

Gustavo Medina
Pedro Tomazi
Tales Mácola
Henrique Funes

Desenvolvido como projeto de estudo para aprofundamento em PHP, banco de dados e desenvolvimento web.
