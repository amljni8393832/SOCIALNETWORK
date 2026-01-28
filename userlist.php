<?php
    session_start();
    include('connexion.php');

    $sql = "SELECT * FROM users";

    if($mysqli->connect_error){
        die("Erreur : code : ".$mysqli->connect_errno. " Message : " .$mysqli->connect_error);
    }

    $result = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>
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
        .card { background:white; padding:20px; border-radius:8px; box-shadow:0px 2px 6px rgba(0,0,0,0.1); }
        table { width:100%; border-collapse:collapse; margin-top:10px; }
        th, td { padding:10px; text-align:left; border-bottom:1px solid #ddd; }
        th { background:#00bfa5; color:white; }
        tr:hover { background:#f1f1f1; }
        .actions a { margin-right:8px; text-decoration:none; font-size:13px; font-weight:bold; }
        .actions a:hover { text-decoration:underline; }
    </style>
</head>
<body>
    <header>
        <span><strong>My Social Network</strong></span>
        <nav>
            <img src="<?php echo $_SESSION['photo']; ?>" alt="avatar" width="40" height="40" style="border-radius:50%;">
            <a href="#"><?php echo $_SESSION['nom']; ?></a>
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
            <div class="card">
                <h2>Liste des utilisateurs</h2>
                <?php
                if($result && $result->num_rows >= 1){
                    echo '<table>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Fonction</th>
                                <th>Actions</th>
                            </tr>';
                    
                    while ($row = $result->fetch_assoc()){
                        echo '<tr>
                                <td>'. $row['id'] .'</td>
                                <td>'. $row['nom'] .'</td>
                                <td>'. $row['email'] .'</td>
                                <td>'. $row['function'] .'</td>
                                <td class="actions">
                                    <a href="details.php?id='.$row['id'].'">Détails</a>
                                    <a href="supprimer.php?id='.$row['id'].'">Supprimer</a>
                                    <a href="formModifier.php?id='.$row['id'].'">Modifier</a>
                                </td>
                              </tr>';
                    }
                    
                    echo '</table>';
                } else {
                    echo "<p>Aucun utilisateur trouvé.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
