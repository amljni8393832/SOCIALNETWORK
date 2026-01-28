<?php
session_start();
if(!isset($_SESSION['statut']) || $_SESSION['statut'] != 'onLine'){
    header('location:index.html');
    exit();
}
include('connexion.php');

$expediteur   = $_SESSION['ID'];          
$destinataire = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Envoi d'un message
if (isset($_POST['objet']) && isset($_POST['texte'])) {
    $objet = $_POST['objet'];
    $texte = $_POST['texte'];
    $dateMessage = date("Y-m-d H:i:s");

    $sql = "INSERT INTO message (expediteur, destinataire, object, date, text) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iisss", $expediteur, $destinataire, $objet, $dateMessage, $texte);
    $stmt->execute();

    echo "<p style='color:green;'>Message envoyé avec succès.</p>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Messages - Réseau Social</title>
    <style>
        body {margin:0;font-family:Arial,sans-serif;background:#f9f9f9;}
        header {display:flex;justify-content:space-between;padding:12px 20px;align-items:center;background:#00bfa5;color:white;}
        header nav {display:flex;align-items:center;gap:15px;}
        header nav a {text-decoration:none;color:white;font-weight:bold;}
        header nav a:hover {text-decoration:underline;}
        .dashboard {display:grid;grid-template-columns:250px 1fr;min-height:calc(100vh - 60px);}
        .sidebar {background:#e0f7fa;padding:20px;border-right:1px solid #ccc;}
        .sidebar-nav a {display:block;text-decoration:none;color:#333;font-weight:bold;padding:8px;border-radius:4px;margin-bottom:10px;}
        .sidebar-nav a:hover,.nav-active {color:#00796b;background:#b2dfdb;}
        .main-content {padding:20px;}
        .friends-section {background:white;padding:20px;border-radius:8px;box-shadow:0px 2px 6px rgba(0,0,0,0.1);}
        .friends-grid {display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:20px;margin-top:20px;}
        .friend-card {background:#fefefe;border:1px solid #ddd;border-radius:8px;padding:15px;text-align:center;box-shadow:0px 2px 4px rgba(0,0,0,0.1);}
        .friend-info h3 {margin:5px 0;color:#00796b;}
        .friend-info p {margin:3px 0;font-size:14px;color:#555;}
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

<div class="dashboard">
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="profil.php">Mon Profil</a>
            <a href="amis.php">Mes Amis</a>
            <a href="userlist.php">Liste des utilisateurs</a>
            <a href="usersearch.php">Rechercher</a>
            <a href="invetation.php">Invitations reçues</a>
            <a href="invitationEnvoie.php">Invitations envoyées</a>
            <a href="message.php" class="nav-active">Messages</a>
        </nav>
    </aside>

    <main class="main-content">
        <div class="friends-section">
            <h2>Envoyer un message</h2>
            <form method="post">
                <label>Objet :</label><br>
                <input type="text" name="objet" required><br><br>

                <label>Message :</label><br>
                <textarea name="texte" rows="5" cols="40" required></textarea><br><br>

                <button type="submit">Envoyer</button>
            </form>
        </div>
    </main>
</div>
</body>
</html>

