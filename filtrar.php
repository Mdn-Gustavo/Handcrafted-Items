<?php

define("ACESSO_PERMITIDO", true);
require_once __DIR__ . "/models/Categoria.php";
require_once __DIR__ . "/models/Produto.php";

$categoriaModel = new Categoria();
$produtoModel = new Produto();

$categorias = array_column($categoriaModel->all(), "nome");
$produtos = $produtoModel->all();

$filtro_categoria = null;
if (isset($_GET["categoria"]) && $_GET["categoria"] !== "") {
    $candidata = trim($_GET["categoria"]);
    if (in_array($candidata, $categorias, true)) {
        $filtro_categoria = $candidata;
    }
}

$ordens_validas = ["padrao", "preco_asc", "preco_desc", "nome_az", "nome_za"];
$filtro_ordem = "padrao";
if (isset($_GET["ordem"]) && in_array($_GET["ordem"], $ordens_validas, true)) {
    $filtro_ordem = $_GET["ordem"];
}
$filtro_destaque = isset($_GET["destaque"]) && $_GET["destaque"] === "1";
$produtos_filtrados = [];

foreach ($produtos as $produto) {
    if (
        $filtro_categoria !== null &&
        $produto["categoria"] !== $filtro_categoria
    ) {
        continue;
    }

    if ($filtro_destaque && (int) $produto["destaque"] !== 1) {
        continue;
    }

    $produtos_filtrados[] = $produto;
}

switch ($filtro_ordem) {
    case "preco_asc":
        usort($produtos_filtrados, function ($a, $b) {
            return $a["preco"] <=> $b["preco"];
        });
        break;

    case "preco_desc":
        usort($produtos_filtrados, function ($a, $b) {
            return $b["preco"] <=> $a["preco"];
        });
        break;

    case "nome_az":
        usort($produtos_filtrados, function ($a, $b) {
            return strcmp($a["nome"], $b["nome"]);
        });
        break;

    case "nome_za":
        usort($produtos_filtrados, function ($a, $b) {
            return strcmp($b["nome"], $a["nome"]);
        });
        break;

    default:
        break;
}

function url_filtro(string $chave, string $valor): string
{
    $params = $_GET;
    $params[$chave] = $valor;
    return "filtrar.php?" . http_build_query($params);
}

function url_remover_filtro(string $chave): string
{
    $params = $_GET;
    unset($params[$chave]);
    $query = http_build_query($params);
    return "filtrar.php" . ($query ? "?" . $query : "");
}

$titulo_pagina = $filtro_categoria
    ? "Categoria: " . ucfirst($filtro_categoria) . " — Handcrafted Items"
    : "Filtrar Produtos — Handcrafted Items";

include "cabecalho.php";
?>

