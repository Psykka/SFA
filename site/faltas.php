<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="assets/Logo2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>SFA | Horario</title>
</head>
<body>
    <?php
        require_once("php/CMS.php");
        $cms = new CMS();
        $db = $cms->conectar();

        $query = "SELECT * FROM funcionario";

        $result = mysqli_query($db, $query);

        $rows = Array();

        while($i = mysqli_fetch_assoc($result)){
            $rows[] = $i;
        }

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

        $meses = array(
            1 => 'Janeiro',
            'Fevereiro',
            'Março',
            'Abril',
            'Maio',
            'Junho',
            'Julho',
            'Agosto',
            'Setembro',
            'Outubro',
            'Novembro',
            'Dezembro'
        );
    ?>
    <header class="d-flex justify-content-between">
        <div>
            <a href="menu.php">
                <img src="./assets/back.png">
                <strong>Voltar</strong>
            </a>
        </div>
        <div>
            <a href="menu.php?logout=true">
                <img src="./assets/logout.png">
            </a>
        </div>
    </header>

    <div class="container">
        <table class="days">
            <thead>
                <tr class="funcionario">
                    <?php
                        echo "<th colspan='" . ((31 * 2) + 2) . "'>" . $meses[date('n')] . "</th>";
                    ?>
                </tr>
                <tr class="funcionario">
                    <th colspan="2">Provedores</th>
                    <th colspan="31">Dias</th>
                </tr>
                <tr class="funcionario">
                    <th>#</th>
                    <th>Nome</th>
                    <?php
                        $dias = array();

                        for($d = 0; $d <= date('t'); $d++){
                            array_push($dias, $d);
                        }

                        for($i = date('j'); $i <= $x = empty($dias[date('j') + 15]) ? count($dias) - $dias[date('j')] + 15 : $dias[date('j') + 15]; $i++){
                            if($i > date('t')){
                                return;
                            }else{
                                echo "<th>$i</th>";
                            }
                        }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($rows as $funcionario){
                        $nome = $funcionario['nome'];
                        $id = $funcionario['idFunc'];

                        $chamada = "";

                        for($i = 1; $i <= 16; $i++){
                            $chamada = $chamada . "<td> <select name='chamada'><option value='P'>P</option></select> </td>";
                        }

                        echo "<tr><th>$id</th><td>$nome</td> $chamada </tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>