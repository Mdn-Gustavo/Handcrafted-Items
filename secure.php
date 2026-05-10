<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    
    header("Location: login.php");
    exit();
}
?>

<h1> Área Protegida</h1>

<a href="logout.php">Logout</a>