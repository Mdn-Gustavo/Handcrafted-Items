<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit();
}

function is_logged_in(): bool
{
    return !empty($_SESSION['usuario_id']);
}

function require_login(): void
{
    if (!is_logged_in()) {
        flash_set('erro', 'Faça login para acessar a área administrativa.');
        redirect('login.php');
    }
}

function current_user_name(): string
{
    return $_SESSION['usuario_nome'] ?? 'Usuário';
}

function current_user_id(): ?int
{
    return isset($_SESSION['usuario_id']) ? (int) $_SESSION['usuario_id'] : null;
}

function current_user_type(): string
{
    return $_SESSION['usuario_tipo'] ?? 'comum';
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_input(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function csrf_validate(?string $token): bool
{
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $token);
}

function flash_set(string $tipo, string $mensagem): void
{
    $_SESSION['flash'][$tipo] = $mensagem;
}

function flash_get(string $tipo): ?string
{
    if (empty($_SESSION['flash'][$tipo])) {
        return null;
    }

    $mensagem = $_SESSION['flash'][$tipo];
    unset($_SESSION['flash'][$tipo]);

    return $mensagem;
}

function set_cookie_seguro(string $nome, string $valor, int $dias = 30): void
{
    // Forma compatível com versões antigas do PHP usadas em alguns ambientes de faculdade/XAMPP.
    // Evita erro 500 em servidores que não aceitam o array de opções do setcookie().
    setcookie(
        $nome,
        $valor,
        time() + (60 * 60 * 24 * $dias),
        '/',
        '',
        false,
        true
    );
}
