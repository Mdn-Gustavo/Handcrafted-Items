<?php

$titulo_site = "Vitrine Artesanal - Meus Produtos";

$produtos = [
	[
		"id" => 1,
		"nome" => "Sabonete Horteloco",
		"preco" => 27.80,
		"imagem" => "sabonete1.jpg",
		"categoria" => "Sabonetes",
	],
	[
		"id" => 2,
		"nome" => "Sabonete Carvoeiro",
		"preco" => 28.80,
		"imagem" => "sabonete2.jpg",
		"categoria" => "Sabonetes",
	],
	[
		"id" => 3,
		"nome" => "Sabonete Cerejeira",
		"preco" => 25.50,
		"imagem" => "sabonete3.jpg",
		"categoria" => "Sabonetes",
	],
	[
		"id" => 4,
		"nome" => "Sabonete Organatch",
		"preco" => 27.80,
		"imagem" => "sabonete4.jpg",
		"categoria" => "Sabonetes",
	],
	[
		"id" => 5,
		"nome" => "Sabonete C&C",
		"preco" => 28.00,
		"imagem" => "sabonete5.jpg",
		"categoria" => "Sabonetes",
	],
	[
		"id" => 6,
		"nome" => "Sabonete de Aveia",
		"preco" => 26.50,
		"imagem" => "sabonete6.jpg",
		"categoria" => "Sabonetes",
	],
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_site; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#"><?php echo $titulo_site; ?></a>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center mb-4">Nossos Produtos Artesanais</h1>
        
        <div class="row">
            <?php 
            // Loop para percorrer o array de produtos (Aula 03)
            foreach ($produtos as $produto): 
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="./webalizer/images/<?php echo $produto['imagem']; ?>" class="card-img-top" alt="Imagem do produto">
                        
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $produto['nome']; ?></h5>
                            <p class="badge bg-secondary"><?php echo $produto['categoria']; ?></p>
                            <p class="card-text text-success fw-bold">
                                R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                            </p>
                            <a href="detalhes.php?id=<?php echo $produto['id']; ?>" class="btn btn-outline-primary">
                                Ver Detalhes
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="text-center py-4 mt-5 bg-white border-top">
        <p>&copy; 2026 - <?php echo $titulo_site; ?></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>