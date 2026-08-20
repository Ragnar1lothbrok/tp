<?php
$error = null;
$success = null;

try {
    $pdo = new PDO('sqlite:../data.db', null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);

    $id = $_GET['id'] ?? null;

    // Handle Form Submission (Update post) [00:23:22]
    if (isset($_POST['name'], $_POST['content'])) {
        $query = $pdo->prepare('UPDATE posts SET name = :name, content = :content WHERE id = :id');
        $query->execute([
            'name' => $_POST['name'],
            'content' => $_POST['content'],
            'id' => $id
        ]);
        $success = 'Votre article a bien été modifié';
    }

    // Fetch existing post [00:20:05]
    $query = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
    $query->execute(['id' => $id]);
    $post = $query->fetch();
} catch (PDOException $e) {
    $error = $e->getMessage();
}

require __DIR__ . '/../elements/header.php';
?>

<p><a href="/blog">← Retour au listing</a></p>

<?php if ($error): ?>
    <div class="alert alert-danger">
        <?= htmlentities($error) ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success">
        <?= htmlentities($success) ?>
    </div>
<?php endif; ?>

<?php if ($post): ?>
    <!-- Edit Post Form -->
    <form action="" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="name" value="<?= htmlentities((string) $post->name) ?>">
        </div>
        <div class="form-group">
            <textarea class="form-control" name="content"><?= htmlentities((string) $post->content) ?></textarea>
        </div>
        <button class="btn btn-primary">Sauvegarder</button>
    </form>
<?php endif; ?>

<?php require __DIR__ . '/../elements/footer.php'; ?>