<?php 

    $serverName= "localhost";
    $UserName = "root";
    $passWord=""; // votre mote de passe ici
    $dataBaseName="";// base de donnee ici
    $port=3306;

    $mysqli = new mysqli($serverName,$UserName,$passWord,$dataBaseName,$port);
    if($mysqli->connect_error){
        die("Erreur : code : ".$mysqli->connect_errno. " Message : " .$mysqli->connect_error);
    }

?>