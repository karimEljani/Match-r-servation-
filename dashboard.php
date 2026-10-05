<?php
require_once '../config/database.php';
require_once '../config/auth.php';
requireLogin();

$stmt = $pdo->prepare("
SELECT r.*, m.home_team, m.away_team, m.match_date, s.name stadium_name
FROM reservations r
JOIN matches m ON m.id=r.match_id
JOIN stadiums s ON s.id=m.stadium_id
WHERE r.user_id=?
ORDER BY r.created_at DESC
");
$stmt->execute([$_SESSION['user']['id']]);
$reservations = $stmt->fetchAll();
?>
<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Mon espace</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<nav class="navbar"><a class="brand" href="../index.php">⚽ MatchTicket</a><div><a href="matches.php">Matchs</a><a href="profile.php">Profil</a><a href="../auth/logout.php">Déconnexion</a></div></nav>
<main class="container">
<div class="section-title"><div><h1>Bonjour <?= e($_SESSION['user']['name']) ?> 👋</h1><p>Gérez vos réservations.</p></div><a class="btn" href="matches.php">+ Réserver un match</a></div>
<div class="card table-wrap"><table><thead><tr><th>Match</th><th>Date</th><th>Stade</th><th>Places</th><th>Total</th><th>Statut</th></tr></thead><tbody>
<?php foreach($reservations as $r): ?>
<tr><td><?= e($r['home_team']) ?> - <?= e($r['away_team']) ?></td><td><?= date('d/m/Y H:i',strtotime($r['match_date'])) ?></td><td><?= e($r['stadium_name']) ?></td><td><?= (int)$r['quantity'] ?></td><td><?= number_format((float)$r['total_price'],2) ?> DT</td><td><span class="status <?= e($r['status']) ?>"><?= e($r['status']) ?></span></td></tr>
<?php endforeach; ?>
<?php if(!$reservations): ?><tr><td colspan="6">Aucune réservation pour le moment.</td></tr><?php endif; ?>
</tbody></table></div>
</main>
</body></html>