<?php
$erreur = null;
$password = '$2y$12$G8ytyY555inq2.FOOHy6Oe9Q2zoyIxMaANvFI5z6rskgyVUNjkfj2';//Doe
if (!empty($_POST['pseudo']) && !empty($_POST['motdepasse'])) {
    if ($_POST['pseudo'] === 'john' && password_verify($_POST['motdepasse'], $password)) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['connecte'] = 1;
        header('Location: /dashboard.php');
        exit();
    } else {
        $erreur = "Identifiants incorrects";
    }
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'auth.php';
if (est_connecte()) {
    header('Location: /dashboard.php');
    exit();
}

$title = "Se connecter";
require_once __DIR__ . '/elements/header.php';
?>

<h1>Se connecter</h1>

<?php if ($erreur): ?>
    <div class="alert alert-danger">
        <?= $erreur ?>
    </div>
<?php endif; ?>

<form action="" method="post">
    <div class="form-group">
        <input class="form-control" type="text" name="pseudo" placeholder="Nom d'utilisateur">
    </div>
    <div class="form-group">
        <input class="form-control" type="password" name="motdepasse" placeholder="Votre mot de passe">
    </div>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>

<?php require_once __DIR__ . '/elements/footer.php'; ?>