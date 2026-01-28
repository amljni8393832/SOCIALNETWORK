<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Réseau Social</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        header {
            display: flex;
            justify-content: space-between;
            padding: 12px 20px;
            align-items: center;
            background-color: #00bfa5;
            color: white;
        }
        header nav {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        header nav a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }
        header nav a:hover {
            text-decoration: underline;
        }
        .container {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: calc(100vh - 60px);
        }
        .leftnav {
            display: flex;
            flex-direction: column;
            gap: 12px;
            border-right: 1px solid #ccc;
            padding: 20px;
            background-color: #e0f7fa;
        }
        .leftnav a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            padding: 8px;
            border-radius: 4px;
        }
        .leftnav a:hover {
            color: #00796b;
            background-color: #b2dfdb;
        }
        .content {
            padding: 20px;
        }
        .profile-info {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
            max-width: 500px;
        }
        .profile-info img {
            border-radius: 50%;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <span><strong>My Social Network</strong></span>
        <nav>
            <img src="<?php echo $_SESSION['photo'] ; ?>" alt="avatar" width="40" height="40" style="border-radius:50%;">
            <a href="img/pic.jpg"><?php echo $_SESSION['nom'] ; ?></a>
            <a href="logOut.php">logOut</a>
        </nav>
    </header>

    <div class="container">
        <div class="leftnav">
            <a href="usersearch.php">Recherche</a>
            <a href="invetation.php">Invitations reçues</a>
            <a href="invetationEnvoie.php">Invitations envoyées</a>
            <a href="nouveauxMessage.php">Nouveaux messages</a>
            <a href="nouveauxEnvoi.php">Nouveau envoi</a>
        </div>
        <div class="content">
            <div class="profile-info">
                <h2>Bienvenue <?php echo $_SESSION['nom'] ; ?></h2>
                <img src="<?php echo $_SESSION['photo'] ; ?>" alt="Photo de profil" width="150" height="150">
                <h3>Dernière visite : <?php echo $_COOKIE['derniere_visite'] ?? 'Jamais'; ?></h3>
            </div>
        </div>
    </div>
</body>
</html>
