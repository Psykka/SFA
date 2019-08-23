<?php
    require_once("CMS.php");
    $cms = new CMS();
    $db = $cms->conectar();
    
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $rg = $_POST['rg'];

    $query = "UPDATE `funcionario` SET nome = '$nome', rg = '$rg' WHERE `funcionario`.`idFunc` = $id";

    $result = mysqli_query($db, $query);

    if($result){
        echo mysqli_affected_rows($db);
        exit();
    }else{
        echo "Erro: " . mysqli_error($db);
    }
?>