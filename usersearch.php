<?php
    session_start();
    //print_r($_SESSION);
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
            max-width: 700px;
        }
        .profile-info img {
            border-radius: 50%;
            margin-top: 10px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        th {
            background-color: #e0f7fa;
        }
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
            <a href="profil.php">Mon Profil</a>
            <a href="amis.php">Mes Amis</a>
            <a href="userlist.php">Liste des utilisateurs</a>
            <a href="invetation.php" class="nav-active">invetation recue </a>
            <a href="invetation.php" class="nav-active">invetation Envoyer</a>
        </div>
        <div class="content">
            <div class="profile-info">
                <h2>Bienvenue <?php echo $_SESSION['nom']; ?></h2>
                <img src="<?php echo $_SESSION['photo']; ?>" alt="Photo de profil" width="150" height="150">
                <h3>Dernière visite : <?php echo $_COOKIE['derniere_visite'] ?? 'Jamais'; ?></h3>

                <form action="usersearch.php" method="get">
                    <input type="text" name="searchword" placeholder="Rechercher un utilisateur">
                    <input type="submit" value="Rechercher">
                </form>

                <?php
                if (isset($_GET['searchword']) && !empty($_GET['searchword'])) {
                    $searchword = $_GET['searchword'];
                    include('connexion.php');
                    $sql = "SELECT id, nom, function, email FROM users WHERE nom LIKE ?;";
                    $stm = $mysqli->prepare($sql);
                    $like = "%".$searchword."%";
                    $stm->bind_param("s", $like);
                    $stm->execute();
                    $result = $stm->get_result();

                    if ($result->num_rows > 0) {
                        echo "<table>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Fonction</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>".$row['id']."</td>
                                    <td>".$row['nom']."</td>
                                    <td>".$row['function']."</td>
                                    <td>".$row['email']."</td>
                                    <td>
                                        <a href='invetationEnvoie.php?id=".$row['id']."'>Ajouter</a> | 
                                        <a href='message.php?id=".$row['id']."'>Envoyer un message</a>
                                    </td>
                                  </tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<p>Aucun utilisateur trouvé.</p>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>

