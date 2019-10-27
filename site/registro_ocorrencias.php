<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="assets/Logo2.png" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>SFA | Registro de Ocorrências</title>
</head>
<body onload="rowSearch(faltas, 'search');">
    <?php
        session_start();

        if(!isset($_SESSION['login_user'])){
            header("location:sessao.php");
            die();
        }

        require_once("php/CMS.php");
        $cms = new CMS();
        $db = $cms->conectar();

        $query = "select falt.idFalta, func.nome, falt.dia, m.motivo, falt.visto from faltas as falt inner join funcionario as func inner join motivo as m on falt.idFunc = func.idfunc and falt.idMotivo = m.idMotivo where visto = 0;";

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

        if(isset($_GET['idFalta']) == true){
            $idFalta = $_GET['idFalta'];
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
            <h1>Registro de Ocorrências</h1>
        </div>
        <div style="border: 1px solid">
            <h6 style="text-align: center">Faltas não registradas</h6>
            <div id="search"></div>
        </div>
        <div class="cadastro" style="display: inline !important">
            <form class="" style="margin-top: 5px" method="post">
                <strong>Data:&nbsp</strong><input type="date" id="dia" disabled>
                <input type="text" placeholder="Nome" id="nome" disabled>
                <input type="text" placeholder="Motivo" id="motivo" disabled>
                <input type="text" placeholder="Atraso em minutos" required>
                <input type="text" placeholder="Quantidade de aulas" required>
                <input type="text" placeholder="Quantidade de haes" required>
                <input type="text" placeholder="Justificativa" required>
            </form>
            <input type="submit" value="Enviar">
        </div>
    </div>
    <script type="text/javascript">
        const faltas = JSON.parse('<?php echo json_encode($rows); ?>');
    </script>
    <script type="text/javascript">
        function setValues(id, faltas){
            falta = faltas.filter(x => x.idFalta == id);
            if(!id || !falta) return;
            console.log(faltas)
            $(document).ready(() =>{
                $("#nome").val(falta[0].nome);
                $("#motivo").val(falta[0].motivo);
                $("#dia").val(falta[0].dia)
            });
        }
        setValues(<?php echo $idFalta?>, faltas);
    </script>
    <script src="./js/rowRegistroOcorrencias.js"></script>
</body>
</html>