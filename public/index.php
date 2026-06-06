<?php
define("ACESSO_PERMITIDO", true);

require_once __DIR__ . "/models/Produto.php";

$categoriaModel = new Categoria();
$produtoModel = new Produto();

$categorias = array_column($categoriaModel->all(), "nome");
$produtos = $produtoModel->all();

include __DIR__ . "/cabecalho.php";
?>

<main class="container my-5">
    <header class="text-center mb-5">
        <h1 class="display-4 font-artesanal">Catálogo Artesanal</h1>
        <p class="text-muted">Produtos feitos à mão com cuidado e carinho.</p>
    </header>

    <div class="row g-4">
        <?php foreach ($produtos as $p): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 card-hover-efeito">
                    <img src="assets/css/images/<?php echo $p["imagem"]; ?>"
                         class="card-img-top img-card-catalogo"
                         alt="<?php echo htmlspecialchars($p["nome"]); ?>">

                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge bg-light text-dark border small">
                                <?php echo htmlspecialchars($p["categoria"]); ?>
                            </span>
                        </div>

                        <h5 class="card-title"><?php echo htmlspecialchars(
                            $p["nome"],
                        ); ?></h5>

                        <p class="card-text text-muted small flex-grow-1">
                            <?php echo htmlspecialchars($p["descricao"]); ?>
                        </p>

                        <div class="mt-3">
                            <p class="h5 text-success fw-bold">
                                R$ <?php echo number_format(
                                    $p["preco"],
                                    2,
                                    ",",
                                    ".",
                                ); ?>
                            </p>
                            <a href="detalhes.php?id=<?php echo $p[
                                "id"
                            ]; ?>" class="btn btn-dark w-100 mt-2">
                                Ver Detalhes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include "rodape.php";
?>
