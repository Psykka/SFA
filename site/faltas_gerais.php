<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="assets/Logo2.png" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <title>SFA | Faltas Gerais</title>
</head>

<body>
    <?php
        session_start();

        require_once("php/CMS.php");
        $cms = new CMS();
        $db = $cms->conectar();

        $mes = date('m');
        $ano = date('Y');

        $query = "select falt.idFalta, func.nome, falt.dia, m.motivo, falt.atrasoMinutos, falt.quantidadeAulas, falt.quantidadeHaes, falt.justificativa, falt.visto from faltas as falt inner join funcionario as func inner join motivo as m on falt.idFunc = func.idfunc and falt.idMotivo = m.idMotivo where MONTH(dia) = $mes and YEAR(dia) = $ano;";

        $result = mysqli_query($db, $query);

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
        <div class="cadastro">
            <h1>Faltas Gerais</h1>
            <?php
                if($result->num_rows == 0){
                    echo "Não há nada aqui...";
                }
                while($row = mysqli_fetch_array($result)){
                    for($i = 0; $i <= 8; $i++){
                        echo "<td>$row[$i]<br></td>";
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>