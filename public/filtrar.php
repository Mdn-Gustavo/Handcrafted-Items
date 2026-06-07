<?php
require_once __DIR__ . '/../app/core/Security.php';
require_once __DIR__ . '/../app/controllers/ProdutoController.php';
require_once __DIR__ . '/../app/controllers/CategoriaController.php';

$produtoController = new ProdutoController();
$categoriaController = new CategoriaController();

$categoriaId = isset($_GET['categoria_id']) && ctype_digit((string) $_GET['categoria_id']) ? (int) $_GET['categoria_id'] : null;
$destaque = isset($_GET['destaque']) && $_GET['destaque'] === '1';
$ordem = $_GET['ordem'] ?? 'padrao';
$busca = trim($_GET['busca'] ?? '');

$categorias = $categoriaController->index();
$produtos = $produtoController->filtrar($categoriaId, $destaque, $ordem, $busca);

function link_filtro(array $novosParametros): string
{
    $params = array_merge($_GET, $novosParametros);

    foreach ($params as $chave => $valor) {
        if ($valor === null || $valor === '') {
            unset($params[$chave]);
        }
    }

    $query = http_build_query($params);

    return 'filtrar.php' . ($query ? '?' . $query : '');
}

include __DIR__ . '/../app/views/templates/cabecalho.php';
?>
<main class="container my-5">
    <header class="text-center mb-5">
        <h1 class="display-5 font-artesanal">Filtrar produtos</h1>
        <p class="text-muted">Use categoria, destaque, busca e ordenação para encontrar um item.</p>
    </header>

    <div class="row">
        <aside class="col-lg-3 mb-4">
            <section class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <h2 class="h5 card-title">Busca</h2>
                    <form method="GET" action="filtrar.php">
                        <?php if ($categoriaId): ?><input type="hidden" name="categoria_id" value="<?= (int) $categoriaId ?>"><?php endif; ?>
                        <?php if ($destaque): ?><input type="hidden" name="destaque" value="1"><?php endif; ?>
                        <?php if ($ordem !== 'padrao'): ?><input type="hidden" name="ordem" value="<?= e($ordem) ?>"><?php endif; ?>
                        <input type="text" name="busca" class="form-control mb-2" value="<?= e($busca) ?>" placeholder="Nome ou descrição">
                        <button class="btn btn-dark w-100" type="submit">Buscar</button>
                    </form>
                </div>
            </section>

            <section class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <h2 class="h5 card-title">Categoria</h2>
                    <a href="<?= e(link_filtro(['categoria_id' => null])) ?>" class="d-block mb-2 <?= $categoriaId === null ? 'fw-bold text-dark' : 'text-muted' ?>">Todas</a>
                    <?php foreach ($categorias as $categoria): ?>
                        <a href="<?= e(link_filtro(['categoria_id' => $categoria['id']])) ?>" class="d-block mb-2 <?= $categoriaId === (int) $categoria['id'] ? 'fw-bold text-dark' : 'text-muted' ?>">
                            <?= e($categoria['nome']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <h2 class="h5 card-title">Destaque</h2>
                    <?php if ($destaque): ?>
                        <a href="<?= e(link_filtro(['destaque' => null])) ?>" class="btn btn-outline-secondary btn-sm w-100">Remover destaque</a>
                    <?php else: ?>
                        <a href="<?= e(link_filtro(['destaque' => '1'])) ?>" class="btn btn-outline-warning btn-sm w-100">Apenas destaques</a>
                    <?php endif; ?>
                </div>
            </section>

            <section class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <h2 class="h5 card-title">Ordenar</h2>
                    <?php
                    $opcoes = [
                        'padrao' => 'Padrão',
                        'preco_asc' => 'Menor preço',
                        'preco_desc' => 'Maior preço',
                        'nome_az' => 'Nome A-Z',
                        'nome_za' => 'Nome Z-A',
                    ];
                    ?>
                    <?php foreach ($opcoes as $valor => $label): ?>
                        <a href="<?= e(link_filtro(['ordem' => $valor])) ?>" class="d-block mb-2 <?= $ordem === $valor ? 'fw-bold text-dark' : 'text-muted' ?>"><?= e($label) ?></a>
                    <?php endforeach; ?>
                </div>
            </section>

            <a href="filtrar.php" class="btn btn-danger btn-sm w-100">Limpar filtros</a>
        </aside>

        <section class="col-lg-9" aria-label="Produtos filtrados">
            <div class="alert alert-light border mb-4"><strong><?= count($produtos) ?></strong> produto(s) encontrado(s).</div>

            <?php if (empty($produtos)): ?>
                <div class="alert alert-warning text-center">Nenhum produto corresponde aos filtros.</div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($produtos as $produto): ?>
                        <article class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm card-hover-efeito">
                                <img src="assets/css/images/<?= e($produto['imagem']) ?>" class="card-img-top img-card-catalogo" alt="<?= e($produto['nome']) ?>">
                                <div class="card-body d-flex flex-column">
                                    <span class="badge bg-light text-dark border align-self-start mb-2"><?= e($produto['categoria']) ?></span>
                                    <h3 class="h5 card-title"><?= e($produto['nome']) ?></h3>
                                    <p class="card-text text-muted small flex-grow-1"><?= e($produto['descricao']) ?></p>
                                    <p class="h5 text-success fw-bold">R$ <?= number_format((float) $produto['preco'], 2, ',', '.') ?></p>
                                    <a href="detalhes.php?id=<?= (int) $produto['id'] ?>" class="btn btn-dark w-100 mt-auto">Ver detalhes</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>
<?php include __DIR__ . '/../app/views/templates/rodape.php'; ?>
