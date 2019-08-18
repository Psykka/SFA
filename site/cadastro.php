<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="assets/Logo2.png" type="image/x-icon">
    <title>SFA | Cadastro</title>
</head>
<body>
    <?php
        require_once("php/CMS.php");
        $cms = new CMS();
        $db = $cms->conectar();
    
        session_start();

        if(!isset($_SESSION['login_user'])){
            header("location:sessao.php");
            die();
        }

        if(isset($_GET['logout']) == true){
            session_destroy();
            header("Location: index.php");
            die();
        }
    ?>

    <header>
        <a href="menu.php"><img src="./assets/back.png"></a>
        <label>Voltar</label>
        <a href="menu.php?logout=true"><img src="./assets/logout.png" class="logout"></a>
    </header>
    
    <div class="container">
        <div class="cadastro">
            <form action="" method="get">
                <label>Cargo:</label><input type="number" name="">
                <label>Nome:</label><input type="text" name="">
                <label>RG:</label><input type="text" name="">
                <input type="submit" value="CADASTRAR">
            </form>
        </div>
    </div>
</body>
</html>