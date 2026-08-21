<h1>Ma homepage</h1>

<a href="<?= $router->generate('contact') ?>">Nous contacter</a>
<a href="<?= $router->generate('article', ['id' => 60, 'slug' => 'import-qoi']); ?>">Voir l'aritcle</a>

<?php ob_start(); ?>
<script>alert('Salut')</script>
<?php $pageJavascripts = ob_get_clean(); ?>
