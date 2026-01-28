<?php
if (isset($_POST['login']) && isset($_POST['password'])) {

    // Récupération des données du formulaire
    $login    = $_POST['login'];
    $password = md5($_POST['password']);

    // Connexion à la base
    include('connexion.php');

    // Préparation de la requête SQL
    $sql  = "SELECT `id`, `nom`, `function` ,`photo`
             FROM `users` 
             WHERE `email` = ? AND `mdp` = ?;";
    $stm  = $mysqli->prepare($sql);

    // Lier les paramètres
    $stm->bind_param("ss", $login, $password);

    // Exécuter la requête
    $stm->execute();
    $result = $stm->get_result();

    // Vérifier si un utilisateur est trouvé
    if ($result->num_rows == 1) {

        $data = $result->fetch_assoc();

        // Démarrer la session
        session_start();
        $_SESSION['statut']   = "onLine";
        $_SESSION['ID']       = $data['id'];
        $_SESSION['nom']      = $data['nom'];
        $_SESSION['function'] = $data['function'];
        $_SESSION['photo'] = $data['photo'];

        // Gestion du cookie "derniere_visite"
        $mycookie = isset($_COOKIE["derniere_visite"]) ? $_COOKIE["derniere_visite"] : null;
        $_SESSION['derniere_visite'] = $mycookie;

        if (isset($mycookie)) {
            echo "Votre derniere visite etait le : " . $mycookie;
        }

        $date = date("Y-m-d H:i:s");
        setcookie("derniere_visite", $date, time() + (3600*2));

        // Redirection vers profil
        header('location:profil.php');
        exit();

    } else {
        // Identifiants incorrects
        $msg = urlencode("Les données sont incorrectes");
        header('location:index.html?error=' . $msg);
        exit();
    }

} else {
    // Champs vides
    $msg = urlencode("Champs vides");
    header('location:index.html?error= ' . $msg);
    exit();
}
?>
