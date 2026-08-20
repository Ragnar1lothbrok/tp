<?php
session_start();
$_SESSION['user'] = [
  'username' => 'john',
  'password' => '0000'
];
$title = "page d'accueil";
require __DIR__ . '/elements/header.php';
?>
      <div class="starter-template">
        <h1>Bootstrap starter template</h1>
        <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>
      </div>

   <?php require __DIR__ . '/elements/footer.php'; ?>