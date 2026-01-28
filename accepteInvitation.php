
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitations - Réseau Social</title>
    <link rel="stylesheet" href="style.css">

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
        .dashboard {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: calc(100vh - 60px);
        }
        .sidebar {
            background-color: #e0f7fa;
            padding: 20px;
            border-right: 1px solid #ccc;
        }
        .sidebar-nav a {
            display: block;
            text-decoration: none;
            color: #333;
            font-weight: bold;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .sidebar-nav a:hover, .nav-active {
            color: #00796b;
            background-color: #b2dfdb;
        }
        .main-content {
            padding: 20px;
        }
        .invitations-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
        }
        .invitations-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .invitation-card {
            background: #fefefe;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0px 2px 4px rgba(0,0,0,0.1);
        }
        .invitation-avatar img {
            border-radius: 50%;
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .default-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #00bfa5;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: auto;
            margin-bottom: 10px;
        }
        .invitation-info h3 {
            margin: 5px 0;
            color: #00796b;
        }
        .invitation-info p {
            margin: 3px 0;
            font-size: 14px;
            color: #555;
        }
        .invitation-actions {
            margin-top: 10px;
        }
        .invitation-actions a {
            display: inline-block;
            margin: 5px;
            padding: 6px 12px;
            font-size: 13px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
        }
        .btn-accept { background-color: #00bfa5; }
        .btn-decline { background-color: #e53935; }
        .btn-accept:hover { background-color: #009688; }
        .btn-decline:hover { background-color: #c62828; }
        .no-invitations {
            text-align: center;
            padding: 20px;
            color: #555;
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

    <div class="dashboard">
        <aside class="sidebar">
            <nav class="sidebar-nav">
                <a href="profil.php">Mon Profil</a>
                <a href="amis.php">Mes Amis</a>
                <a href="userlist.php">Liste des utilisateurs</a>
                <a href="usersearch.php">Rechercher</a>
                <a href="invetation.php" class="nav-active">Invitations reçues</a>
                <a href="invitationEnvoie.php">Invitations envoyées</a>
                <a href="message.php">Messages</a>
            </nav>
        </aside>
    </div>
</body>
</html>
<?php
    session_start();
    include('connexion.php');

    if (isset($_GET['accepter'])) {
        $invitation_id = $_GET['accepter'];
        $user_id = $_SESSION['ID']; 

        // Récupérer l'invitation
        $sql = "SELECT expediteur, destinataire FROM invitation WHERE id = ? AND statut = 'en_attente'";
        $stm = $mysqli->prepare($sql);
        $stm->bind_param("i", $invitation_id);
        $stm->execute();
        $result = $stm->get_result();

        if ($result->num_rows > 0) {
            $inv = $result->fetch_assoc();

            // Vérifier que l'utilisateur connecté est bien le destinataire
            if ($inv['destinataire'] == $user_id) {
                // Mettre à jour le statut
                $sqlUpdate = "UPDATE invitation SET statut = 'accepte' WHERE id = ?";
                $stmUpdate = $mysqli->prepare($sqlUpdate);
                $stmUpdate->bind_param("i", $invitation_id);
                $stmUpdate->execute();

                // Insérer dans la table amis
                $sqlInsert = "INSERT INTO amis (user1, user2, date_amitie) VALUES (?, ?, ?)";
                $stmInsert = $mysqli->prepare($sqlInsert);
                $dateAmitie = date("Y-m-d H:i:s");
                $stmInsert->bind_param("iis", $inv['expediteur'], $inv['destinataire'], $dateAmitie);
                $stmInsert->execute();

                // Rediriger vers la liste des amis
                echo " l'amis est bien ajouter !!";
                exit();
            } else {
                echo "Erreur : vous n'êtes pas le destinataire de cette invitation.";
            }
        } else {
            echo "Invitation introuvable ou déjà traitée.";
        }
    }
?>



