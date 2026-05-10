<?php 
include 'includes/cabecalho.php';
include 'includes/dados.php';
include 'includes/cabecalho.php'; 
?>

<div class="container my-5">
    <header class="text-center mb-5">
        <h1 class="display-4" style="font-family: 'Playfair Display';">Nossa Coleção</h1>
        <p class="lead text-muted">Peças exclusivas feitas por mãos talentosas.</p>
    </header>

    <div class="row g-4">
        <?php if (isset($produtos) && !empty($produtos)): ?>
            <?php foreach ($produtos as $p): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="./assets/css/images/<?php echo $p['imagem']; ?>" class="card-img-top" alt="...">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($p['nome']); ?></h5>
                            <p class="text-muted small"><?php echo htmlspecialchars($p['categoria']); ?></p>
                            <p class="fw-bold">R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?></p>
                            <a href="detalhes.php?id=<?php echo $p['id']; ?>" class="btn btn-primary w-100">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center text-muted">Nenhum produto disponível.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/rodape.php'; ?>