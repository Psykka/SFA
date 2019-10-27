<?php
    require_once("CMS.php");
    $cms = new CMS();
    $db = $cms->conectar();

    $cargo = $_POST['cargo'];

    $query = "INSERT INTO cargo VALUES (null, '$cargo')";

    $result = mysqli_query($db, $query);

    if($result){
        echo mysqli_affected_rows($db);
        exit();
    }else{
        echo "Erro: " . mysqli_error($db);
    }
?>