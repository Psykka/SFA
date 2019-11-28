<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/Logo2.png" type="image/x-icon">
    <title>Relatorio</title>
    <style>
        table, th, td {
            border: 1px solid black;
            text-align: center;
        }
        thead {
            text-align: center;
        }
        thead img {
            height: 50px;
        }
        button {
            margin-top: 20px;
        }
        button img {
            margin: 3px;
            height: 30px;
            vertical-align: middle;
        }
        button a {
            color: black;
            text-decoration: none;
        }
        .right{
            float: right;
        }
        .left {
            float: left;
        }

    </style>
</head>
<?php
        session_start();

        require_once("php/CMS.php");
        $cms = new CMS();
        $db = $cms->conectar();
        
        if(empty($_POST['mes'])){
            echo "Não consegui gerar o relatório.";
            die();
        }

        function formatDate($data){
            list($dia, $mes, $_ano) = explode('/', $data);
            list($ano) = explode(' ', $_ano);
            return "$ano-$mes-$dia";
        }

        function formatDateRelatorio($data){
            list($ano, $mes, $dia) = explode('-', $data);
            return "$dia/$mes/$ano";
        }

        list($_datainicio, $_datafim) = explode(' - ', $_POST['mes']);

        $datainicio = formatDate($_datainicio);
        $datafim = formatDate($_datafim);

        $query = "SELECT falt.idFalta, func.nome, falt.dia, m.motivo, falt.atrasoMinutos, falt.quantidadeAulas, falt.quantidadeHaes, falt.justificativa, falt.visto FROM faltas AS falt INNER JOIN funcionario AS func INNER JOIN motivo AS m ON falt.idFunc = func.idfunc AND falt.idMotivo = m.idMotivo WHERE dia BETWEEN '$datainicio' AND '$datafim'";

        $result = mysqli_query($db, $query);
    ?>

<body>
    <table>
        <thead>
            <tr>
                <th colspan="9" class="img-table"><div><img class="left" src="assets/Logo1.png"><img class="right" src="assets/EtecLogo.jpg"></div></th>
            </tr>
            <tr>
                <th colspan="9">Relatorio de faltas [ <?php if(!empty($_POST['mes'])){ echo $_POST['mes']; } else { echo "Indefinido"; }?> ]</th>
            </tr>
        </thead>
        <tr>
            <th>ID Falta</th>
            <th>Funcionário</th>
            <th>Dia</th>
            <th>Motivo</th>
            <th>Atraso em minutos</th>
            <th>Quantidade de aulas</th>
            <th>Quantidade de HAES</th>
            <th>Justificativa</th>
            <th>Visto</th>
        </tr>
            <?php
                // print_r(mysqli_fetch_array($result));
                while($row = mysqli_fetch_array($result)){
                    echo "<tr>";
                    for($i = 0; $i <= 8; $i++){
                        if($i == 8 && $row[$i] == 1) $row[$i] = 'Não Efetivado';
                        if($i == 8 && $row[$i] == 0) $row[$i] = 'Sem Justificativa';
                        if($i == 8 && $row[$i] == 2) $row[$i] = 'Efetivado';
                        if($i == 2) $row[$i] = formatDateRelatorio($row[$i]);
                        echo "<td>$row[$i]</td>";
                    }
                    echo "</tr>";
                }
            ?>

    </table>
    <button><a href="javascript:window.print()">Imprimir<img src="./assets/impressora.png"></a></button>
    <button><img src="./assets/back2.png"><a href="gerar_relatorio.php">Voltar ao sistema</a></button>
</body>

</html>