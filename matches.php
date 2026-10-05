<?php
require_once '../config/database.php';
require_once '../config/auth.php';
requireLogin();
$matches = $pdo->query("SELECT m.*,s.name stadium_name FROM matches m JOIN stadiums s ON s.id=m.stadium_id WHERE m.match_date>=NOW() ORDER BY m.match_date")->fetchAll();
?>
<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Matchs</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body><nav class="navbar"><a class="brand" href="../index.php">⚽ MatchTicket</a><div><a href="dashboard.php">Mon espace</a><a href="../auth/logout.php">Déconnexion</a></div></nav>
<main class="container"><div class="section-title"><div><h1>Matchs disponibles</h1><p>Choisissez votre rencontre.</p></div></div><div class="grid">
<?php foreach($matches as $m): ?><article class="card match-card"><div class="match-top"><span><?=e($m['competition'])?></span><span><?=date('d/m/Y H:i',strtotime($m['match_date']))?></span></div><h2><?=e($m['home_team'])?> <b>VS</b> <?=e($m['away_team'])?></h2><p>📍 <?=e($m['stadium_name'])?></p><p>💳 <?=number_format((float)$m['price'],2)?> DT / place</p><a class="btn full" href="match_details.php?id=<?=(int)$m['id']?>">Voir et réserver</a></article><?php endforeach;?>
</div></main></body></html>