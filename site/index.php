<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>SFA | Login</title>
</head>
<body>
<?php
        require_once("CMS.php");
        $cms = new CMS();      
        $db = $cms->conectar();

        session_start();

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $username = mysqli_real_escape_string($db, $_POST["user"]);
            $userpass = md5(mysqli_real_escape_string($db, $_POST["pass"]));

            $query = "SELECT idUser FROM usuario WHERE username = '$username' and passwd = '$userpass'";

            $result = mysqli_query($db, $query);

            $row = mysqli_fetch_array($result);
            $active = $row['active'];
            
            $count = mysqli_num_rows($result);
                
            if($count == 1) {
                session_register("username");
                $_SESSION['login_user'] = $username;
                
                header("location: menu.php");
            }else {
                $loginerror = "O nome de usuario ou senha estão incorretos";
            }
        }
    ?>

    <div class="login">
    <h1>login</h1>
    <img src="https://via.placeholder.com/250x50/FF0000?text=LOGO">
        <form action="" method="post">
            <input type="text" name="user" placeholder="User">
            <input type="password" name="pass" placeholder=Password>
            <input type="submit" value="Login">
        </form>
        <label><?php echo @$loginerror; ?></label>
    </div>
    
</body>
</html>