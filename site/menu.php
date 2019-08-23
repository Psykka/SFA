<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="assets/Logo2.png" type="image/x-icon">
    <title>SFA | Menu</title>
</head>
<body>
    <?php
        session_start();

        if(!isset($_SESSION['login_user'])){
            header("location: sessao.php");
            die();
        }

        if(isset($_GET['logout']) == true){
            session_destroy();
            header("Location: index.php");
            die();
        }
    ?>

    <header>
        <img src="./assets/user.png">
        <label>Bem vindo, <?php echo $_SESSION['login_user'] ?></label>
        <a href="menu.php?logout=true"><img src="./assets/logout.png" class="logout"></a>
    </header>
    
    <div class="container">
        <a href="cadastro.php">
            <div class="item-menu">
                <label>Novo Cadastro</label>
                <img src="./assets/cadastro.png">
            </div>
        </a>
        <a href="funcionarios.php">
            <div class="item-menu">
                <label>Funcionários</label>
                <img src="./assets/funcionarios.png">
            </div>
        </a>

        <div class="days">
            <table>
                <tr class="funcionario">
                    <th></th>
                    <th colspan="2">Segunda</th>
                    <th colspan="2">Terça</th>
                    <th colspan="2">Quarta</th>
                    <th colspan="2">Quinta</th>
                    <th colspan="2">Sexta</th>
                </tr>
                <tr class="funcionario">
                    <?php
                        //começo da tablela
                        echo "<th>Funcionario</th>";
                        for($i = 0; $i < 5; $i++){
                            echo "<th>Saida</th><th>Entrada</th>";
                        }
                    ?>
                </tr>
                <tr>
                    <!--Funcionario--><td>Marcia</td>
                    <!--Segunda--><td>11:40</td><td>13:30</td>
                    <!--Terça--><td>11:40</td><td>13:30</td>
                    <!--Quarta--><td>11:40</td><td>13:30</td>
                    <!--Quinta--><td>11:40</td><td>13:30</td>
                    <!--Sexta--><td>11:40</td><td>13:30</td>
                </tr>
                <tr>
                    <!--Funcionario--><td>Mauro</td>
                    <!--Segunda--><td>11:40</td><td>13:30</td>
                    <!--Terça--><td>11:40</td><td>13:30</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>