<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="assets/Logo2.png" type="image/x-icon">
    <title>SFA | Funcionarios</title>
</head>
<body>
    <?php
        session_start();

        if(!isset($_SESSION['login_user'])){
            header("location:sessao.php");
            die();
        }

        require_once("php/CMS.php");
        $cms = new CMS();
        $db = $cms->conectar();

        $query = "SELECT * FROM funcionario";

        $result = mysqli_query($db, $query);

        $rows = Array();

        while($i = mysqli_fetch_assoc($result)){
            $rows[] = $i;
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
        <label>Nome:</label><input type="text" id="nome" onkeyup="rowSearch(funcionarios, 'nome', 'search');">

        <div id="search" width="500"></div>
    </div>
    
    <script type="text/javascript">
        const funcionarios = JSON.parse('<?php echo json_encode($rows); ?>');
    </script>
    <script src="./js/rowSearch.js"></script>
</body>
</html>