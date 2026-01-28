<?php
if (isset($_GET['id'])) {

    $id = $_GET['id'];
    include('connexion.php');

    $sql = "DELETE FROM `users` WHERE `id` = ?";

    $stm = $mysqli->prepare($sql);
    $stm->bind_param("i", $id);

    if (!$stm->execute()) {
        echo "Erreur : " . $stm->error;
        exit();
    }

    header("Location: userListe.php");
    exit();

} else {
    header("Location: userListe.php");
    exit();
}
?>