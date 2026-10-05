<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/auth.php';

$stmt = $pdo->query("
    SELECT m.*, s.name AS stadium_name
    FROM matches m
    JOIN stadiums s ON s.id = m.stadium_id
    WHERE m.match_date >= NOW()
    ORDER BY m.match_date ASC
    LIMIT 6
");
$matches = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MatchTicket - Réservation de matchs</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="navbar">
    <a class="brand" href="index.php">⚽ MatchTicket</a>
    <div>
        <?php if (!empty($_SESSION['user'])): ?>
            <a href="user/dashboard.php">Mon espace</a>
            <a href="auth/logout.php">Déconnexion</a>
        <?php elseif (!empty($_SESSION['admin'])): ?>
            <a href="admin/dashboard.php">Administration</a>
            <a href="auth/logout.php">Déconnexion</a>
        <?php else: ?>
            <a href="auth/login.php">Connexion</a>
            <a class="btn small" href="auth/register.php">Inscription</a>
        <?php endif; ?>
    </div>
</nav>

<header class="hero">
    <div>
        <span class="badge">RÉSERVATION EN LIGNE</span>
        <h1>Réservez votre place pour les plus grands matchs.</h1>
        <p>Choisissez votre rencontre, votre catégorie de place et confirmez votre réservation en quelques clics.</p>
        <a class="btn" href="user/matches.php">Voir les matchs</a>
    </div>
</header>

<main class="container">
    <div class="section-title">
        <div><h2>Prochains matchs</h2><p>Les prochaines rencontres disponibles.</p></div>
    </div>
    <div class="grid">
    <?php foreach ($matches as $match): ?>
        <article class="card match-card">
            <div class="match-top">
                <span><?= e($match['competition']) ?></span>
                <span><?= date('d/m/Y H:i', strtotime($match['match_date'])) ?></span>
            </div>
            <h3><?= e($match['home_team']) ?> <b>VS</b> <?= e($match['away_team']) ?></h3>
            <p>📍 <?= e($match['stadium_name']) ?></p>
            <p>À partir de <strong><?= number_format((float)$match['price'], 2) ?> DT</strong></p>
            <a class="btn full" href="user/match_details.php?id=<?= (int)$match['id'] ?>">Réserver</a>
        </article>
    <?php endforeach; ?>
    </div>
</main>
<footer>© <?= date('Y') ?> MatchTicket — Application PHP/MySQL</footer>
</body>
</html>