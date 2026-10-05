<?php
require_once '../config/database.php';
require_once '../config/auth.php';
requireLogin();
$id=(int)($_GET['id']??0);
$stmt=$pdo->prepare("SELECT m.*,s.name stadium_name,s.capacity FROM matches m JOIN stadiums s ON s.id=m.stadium_id WHERE m.id=?");
$stmt->execute([$id]); $match=$stmt->fetch();
if(!$match) die("Match introuvable.");
?>
<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Réservation</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body><nav class="navbar"><a class="brand" href="../index.php">⚽ MatchTicket</a><div><a href="dashboard.php">Mon espace</a><a href="../auth/logout.php">Déconnexion</a></div></nav>
<main class="container narrow"><div class="card">
<div class="badge"><?=e($match['competition'])?></div><h1><?=e($match['home_team'])?> <span class="muted">VS</span> <?=e($match['away_team'])?></h1>
<p>📅 <?=date('d/m/Y à H:i',strtotime($match['match_date']))?></p><p>📍 <?=e($match['stadium_name'])?></p><p>💰 Prix : <strong><?=number_format((float)$match['price'],2)?> DT</strong></p>
<form method="post" action="reservation.php">
<input type="hidden" name="match_id" value="<?=$id?>">
<label>Nombre de places<input id="quantity" type="number" name="quantity" value="1" min="1" max="10" required></label>
<div class="total-box">Total : <strong id="total"><?=number_format((float)$match['price'],2)?> DT</strong></div>
<button class="btn full">Confirmer la réservation</button>
</form></div></main>
<script>const q=document.getElementById('quantity'),t=document.getElementById('total'),p=<?=json_encode((float)$match['price'])?>;q.addEventListener('input',()=>t.textContent=(Math.max(1,Number(q.value)||1)*p).toFixed(2)+' DT');</script>
</body></html>