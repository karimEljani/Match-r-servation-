<?php
require_once '../config/database.php';
require_once '../config/auth.php';
requireLogin();
$success='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=trim($_POST['name']??'');
    if($name!==''){
        $stmt=$pdo->prepare("UPDATE users SET name=? WHERE id=?");
        $stmt->execute([$name,$_SESSION['user']['id']]);
        $_SESSION['user']['name']=$name;
        $success='Profil mis à jour.';
    }
}
$stmt=$pdo->prepare("SELECT * FROM users WHERE id=?");$stmt->execute([$_SESSION['user']['id']]);$u=$stmt->fetch();
?>
<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Profil</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body><nav class="navbar"><a class="brand" href="../index.php">⚽ MatchTicket</a><div><a href="dashboard.php">Mon espace</a><a href="../auth/logout.php">Déconnexion</a></div></nav>
<main class="container narrow"><div class="card"><h1>Mon profil</h1><?php if($success):?><div class="alert success"><?=$success?></div><?php endif;?><form method="post"><label>Nom<input name="name" value="<?=e($u['name'])?>" required></label><label>Email<input value="<?=e($u['email'])?>" disabled></label><button class="btn">Enregistrer</button></form></div></main></body></html>