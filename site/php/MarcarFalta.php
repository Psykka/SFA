<?php
    require_once("CMS.php");
    $cms = new CMS();
    $db = $cms->conectar();

    $idFunc = $_POST['idFunc'];
    $motivo = $_POST['motivo'];
    $dia = $_POST['data']

    //$query = "INSERT INTO falta VALUES (null, '$idFunc', '$motivo')";

    $result = mysqli_query($db, $query);

    if($result){
        echo mysqli_affected_rows($db);
        exit();
    }else{
        echo "Erro: " . mysqli_error($db);
    }
?>