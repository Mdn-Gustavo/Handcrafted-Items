
<!--// -->
todas as paginas devem conter o include 'dados.php';
assim vao usar o mesmo array.

cada profuto precisa ter um id unico, sen da bosta e fica bagunçado
ex: "id" => i

pelas que fui ver, n é recomendado mostrar o hmtl direto, sempre temos que usar:

htmlspecialchars()

isso é basico mas sempre temos q validar o get no php

ex: if(isset($_GET['id']) && is_numeric($_GET['id']))



fiz um teste da nossa estrutura no chat e ele disse que, as coisas que mais darão erro sao:

*  iniciar sessao:
smpre tem que ter session_start() antes de qualquer html

* Redirecionamento do header:

n usar o - echo "oi";
header("Location: login.php");

tem q usar - header("Location: login.php");
exit;


n vamo ter banco de dado, nem api , nem painel complexo, cadastro de usuario.
professor que um php basicao bem feito.


sobre o github, sempre avisar oq forem comitar e demostrar oq estão addicionando seus vagabundos,
cada um vai fazer sua parte mas temos que entrar em conjunto.

tava pensando em separar tudo em partes tlgd, tipo etapas.

etapa 1: primeiro vamo de visual né, a estrutura inteira visual.
etapa 2: listagem dos produtos ( ja comecamos a realmente fazer o trabalho)
etapa 3: detalhes
etapa 4: filtro
etapa 5: login
etapa 6: secure (area protegida)
etapa 7: cadastro
etapa 8: validacao e correcoes gerais.


pesquisei no chat como fariamos algo coeso ele me mandou isso como padrão obrigatorio do nosso trabalho, tem algumas coisas que eu ja falei pq eu pesquisei antes mas ta ai do mesmo jeito:

## PADRÃO DO PROJETO
* Nome do projeto

- Handcrafted-Items

* Tema
Catálogo de produtos artesanais

* Stack
PHP puro
HTML
CSS
Bootstrap
sem banco de dados
sem framework

* Dados

Todos os produtos virão de:
dados.php

* Segurança obrigatória

- Usar:
htmlspecialchars()
isset()
empty()
is_numeric()

* Sessão

Sempre:
session_start();
antes de qualquer HTML.

 * Estrutura visual

- Todos devem usar:

Bootstrap
cards
navbar escura elegante
estilo artesanal/minimalista

e tbm, algo q o chat n falou sobre os includes do rodape e do cabecalho:
include 'cabecalho.php';
include 'rodape.php'
isso tem que ter em todos os arquivos pra ficar deboas, mesma coisa com os dados.php
include 'dados.php';

 * Objetivo
Sistema simples, funcional e organizado.



##############################################################


eu aproveitei e pedi pra ele fazer uns prompts para cada um de nos  fazermos nossa parte tentando aprender e guiar nois, peguem o prompt dos seus respectivos papeis:


Pessoa1 (Frontend + Estrutura):

Estou desenvolvendo um mini projeto em PHP puro chamado "Handcrafted-Items", um catálogo de produtos artesanais.

Minha responsabilidade é:
- cabecalho.php
- rodape.php
- style.css
- responsividade
- layout visual
- Bootstrap
- navbar
- cards dos produtos

O projeto NÃO usa framework nem banco de dados.

Quero aprender:
1. Como estruturar um layout moderno usando Bootstrap
2. Como criar cards elegantes para produtos
3. Como criar uma navbar reutilizável em PHP usando include
4. Como organizar CSS em um projeto PHP
5. Como deixar o site responsivo
6. Como fazer um visual artesanal/minimalista elegante
7. Como estruturar um projeto frontend simples em PHP

Me ensine:
- teoria
- boas práticas
- estrutura ideal
- exemplos reais
- exemplos de código
- organização profissional de pastas

Considere que o restante da equipe fará:
- catálogo e filtros
- login e sessão

Então meu código precisa ser reutilizável e compatível com includes.

Pessoa2 (Catalogo + detalhes + filtro):

Estou desenvolvendo um mini projeto em PHP puro chamado "Handcrafted-Items", um catálogo de produtos artesanais.

Minha responsabilidade é:
- dados.php
- index.php
- detalhes.php
- filtrar.php

O sistema usa:
- arrays
- foreach
- GET
- filtros
- includes

NÃO usamos:
- banco de dados
- framework

Quero aprender:
1. Como estruturar arrays grandes em PHP
2. Como listar produtos usando foreach
3. Como enviar informações via GET
4. Como criar uma página de detalhes usando id
5. Como validar parâmetros GET
6. Como criar filtros por categoria
7. Como conectar páginas entre si
8. Como reutilizar dados.php em múltiplas páginas

Me ensine:
- teoria
- lógica
- exemplos reais
- exemplos completos de código
- boas práticas
- organização profissional

Considere que:
- outro integrante fará login/sessão
- outro fará frontend/layout

Meu código precisa funcionar perfeitamente integrado ao restante do projeto.


Pessoa3(Login + sessao + seguranca):

Estou desenvolvendo um mini projeto em PHP puro chamado "Handcrafted-Items", um catálogo de produtos artesanais.

Minha responsabilidade é:
- login.php
- logout.php
- secure.php
- sessões
- área protegida
- cadastro de produtos
- validações
- segurança

O projeto NÃO usa:
- banco de dados
- framework

Quero aprender:
1. Como funciona login em PHP puro
2. Como usar session_start()
3. Como proteger páginas usando sessão
4. Como redirecionar usuários corretamente
5. Como usar password_hash()
6. Como usar password_verify()
7. Como criar logout
8. Como adicionar produtos usando formulário POST
9. Como salvar dados na sessão
10. Como validar formulários corretamente
11. Como usar htmlspecialchars() para segurança

Me ensine:
- teoria
- fluxo completo de autenticação
- boas práticas
- exemplos reais
- exemplos completos
- segurança básica em PHP

Considere que:
- outro integrante fará frontend
- outro fará catálogo e filtros

Meu código precisa integrar perfeitamente com o restante do sistema.

qualquer coisa em mandem msg no whats seus bosta
