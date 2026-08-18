<?php
$title = "Nous contacter" ;
require_once 'config.php';
require_once 'functions.php';
$creneaux = creneaux_html(CRENEAUX);
require 'header.php' ;
 ?>

<div class="row">
    <div class="col-md-8">
        <h2>Nous contacter</h2>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Incidunt molestias libero aspernatur, architecto facere doloribus asperiores cumque provident iure impedit saepe inventore veniam! Corporis, est? Incidunt est sequi nobis doloribus?</p>
    </div>
    <div class="col-md-4">
        <h2> Horaire d'ouvertures</h2>
        <?= $creneaux ?>
    </div>
</div>



<?php require 'footer.php' ; ?>
