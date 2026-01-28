<?php
session_start();
include('connexion.php');

if(!isset($_SESSION['statut']) || $_SESSION['statut'] != 'onLine'){
    header('location:index.html');
    exit();
}

$myid = $_SESSION['ID'];

// Récupérer les messages envoyés par l'utilisateur
$sql = "SELECT m.id, m.object, m.text, m.date, u.nom, u.photo
        FROM message m
        JOIN users u ON m.destinataire = u.id
        WHERE m.expediteur = ?
        ORDER BY m.date DESC";

$stm = $mysqli->prepare($sql);
$stm->bind_param("i", $myid);
$stm->execute();
$result = $stm->get_result();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Messages envoyés</title>
    <style>
        body { margin:0; font-family:Arial,sans-serif; background:#f9f9f9; }
        header { display:flex; justify-content:space-between; padding:12px 20px; align-items:center; background:#00bfa5; color:white; }
        header nav { display:flex; align-items:center; gap:15px; }
        header nav a { text-decoration:none; color:white; font-weight:bold; }
        header nav a:hover { text-decoration:underline; }
        .container { display:grid; grid-template-columns:250px 1fr; min-height:calc(100vh - 60px); }
        .leftnav { display:flex; flex-direction:column; gap:12px; border-right:1px solid #ccc; padding:20px; background:#e0f7fa; }
        .leftnav a { text-decoration:none; color:#333; font-weight:bold; padding:8px; border-radius:4px; }
        .leftnav a:hover { color:#00796b; background:#b2dfdb; }
        .content { padding:20px; }
        .card { background:white; padding:20px; border-radius:8px; box-shadow:0px 2px 6px rgba(0,0,0,0.1); margin-bottom:20px; }
        .friends-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(250px,1fr)); gap:20px; margin-top:20px; }
        .friend-card { background:#fff; padding:15px; border-radius:8px; box-shadow:0px 2px 4px rgba(0,0,0,0.1); text-align:center; }
        .friend-avatar img { border-radius:50%; width:80px; height:80px; object-fit:cover; margin-bottom:10px; }
        .friend-info h3 { margin:5px 0; color:#00796b; }
        .friend-info p { margin:3px 0; font-size:14px; color:#555; }
    </style>
</head>
<body>
<header>
    <span><strong>My Social Network</strong></span>
    <nav>
        <img src="<?php echo $_SESSION['photo']; ?>" alt="avatar" width="40" height="40" style="border-radius:50%;">
        <a href="profil.php"><?php echo $_SESSION['nom']; ?></a>
        <a href="logOut.php">logOut</a>
    </nav>
</header>

<div class="container">
    <div class="leftnav">
        <a href="usersearch.php">Recherche</a>
        <a href="invetation.php">Invitations reçues</a>
        <a href="invetationEnvoie.php">Invitations envoyées</a>
        <a href="nouveauxMessage.php">Nouveaux messages</a>
        <a href="nouveauxEnvoi.php" class="nav-active">Messages envoyés</a>
    </div>
    <div class="content">
        <div class="card">
            <h2>Messages envoyés</h2>
            <?php
            if($result->num_rows > 0){
                echo '<div class="friends-grid">';
                while($row = $result->fetch_assoc()){
                    echo '<div class="friend-card">
                            <div class="friend-avatar">';
                    if(!empty($row['photo'])){
                        echo '<img src="'.$row['photo'].'" alt="Photo de '.$row['nom'].'">';
                    } else {
                        echo '<div style="width:80px;height:80px;border-radius:50%;background:#00bfa5;color:white;display:flex;align-items:center;justify-content:center;font-size:28px;margin:auto;margin-bottom:10px;">'.substr($row['nom'],0,1).'</div>';
                    }
                    echo '</div>
                          <div class="friend-info">
                            <h3>À : '.$row['nom'].'</h3>
                            <p><strong>Objet :</strong> '.$row['object'].'</p>
                            <p>'.$row['text'].'</p>
                            <p><em>Envoyé le '.date('d/m/Y H:i', strtotime($row['date'])).'</em></p>
                          </div>
                          </div>';
                }
                echo '</div>';
            } else {
                echo '<p>Vous n\'avez pas encore envoyé de messages.</p>';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>

