<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function est_connecte(): bool {
    return !empty($_SESSION['connecte']);
}

function forcer_utilisateur_connecte(): void {
    if (!est_connecte()) {
        header('Location: /login.php');
        exit();
    }
}