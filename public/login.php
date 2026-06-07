<?php 
session_start();

if (isset($_SESSION['logged_in'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])){
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        if(empty($username) || empty($password)) {
            $error = "Preencha todos os campos";
        } else {
            $correctUsername = "admin";
            $hashedPassword = '$2y$12$5TzW3arf8FT7PpZEArzfpuY.dnGI0b.qMUf25SY/elHNKb4Bcu9p.';

            if($username == $correctUsername && password_verify($password, $hashedPassword)) {
                $_SESSION['logged_in'] = true;
                header("Location:dashboard.php");
                exit();
            } else {
                $error = "Usuário ou senha incorretos";
            }
        }
    }
}

include __DIR__ . "/../app/views/templates/cabecalho.php";
?>

<link rel="stylesheet" href="assets/css/style.css">
<main class="container container-login">
    <div class="card card-login shadow-sm border-0">
        <div class="card-body p-5">
            
            <div class="text-center mb-4">
                <h2 class="font-artesanal">Acesso Restrito</h2>
                <p class="text-muted small">Área exclusiva para artesãos</p>
            </div>

            <?php if (!empty($error)) : ?>
                <div class="alert alert-danger py-2 small text-center">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label small">Usuário</label>
                    <input type="text" name="username" class="form-control" placeholder="admin" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label small">Senha</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    Entrar no Sistema
                </button>
            </form>
            
            <div class="text-center mt-4">
                <a href="index.php" class="text-muted small text-decoration-none">← Voltar para a vitrine</a>
            </div>

        </div>
    </div>
</main>

<?php include __DIR__ . "/../app/views/templates/rodape.php"; ?>
