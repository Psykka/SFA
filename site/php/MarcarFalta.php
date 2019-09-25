<?php
    require_once("CMS.php");
    $cms = new CMS();
    $db = $cms->conectar();

    $nome = $_POST['nome'];
    $motivo = $_POST['motivo'];

    $query = "INSERT INTO faltas VALUES (null, '$nome', '$motivo')";

    $result = mysqli_query($db, $query);

    if($result){
        echo mysqli_affected_rows($db);
        exit();
    }else{
        echo "Erro: " . mysqli_error($db);
    }
?>