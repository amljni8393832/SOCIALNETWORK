<?php 
if(isset($_GET['id'])){
    $userId= $_GET['id'];
    include('connexion.php');
    
    //requette de selection
    $sql = "SELECT * FROM `users` WHERE `id`= ? ;";
    
    $stm = $mysqli->prepare($sql);
    $stm->bind_param("i",$userId);
    //Executer la requette
    $stm->execute();
    //$stm->bint_result($i,$n,$e,$f);
    //$stm->fetch();
    $result=$stm->get_Result();
    $row=$result->fetch_assoc();
            //ghadi tzid dak $row[id];
    echo'
    <table border="1">
        <tr>
            <td>id</td>
            <td>nom</td>
            <td>fonction</td>
            <td>email</td>
            
        </tr>
        <tr>
            <td>' . $row['id'] . '</td>
            <td>' . $row['nom'] . '</td>
            <td>' . $row['function'] . '</td>
            <td>' . $row['email'] . '</td>
        </tr>
        
    <table>
    
    ';
}