<?php
declare(strict_types=1);

require_once 'class/OpenWeather.php';

$error = null;
$today = null;
$forecast = null;

try {
    $weather = new OpenWeather('fdb93d06e0e2512635156e672544c3ee');
    $today = $weather->getToday('Tunis');
    $forecast = $weather->getForecast('Tunis');
} catch (Exception | Error $e) {
    // Catch both custom/PHP exceptions and core PHP errors
    $error = $e->getMessage();
}

require 'elements/header.php';
?>

<div class="container my-5">
    <?php if ($error): ?>
        <div class="alert alert-danger" role="alert">
            <strong>Erreur :</strong> <?= htmlspecialchars($error) ?>
        </div>
    <?php else: ?>
        <?php if ($today): ?>
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
        <?php endif; ?>

        <?php if ($forecast): ?>
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
    <?php endif; ?>
</div>

<?php require 'elements/footer.php'; ?>