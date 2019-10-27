<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="assets/Logo2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>SFA | Menu</title>
</head>
<body>
    <?php
        session_start();

        require_once("php/CMS.php");
        $cms = new CMS();
        $db = $cms->conectar();

        $query = "SELECT * FROM funcionario";

        $result = mysqli_query($db, $query);

        $rows = Array();

        while($i = mysqli_fetch_assoc($result)){
            $rows[] = $i;
        }
        
        $diasDaSemana = Array(
            0 => "",
            1 => "Segunda-Feira",
            2 => "Terça-Feira",
            3 => "Quarta-Feira",
            4 => "Quinta-Feira",
            5 => "Sexta-Feira",
            6 => ""
        );

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

    <header class="d-flex justify-content-between">
        <div>
            <img src="./assets/user.png">
            <strong>Bem vindo, <?php echo $_SESSION['login_user']?></strong>
        </div>
        <a href="menu.php?logout=true">
            <img src="./assets/logout.png">
        </a>
    </header>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="item-menu col-sm-12 col-md-5">
                <a href="cadastro.php">
                    <strong>Novo Cadastro</strong>
                    <img src="./assets/cadastro.png">
                </a>
            </div>
            <div class="item-menu col-sm-12 col-md-5">
                <a href="funcionarios.php">
                    <strong>Funcionários</strong>
                    <img src="./assets/funcionarios.png">
                </a>
            </div>
            <div class="item-menu col-sm-12 col-md-5">
                <a href="faltas.php">
                    <strong>Controle de Faltas</strong>
                    <img src="./assets/horario.png">
                </a>
            </div>
            <div class="item-menu col-sm-12 col-md-5">
                <a href="registro_ocorrencias.php">
                    <strong>Registro de Ocorrências</strong>
                    <img src="./assets/frequencia.png">
                </a>
            </div>
        </div>
        <div class="row">
            <div class="days">
                <table>
                    <thead>
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
                    <thead>
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
    </div>
</body>
</html>