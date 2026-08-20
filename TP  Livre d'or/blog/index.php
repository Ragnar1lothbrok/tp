<?php
require_once __DIR__ . '/../class/Post.php';

$error = null;
$posts = [];

try {
    $pdo = new PDO('sqlite:../data.db', null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);

    // Handle Form Submission (Insert new post) [00:27:01]
    if (isset($_POST['name'], $_POST['content'])) {
        $query = $pdo->prepare('INSERT INTO posts (name, content, created_at) VALUES (:name, :content, :created_at)');
        $query->execute([
            'name' => $_POST['name'],
            'content' => $_POST['content'],
            'created_at' => time()
        ]);

        $id = $pdo->lastInsertId();
        header('Location: /blog/edit.php?id=' . $id);
        exit();
    }

    // Fetch all posts into Post class instances [00:31:47]
    $query = $pdo->query('SELECT * FROM posts');
    $posts = $query->fetchAll(PDO::FETCH_CLASS, 'Post');
} catch (PDOException $e) {
    $error = $e->getMessage();
}

require __DIR__ . '/../elements/header.php';
?>
<div class="container"></div>
<?php if ($error): ?>
    <div class="alert alert-danger">
        <?= htmlentities($error) ?>
    </div>
<?php else: ?>
    <!-- Post Listing -->
    <?php foreach ($posts as $post): ?>
        <h2>
            <a href="/blog/edit.php?id=<?= $post->id ?>">
                <?= htmlentities($post->name) ?>
            </a>
        </h2>
        <p class="small text-muted">
            Écrit le <?= $post->getCreatedAt()->format('d/m/Y à H:i') ?>
        </p>
        <p>
            <?= nl2br(htmlentities($post->getExcerpt())) ?>
        </p>
    <?php endforeach; ?>
<?php endif; ?>

<hr>

<!-- Create Post Form [00:26:33] -->
<form action="" method="post">
    <div class="form-group">
        <input type="text" name="name" class="form-control" placeholder="Titre de l'article">
    </div>
    <div class="form-group">
        <textarea name="content" class="form-control" placeholder="Contenu de l'article"></textarea>
    </div>
    <button class="btn btn-primary">Sauvegarder</button>
</form>

<?php require __DIR__ . '/../elements/footer.php'; ?>