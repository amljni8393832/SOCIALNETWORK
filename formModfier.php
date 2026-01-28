<?php
    if(isset($_GET['id'])){
        
        $id=$_GET['id'];
        //Inclure la connexion
        include('connexion.php');
        $sql="DELETE FROM `users` WHERE `id`= ?;";
        $stm = $mysqli->prepare($sql);
        $stm->bind_param("i",$id);
        //Executer la requette
        $stm->execute();
        if($stm->errno){
            echo"erreur ".$stm->error;
        }
        else{
            header("location:");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>Autenthification</h3>
    <br>
<form action="modefier.php" method="post" >
    <input type="hidden" value="<?php echo $row['id'];?>" readonly >
    <label for=""> nom </label>
    <input type="text" name="nom" required value="<?php echo $row['nom'];?>">
    <br>
    <label for=""> email </label>
    <input type="email" name="email" value="<?php echo $row['nom'];?>" required>
    <br>
    <label for="fonctionId">Fonction</label>
    <select name="fonction" id="fonctionId">
        <option value="PROF"<?php if ($row['fonction']=='PROF') echo 'selected';?>>Professeur</option>
        <option value="ETUD"<?php if ($row['fonction']=='ETUD') echo 'selected';?> >Etudiant</option>
        <option value="ADMIN"<?php if ($row['fonction']=='ADMIN') echo 'selected';?>>Administrateur</option>
    </select>
    <label>photo</label>
    <input type="file" name="photo" id="">
    <br>
    <input type="submit" value="login">
    <input type="reset" value="reset">
</body>
</html>