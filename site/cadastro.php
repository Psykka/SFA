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
    <h1>Cadastro Funcionários</h1>
        <form action="" method="post">
            <input type="text" name="cargo" placeholder="Cargo">
            <input type="text" name="nome" placeholder="Nome">
			<input type="text" name="rg" placeholder="RG">
            <input type="submit" value="Cadastrar">
            </form>
        </div>
    </div>
</div>
</body>
</html>