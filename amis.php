<?php
session_start();
if(!isset($_SESSION['statut']) || $_SESSION['statut'] != 'onLine'){
    header('location:index.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Amis - Réseau Social</title>
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
        .friends-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
        }
        .friends-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .friend-card {
            background: #fefefe;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0px 2px 4px rgba(0,0,0,0.1);
        }
        .friend-avatar img {
            border-radius: 50%;
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .friend-info h3 {
            margin: 5px 0;
            color: #00796b;
        }
        .friend-info p {
            margin: 3px 0;
            font-size: 14px;
            color: #555;
        }
        .friend-actions {
            margin-top: 10px;
        }
        .friend-actions a {
            display: inline-block;
            margin: 5px;
            padding: 6px 12px;
            font-size: 13px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
        }
        .btn-view { background-color: #00bfa5; }
        .btn-message { background-color: #00796b; }
        .btn-remove { background-color: #e53935; }
        .btn-view:hover { background-color: #009688; }
        .btn-message:hover { background-color: #004d40; }
        .btn-remove:hover { background-color: #c62828; }
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
                <a href="amis.php" class="nav-active">Mes Amis</a>
                <a href="userlist.php">Liste des utilisateurs</a>
                <a href="usersearch.php">Rechercher</a>
                <a href="invetation.php">Invitations reçues</a>
                <a href="invetationEnvoie.php">Invitations envoyées</a>
                <a href="message.php">Messages</a>
            </nav>
        </aside>
        
        <main class="main-content">
            <div class="friends-section">
                <h2>Mes Amis</h2>
                <p class="section-description">Voici la liste de vos amis connectés</p>
                
                <?php
                include('connexion.php');
                $user_id = $_SESSION['ID'];
                
                $sql = "SELECT u.id, u.nom, u.email, u.function, u.photo, a.date_amitie
                        FROM amis a
                        JOIN users u ON (
                            (a.user1 = ? AND u.id = a.user2) OR 
                            (a.user2 = ? AND u.id = a.user1)
                        )
                        WHERE (a.user1 = ? OR a.user2 = ?);";

                $stm = $mysqli->prepare($sql);
                $stm->bind_param("iiii", $user_id, $user_id, $user_id, $user_id);
                $stm->execute();
                $result = $stm->get_result();
                
                if($result->num_rows > 0){
                    echo '<div class="friends-grid">';
                    while($row = $result->fetch_assoc()){
                        echo '<div class="friend-card">
                                <div class="friend-avatar">
                                    <img src="'.$row['photo'].'" alt="Photo de '.$row['nom'].'">
                                </div>
                                <div class="friend-info">
                                    <h3>'.$row['nom'].'</h3>
                                    <p class="friend-role">'.$row['function'].'</p>
                                    <p class="friend-email">'.$row['email'].'</p>
                                    <p class="friend-since">Amis depuis le '.date('d/m/Y', strtotime($row['date_amitie'])).'</p>
                                </div>
                                <div class="friend-actions">
                                    <a href="details.php?id='.$row['id'].'" class="btn-view">Voir profil</a>
                                    <a href="message.php?id='.$row['id'].'" class="btn-message">Message</a>
                                    <a href="supprimerAmi.php?id='.$row['id'].'" class="btn-remove" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cet ami ?\')">Supprimer</a>
                                </div>
                              </div>';
                    }
                    echo '</div>';
                } else {
                    echo '<p>Vous n\'avez pas encore d\'amis ajoutés.</p>';
                }
                ?>
            </div>
        </main>
    </div>
</body>
</html>

