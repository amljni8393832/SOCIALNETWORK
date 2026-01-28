<?php
session_start();
include('connexion.php');

// ✅ Traitement des actions (accepter / refuser)
if(isset($_GET['accepter'])){
    $invitation_id = intval($_GET['accepter']);
    $sql = "UPDATE invitation SET statut = 'accepte' WHERE id = ?";
    $stm = $mysqli->prepare($sql);
    $stm->bind_param("i", $invitation_id);
    $stm->execute();
    header('Location: amis.php');
    exit();
}

if(isset($_GET['refuser'])){
    $invitation_id = intval($_GET['refuser']);
    $sql = "UPDATE invitation SET statut = 'refuse' WHERE id = ?";
    $stm = $mysqli->prepare($sql);
    $stm->bind_param("i", $invitation_id);
    $stm->execute();
    header('Location: invetation.php');
    exit();
}


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
        
        <main class="main-content">
            <div class="invitations-section">
                <h2>Invitations reçues</h2>
                
                <?php
                $user_id = $_SESSION['ID'];
                
                $sql = "SELECT i.id, i.date, u.nom, u.email, u.function, u.photo 
                        FROM invitation i 
                        JOIN users u ON i.expediteur = u.id 
                        WHERE i.destinataire = ? AND i.statut = 'en_attente'
                        ORDER BY i.date DESC";
                
                $stm = $mysqli->prepare($sql);
                $stm->bind_param("i", $user_id);
                $stm->execute();
                $result = $stm->get_result();
                
                if($result->num_rows > 0){
                    echo '<div class="invitations-list">';
                    
                    while($row = $result->fetch_assoc()){
                        echo '<div class="invitation-card">
                                <div class="invitation-avatar">';
                        
                        if(!empty($row['photo'])){
                            echo '<img src="'.$row['photo'].'" alt="Photo de '.htmlspecialchars($row['nom']).'">';
                        } else {
                            echo '<div class="default-avatar">'.substr($row['nom'], 0, 1).'</div>';
                        }
                        
                        echo '</div>
                                <div class="invitation-info">
                                    <h3>'.$row['nom'].'</h3>
                                    <p class="invitation-role">'.$row['function'].'</p>
                                    <p class="invitation-email">'.$row['email'].'</p>
                                    <p class="invitation-date">Invitation reçue le '.date('d/m/Y', strtotime($row['date'])).'</p>
                                </div>
                                <div class="invitation-actions">
                                    <a href="accepteInvitation.php?accepter='.$row['id'].'" class="btn-accept">Accepter</a>
                                    <a href="invetation.php?refuser='.$row['id'].'" class="btn-decline">Refuser</a>
                                </div>
                            </div>';
                    }
                    
                    echo '</div>';
                } else {
                    echo '<div class="no-invitations">
                            <h3>Aucune invitation en attente</h3>
                            <p>Vous n\'avez pas de nouvelles invitations pour le moment.</p>
                          </div>';
                }
                ?>
            </div>
        </main>
    </div>
</body>
</html>
