<?php
require_once '../config/database.php';
require_once '../config/auth.php';
requireLogin();

if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: matches.php');exit;}
$matchId=(int)($_POST['match_id']??0);
$quantity=max(1,min(10,(int)($_POST['quantity']??1)));

$pdo->beginTransaction();
try {
    $stmt=$pdo->prepare("SELECT * FROM matches WHERE id=? AND match_date>=NOW() FOR UPDATE");
    $stmt->execute([$matchId]); $match=$stmt->fetch();
    if(!$match) throw new Exception("Match indisponible.");

    $stmt=$pdo->prepare("SELECT COALESCE(SUM(quantity),0) used FROM reservations WHERE match_id=? AND status='confirmed'");
    $stmt->execute([$matchId]); $used=(int)$stmt->fetch()['used'];
    if($used+$quantity>(int)$match['total_seats']) throw new Exception("Il ne reste pas assez de places.");

    $total=$quantity*(float)$match['price'];
    $stmt=$pdo->prepare("INSERT INTO reservations(user_id,match_id,quantity,total_price,status) VALUES(?,?,?,?, 'confirmed')");
    $stmt->execute([$_SESSION['user']['id'],$matchId,$quantity,$total]);
    $pdo->commit();
    header('Location: dashboard.php?success=1'); exit;
} catch(Exception $e){
    $pdo->rollBack();
    die('<div style="font-family:Arial;padding:40px"><h2>Réservation impossible</h2><p>'.e($e->getMessage()).'</p><a href="matches.php">Retour</a></div>');
}
?>