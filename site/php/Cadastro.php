<?php
    require_once("CMS.php");
    $cms = new CMS();
    $db = $cms->conectar();

    $cargo = $_POST['cargo'];
    $nome = $_POST['nome'];
    $rg = $_POST['rg'];

    $query = "INSERT INTO funcionario VALUES (null, '$cargo', '$nome', '$rg')";

    $result = mysqli_query($db, $query);

    if($result){
        echo mysqli_affected_rows($db);
        exit();
    }else{
        echo "Erro: " . mysqli_error($db);
    }
?>