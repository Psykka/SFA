<?php
    require_once("CMS.php");
    $cms = new CMS();
    $db = $cms->conectar();

    $idFunc = $_POST['idFunc'];
    $idMotivo = $_POST['motivo'];
    $dia = $_POST['dia'];

    $query = "INSERT INTO faltas VALUES (null, '$idFunc', '$idMotivo', '$dia', 0)";

    $result = mysqli_query($db, $query);

    if($result){
        echo mysqli_affected_rows($db);
        exit();
    }else{
        echo "Erro: " . mysqli_error($db);
    }
?>