<?php
    require_once("CMS.php");
    $cms = new CMS();
    $db = $cms->conectar();

    $motivo = $_POST['motivo'];

    $query = "INSERT INTO motivo VALUES (null, '$motivo')";

    $result = mysqli_query($db, $query);

    if($result){
        echo mysqli_affected_rows($db);
        exit();
    }else{
        echo "Erro: " . mysqli_error($db);
    }
?>