<?php
   if(isset($_GET['id'])){
        
        $ami=$_GET['id'];
    
        include('connexion.php');
        $user_id = $_SESSION['ID'];
        
      $sql = "DELETE FROM amis 
              WHERE (user1 = $user_id AND user2 = $ami) 
              OR (user1 = $ami AND user2 = $user_id)";
        $mysqli->query($sql);
        header('location :amis.php');
   }
?>