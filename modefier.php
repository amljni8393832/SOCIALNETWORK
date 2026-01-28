<?php 
if(isset($_POST['id']) && isset($_POST['nom']) &&  isset($_POST['email'])){
    include('connexion.php');
    $id=$_POST['id'];
    $nom=$mysqli->real_escape_string($_POST['nom']);
    $email=$mysqli->real_escape_string($_POST['email']);
    $fonction=$mysqli->real_escape_string($_POST['function']);

    // Requête de modification avec prepared statement
    $sql = "UPDATE `users` 
            SET `nom` = ? , `function` = ?, `email` = ? 
            WHERE `id` = ?";
    $stm = $mysqli->prepare($sql);
    $stm->bind_param("sssi", $nom, $fonction, $email, $id);

    // Exécuter la requête
    $stm->execute();
    if($stm->errno){
        echo $stm->errno;
    }
    $stm->close();
    $mysqli->close();
    header("location:userlist.php");


}