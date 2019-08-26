<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="assets/Logo2.png" type="image/x-icon">
    <title>SFA | Menu</title>
</head>
<body>
    <?php        require_once("php/CMS.php");
        $cms = new CMS();
        $db = $cms->conectar();

        $query = "SELECT * FROM funcionario";

        $result = mysqli_query($db, $query);

        $rows = Array();

        while($i = mysqli_fetch_assoc($result)){
            $rows[] = $i;
        }
        
        $diasDaSemana = Array(
            1 => "Segunda-Feira",
            2 => "Terça-Feira",
            3 => "Quarta-Feira",
            4 => "Quinta-Feira",
            5 => "Sexta-Feira"
        );

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
        <a href="cadastro_funcionario.php">
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
                    <?php

                        $date = date('w');
                        
                        $dia = $diasDaSemana[$date];

                        echo "<th colspan='2'>$dia</th>"
                    ?>
                    
                </tr>
                <tr class="funcionario">
                    <th>Funcionario</th>
                    <th>Saida</th><th>Entrada</th>
                </tr>
                <tr>
                    <?php
                        foreach($rows as $funcionario){
                            $nome = $funcionario['nome'];

                            echo "<tr><td>$nome</td><td>{horario saida}</td><td>{horario entrada}</td></tr>";
                        }
                    ?>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>