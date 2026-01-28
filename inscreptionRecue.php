<?php
session_start();

if(isset($_POST['nom']) && isset($_POST['email'])){
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $fonction = $_POST['function'];
    $password = md5($_POST['password']);  

    include('connexion.php');

    $sql = "INSERT INTO users (nom, email, function, mdp) VALUES (?, ?, ?, ?)";
    $stm = $mysqli->prepare($sql);
    $stm->bind_param("ssss", $nom, $email, $fonction, $password);
    $stm->execute();

    if($stm->errno){
        echo "Erreur : ".$stm->error;
    } else {
        $_SESSION['id'] = $mysqli->insert_id;
        $_SESSION['nom'] = $nom;
        $_SESSION['photo'] = "pic.jpg"; 

        // Redirection vers profil
        header("Location: profil.php");
        exit();
    }
} else {
    header("Location: inscription.html");
    exit();
}
?>

