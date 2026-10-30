<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$tempoInatividade = 1800; // 30 minutos (em segundos)

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 1) {
    /*MODIFICAR QUANDO PUBLICAR*/
    header('Location: /Plataforma-A7car/php/user/Login.php?erro=acesso_negado');
    exit;
}


if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $tempoInatividade)) {
    session_unset();
    session_destroy();
    /*MODIFICAR QUANDO PUBLICAR*/
    header('Location: /Plataforma-A7car/php/user/Login.php?erro=sessao_expirada');
    exit;
}

$_SESSION['last_activity'] = time();

function validarTokenCsrf($tokenPost) {
    if (!isset($_SESSION['csrf_token']) || empty($tokenPost)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $tokenPost);
}

$inputCsrf = "<input  type='hidden' name='csrf_token' value='" . $_SESSION['csrf_token'] . "'>";
