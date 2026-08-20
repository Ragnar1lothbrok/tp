<?php
require_once __DIR__ . '/functions.php';
$title = 'Profil';
$age = null;

if (!empty($_POST['birthday'])) {
    setcookie('birthday', $_POST['birthday']);
    $_COOKIE['birthday'] = $_POST['birthday'];
}

if (!empty($_COOKIE['birthday'])) {
    $birthday = (int)$_COOKIE['birthday'];
    $age = (int)date('Y') - $birthday;
}


require __DIR__ . '/elements/header.php';
?>

<?php if ($age >= 18): ?>
    <h1>Du contenu reserve aux adultes</h1>
    <?php elseif ($age !== null): ?>
        <div class="alert alert-danger">Vous n'avez pas 1'age requis pour voir le contenu</div>

<?php else: ?>    
<form action="" method="post">
    <div class="form-group">
        <label for="birthday">Section reservee pour les adultes, entrer votre annee de naissance :</label>
        <select name="birthday" id="birthday" class="form-control">
            <?php for($i = 2010; $i > 1919; $i -- ): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor ?>
        </select>
    </div>
    <button type="submit">Envoyer</button>
</form>
<?php endif; ?>

<?php require __DIR__ . '/elements/footer.php'; ?>