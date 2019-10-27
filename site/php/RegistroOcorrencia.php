<?php
    require_once("CMS.php");
    $cms = new CMS();
    $db = $cms->conectar();
    
    $id = $_POST['id'];
    $atrasoMinutos = $_POST['atrasoMinutos'];
    $quantidadeAulas = $_POST['quantidadeAulas'];
    $quantidadeHaes = $_POST['quantidadeHaes'];
    $justificativa = $_POST['justificativa'];

    $query = "UPDATE `faltas` SET atrasoMinutos = '$atrasoMinutos', quantidadeAulas = '$quantidadeAulas', quantidadeHaes = '$quantidadeHaes', justificativa = '$justificativa', visto = 1 WHERE `faltas`.`idfalta` = $id";

    $result = mysqli_query($db, $query);

    if($result){
        echo mysqli_affected_rows($db);
        exit();
    }else{
        echo "Erro: " . mysqli_error($db);
    }
?>