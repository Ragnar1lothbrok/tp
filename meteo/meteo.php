<?php
require_once 'class/OpenWeather.php';

// Instantiate OpenWeather with your API key
$weather = new OpenWeather('{https://api.openweathermap.org/data/2.5/weather?q=Tunis&APPID=fdb93d06e0e2512635156e672544c3ee&units=metric&units=metric}');

$today = $weather->getToday('Montpellier,fr');
$forecast = $weather->getForecast('Montpellier,fr');

require 'elements/header.php';
?>

<div class="container my-5">
    <?php if ($today !== null): ?>
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">Météo aujourd'hui</h2>
                <p class="card-text fs-4">
                    <strong>En ce moment :</strong> 
                    <?= htmlspecialchars($today['description']) ?>, 
                    <?= htmlspecialchars((string)$today['temp']) ?> °C
                </p>
                <p class="text-muted"><small>Mise à jour : <?= $today['date']->format('d/m/Y H:i') ?></small></p>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger" role="alert">
            Impossible de récupérer les données météo actuelles. Veuillez vérifier votre clé API ou votre connexion.
        </div>
    <?php endif; ?>

    <?php if ($forecast !== null): ?>
        <h2 class="mb-3">Prévisions pour les prochains jours</h2>
        <ul class="list-group">
            <?php foreach ($forecast as $day): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <strong><?= $day['date']->format('d/m/Y') ?> :</strong> 
                        <?= htmlspecialchars($day['description']) ?>
                    </span>
                    <span class="badge bg-primary rounded-pill"><?= htmlspecialchars((string)$day['temp']) ?> °C</span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<?php require 'elements/footer.php'; ?>