<main class="container my-5">
    <header class="text-center mb-5">
        <h1 class="display-4 font-artesanal">Filtrar Produtos</h1>
        <p class="text-muted">Encontre exatamente o que você procura.</p>
    </header>

    <div class="row">
        <aside class="col-lg-3 mb-4">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Categoria</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="<?= url_remover_filtro("categoria") ?>"
                               class="text-decoration-none <?= $filtro_categoria ===
                               null
                                   ? "fw-bold text-dark"
                                   : "text-muted" ?>">
                                Todas as categorias
                            </a>
                        </li>
                        <?php foreach ($categorias as $cat): ?>
                            <li class="mb-2">
                                <a href="<?= url_filtro("categoria", $cat) ?>"
                                   class="text-decoration-none <?= $filtro_categoria ===
                                   $cat
                                       ? "fw-bold text-dark"
                                       : "text-muted" ?>">
                                    <?= htmlspecialchars(ucfirst($cat)) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Destaque</h5>
                    <?php if ($filtro_destaque): ?>
                        <a href="<?= url_remover_filtro(
                            "destaque",
                        ) ?>" class="btn btn-outline-secondary btn-sm w-100">
                            Ver todos (remover filtro)
                        </a>
                    <?php else: ?>
                        <a href="<?= url_filtro(
                            "destaque",
                            "1",
                        ) ?>" class="btn btn-outline-warning btn-sm w-100">
                            ⭐ Apenas destaques
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Ordenar por</h5>
                    <ul class="list-unstyled">
                        <?php
                        $opcoes_ordem = [
                            "padrao" => "Padrão",
                            "preco_asc" => "Menor preço",
                            "preco_desc" => "Maior preço",
                            "nome_az" => "Nome A→Z",
                            "nome_za" => "Nome Z→A",
                        ];
                        foreach ($opcoes_ordem as $valor => $label): ?>
                            <li class="mb-2">
                                <a href="<?= url_filtro("ordem", $valor) ?>"
                                   class="text-decoration-none <?= $filtro_ordem ===
                                   $valor
                                       ? "fw-bold text-dark"
                                       : "text-muted" ?>">
                                    <?= $label ?>
                                </a>
                            </li>
                        <?php endforeach;
                        ?>
                    </ul>
                </div>
            </div>

            <?php if (!empty($_GET)): ?>
                <a href="filtrar.php" class="btn btn-danger btn-sm w-100">
                    🗑️ Limpar todos os filtros
                </a>
            <?php endif; ?>
        </aside>
        <section class="col-lg-9">
            <div class="alert alert-light border mb-4" role="alert">
                <strong><?= count($produtos_filtrados) ?></strong>
                produto(s) encontrado(s)
                <?php if ($filtro_categoria): ?>
                    em <strong><?= htmlspecialchars(
                        ucfirst($filtro_categoria),
                    ) ?></strong>
                <?php endif; ?>
                <?php if ($filtro_destaque): ?>
                    · apenas <strong>destaques</strong>
                <?php endif; ?>
            </div>

            <?php if (empty($produtos_filtrados)): ?>
                <div class="text-center py-5">
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">😕 Nenhum produto encontrado</h4>
                        <p>Nenhum produto corresponde aos filtros selecionados.</p>
                        <hr>
                        <a href="filtrar.php" class="btn btn-dark">Ver todos os produtos</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($produtos_filtrados as $produto): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-0 card-hover-efeito">
                                <img src="assets/css/images/<?= htmlspecialchars(
                                    $produto["imagem"],
                                ) ?>"
                                     class="card-img-top img-card-catalogo"
                                     alt="<?= htmlspecialchars(
                                         $produto["nome"],
                                     ) ?>">

                                <div class="card-body d-flex flex-column">
                                    <div class="mb-2 d-flex justify-content-between align-items-center">
                                        <span class="badge bg-light text-dark border small">
                                            <?= htmlspecialchars(
                                                ucfirst($produto["categoria"]),
                                            ) ?>
                                        </span>
                                        <?php if ($produto["destaque"]): ?>
                                            <span class="badge bg-warning text-dark">⭐ Destaque</span>
                                        <?php endif; ?>
                                    </div>

                                    <h5 class="card-title"><?= htmlspecialchars(
                                        $produto["nome"],
                                    ) ?></h5>

                                    <p class="card-text text-muted small flex-grow-1">
                                        <?= htmlspecialchars(
                                            $produto["descricao"],
                                        ) ?>
                                    </p>

                                    <div class="mt-3">
                                        <p class="h5 text-success fw-bold">
                                            R$ <?= number_format(
                                                $produto["preco"],
                                                2,
                                                ",",
                                                ".",
                                            ) ?>
                                        </p>

                                        <?php if ($produto["estoque"] > 0): ?>
                                            <span class="badge bg-success mb-2">✓ Em estoque</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger mb-2">✗ Esgotado</span>
                                        <?php endif; ?>

                                        <a href="detalhes.php?id=<?= $produto[
                                            "id"
                                        ] ?>" class="btn btn-dark w-100 mt-2">
                                            Ver Detalhes
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php include "rodape.php"; ?>
