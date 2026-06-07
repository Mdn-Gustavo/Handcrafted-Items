# Handcrafted Items

Sistema web acadêmico em PHP para catálogo e administração de produtos artesanais.

## Tema

Catálogo de produtos artesanais com área pública para visitantes e área restrita para gerenciamento.

## Requisitos atendidos

- PHP com organização em MVC simples.
- Models com POO e PDO.
- Prepared statements em todas as operações com dados variáveis.
- Login com `password_hash()` e `password_verify()`.
- Sessões para usuário logado.
- Cookies para último acesso e lembrar e-mail.
- Token CSRF em login, cadastro e formulários sensíveis.
- 3 CRUDs completos: produtos, categorias e usuários.
- 3 páginas públicas antes do login: catálogo, filtro e sobre.
- HTML semântico com Bootstrap e CSS próprio.

## Credenciais de teste

- E-mail: `admin@admin.com`
- Senha: `123456`

## Como rodar

1. Importe o banco pelo phpMyAdmin usando:

```text
database/Script.sql
```

2. Confira as credenciais do banco em:

```text
config/Database.php
```

Padrão atual:

```php
private string $host = 'localhost';
private string $dbname = 'handcrafted_items';
private string $user = 'root';
private string $password = '';
```

3. Rode o servidor local a partir da raiz do projeto:

```bash
php -S localhost:8000 -t public
```

4. Acesse:

```text
http://localhost:8000
```

Também foi mantido um `index.php` na raiz redirecionando para `public/index.php`, caso o usuario abra o projeto pela raiz no navegador.

## Estrutura principal

```text
Handcrafted-Items/
├── app/
│   ├── controllers/
│   │   ├── CategoriaController.php
│   │   ├── ProdutoController.php
│   │   └── UsuarioController.php
│   ├── core/
│   │   └── Security.php
│   ├── models/
│   │   ├── Categoria.php
│   │   ├── Produto.php
│   │   └── Usuario.php
│   └── views/
│       └── templates/
│           ├── cabecalho.php
│           └── rodape.php
├── config/
│   └── Database.php
├── database/
│   └── Script.sql
├── public/
│   ├── index.php
│   ├── filtrar.php
│   ├── sobre.php
│   ├── detalhes.php
│   ├── login.php
│   ├── cadastro.php
│   ├── dashboard.php
│   ├── produtos.php
│   ├── produto_cadastrar.php
│   ├── produto_editar.php
│   ├── produto_excluir.php
│   ├── categorias.php
│   ├── categoria_cadastrar.php
│   ├── categoria_editar.php
│   ├── categoria_excluir.php
│   ├── usuarios.php
│   ├── usuario_cadastrar.php
│   ├── usuario_editar.php
│   ├── usuario_excluir.php
│   └── sair.php
├── index.php
├── secure.php
├── logout.php
└── README.md
```

## Observação importante

O antigo `secure.php` concentrava coisa demais e quebrava caminhos relativos. Agora a área protegida começa em `public/dashboard.php`, e cada CRUD tem seu próprio arquivo público protegido por `require_login()`.
