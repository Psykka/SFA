<?php
    require_once("CMS.php");
    $cms = new CMS();
    $db = $cms->conectar();
    
    $id = $_POST['id'];

    $query = "DELETE FROM `funcionario` WHERE `funcionario`.`idFunc` = $id";

    $result = mysqli_query($db, $query);

    if($result){
        echo mysqli_affected_rows($db);
        exit();
    }else{
        echo "Erro: " . mysqli_error($db);
    }
?>