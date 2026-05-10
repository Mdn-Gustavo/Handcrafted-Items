<?php 
session_start();

if (isset($_SESSION['logged_in'])) {

    header("Location: secure.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['username']) && isset($_POST['password'])){
        // Trim the username and password inputs to remove any leading/trailing whitespace
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        if(empty($username) || empty($password)) {
            $error = "Preencha todos os campos";
        } else {
            
            // i use this echo to generate the hashed password, so it aint important anymore
            // echo password_hash("123456", PASSWORD_DEFAULT);
            $correctUsername = "admin";
            $hashedPassword = '$2y$12$5TzW3arf8FT7PpZEArzfpuY.dnGI0b.qMUf25SY/elHNKb4Bcu9p.';

            if(
            $username == $correctUsername && password_verify($password, $hashedPassword)
            ) {
                $_SESSION['logged_in'] = true;
                header("Location: secure.php");
                exit();
                
            } else {
                $error = "Usuário ou senha incorretos";
            }
        }
        
    }
}
?>
    
    <?php
    // those php are for displaying the error message, if there is one
    if (!empty($error)) : ?>
    
        <p><?= htmlspecialchars($error) ?></p>
        
    <?php endif; ?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <h1>Login</h1>
    <form method="POST">
        <input type="text" name="username" placeholder="Username">
        <br><br>
        <input type="password" name="password" placeholder="Password">
        <br><br>
        <button type="submit">Login</button>
    </form>
    
</body>
</html>

