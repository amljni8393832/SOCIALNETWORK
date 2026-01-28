<?php
    if(!empty($_POST['texte'])){
        session_start();
        
        $myid=$_SESSION['id'];
        $exp=$_POST['expediteur'];
        $objct=$_POST['object'];

        include('connexion.php');
        
        $sql = "insert into message(id , expediteur , object)
                values($myid , $exp , $object );";


        if($mysqli->errno){
            echo"message : erreur ".$mysqli->errno."code".$mysqli->error;
        }
    }else{
        header("location:profil.php");
    }
?>