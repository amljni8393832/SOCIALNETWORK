<?php
session_start();
include('connexion.php');

// Envoi d'une invitation
if(isset($_GET['id'])){
    $expediteur = $_SESSION['ID'];
    $destinataire = intval($_GET['id']);
    $statut = "en_attente";

    $sql = "INSERT INTO invitation (expediteur, destinataire, date, statut)
            VALUES (?, ?, NOW(), ?)";
    $stm = $mysqli->prepare($sql);
    $stm->bind_param("iis", $expediteur, $destinataire, $statut);
    $stm->execute();

    echo "<p>Invitation envoyée avec succès.</p>";
}

// Sélection des invitations envoyées par l’utilisateur connecté
$sql = "SELECT i.id, i.date, i.statut, u.nom, u.function, u.email, u.photo
        FROM invitation i
        JOIN users u ON u.id = i.destinataire
        WHERE i.expediteur = ?
        ORDER BY i.date DESC";
$stm = $mysqli->prepare($sql);
$stm->bind_param("i", $_SESSION['ID']);
$stm->execute();
$result = $stm->get_result();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Invitations envoyées</title>
    <style>
        body {margin:0; font-family:Arial,sans-serif; background:#f9f9f9;}
        header {display:flex; justify-content:space-between; padding:12px 20px; align-items:center; background:#00bfa5; color:white;}
        header nav {display:flex; align-items:center; gap:15px;}
        header nav a {text-decoration:none; color:white; font-weight:bold;}
        header nav a:hover {text-decoration:underline;}
        .container {display:grid; grid-template-columns:250px 1fr; min-height:calc(100vh - 60px);}
        .leftnav {display:flex; flex-direction:column; gap:12px; border-right:1px solid #ccc; padding:20px; background:#e0f7fa;}
        .leftnav a {text-decoration:none; color:#333; font-weight:bold; padding:8px; border-radius:4px;}
        .leftnav a:hover {color:#00796b; background:#b2dfdb;}
        .content {padding:20px;}
        .card {background:white; padding:20px; border-radius:8px; box-shadow:0px 2px 6px rgba(0,0,0,0.1); max-width:500px; margin-bottom:20px;}
        .card img {border-radius:50%; width:80px; height:80px; object-fit:cover; margin-bottom:10px;}
        .card h3 {margin:5px 0; color:#00796b;}
        .card p {margin:3px 0; font-size:14px; color:#555;}
        .status {font-weight:bold; color:#00796b;}
    </style>
</head>
<body>
    <header>
        <span><strong>My Social Network</strong></span>
        <nav>
            <img src="<?php echo $_SESSION['photo'] ; ?>" alt="avatar" width="40" height="40" style="border-radius:50%;">
            <a href="profil.php"><?php echo $_SESSION['nom'] ; ?></a>
            <a href="logOut.php">logOut</a>
        </nav>
    </header>

    <div class="container">
        <div class="leftnav">
            <a href="profil.php">Mon Profil</a>
            <a href="amis.php">Mes Amis</a>
            <a href="userlist.php">Liste des utilisateurs</a>
            <a href="usersearch.php">Rechercher</a>
            <a href="invetation.php">Invitations reçues</a>
            <a href="invitationEnvoie.php" class="nav-active">Invitations envoyées</a>
            <a href="message.php">Messages</a>
        </div>
        <div class="content">
            <h2>Invitations envoyées</h2>
            <?php
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo '<div class="card">
                            <img src="'.(!empty($row['photo']) ? $row['photo'] : 'default.png').'" alt="Photo de '.htmlspecialchars($row['nom']).'">
                            <h3>'.$row['nom'].'</h3>
                            <p>'.$row['function'].'</p>
                            <p>'.$row['email'].'</p>
                            <p>Invitation envoyée le '.date('d/m/Y', strtotime($row['date'])).'</p>
                            <p class="status">Statut : '.$row['statut'].'</p>
                          </div>';
                }
            } else {
                echo "<p>Aucune invitation envoyée.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>

