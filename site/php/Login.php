<?php
    require_once("CMS.php");
    $cms = new CMS();
    $db = $cms->conectar();

    $username = mysqli_real_escape_string($db, $_POST["user"]);
    $userpass = md5(mysqli_real_escape_string($db, $_POST["pass"]));

    $query = "SELECT idUser FROM usuario WHERE username = '$username' and passwd = '$userpass'";

    $result = mysqli_query($db, $query);

    if ($result) {
        $row = mysqli_fetch_array($result);
    }

    $count = mysqli_num_rows($result);

    if ($count == 1) {
        session_start();
        $_SESSION['login_user'] = $username;
        exit;
    } else {
        echo error_log("Nome de usuário ou senha incorretos");
    }
?>