<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatorio</title>
    <style>
        table, th, td {
            border: 1px solid black;
        }
        button {
            margin-top: 20px;
        }
        a, img {
            margin: 3px;
            height: 30px;
            vertical-align: middle;
        }

    </style>
</head>
<?php
        session_start();

        require_once("php/CMS.php");
        $cms = new CMS();
        $db = $cms->conectar();
        
<<<<<<< HEAD
        if(!isset($_POST['mes'])){
            echo "Não consegui gerar o relatório.";
=======
        if(empty($_POST['mes'])){
            echo "Não consegui gerar o relatorio.";
>>>>>>> 1c25d49247ac6653f7383538e7a991688ee06c51
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

        $mes = substr($_POST['mes'], 5);
        $ano = substr($_POST['mes'], 0, 4);

        $query = "select falt.idFalta, func.nome, falt.dia, m.motivo, falt.atrasoMinutos, falt.quantidadeAulas, falt.quantidadeHaes, falt.justificativa, falt.visto from faltas as falt inner join funcionario as func inner join motivo as m on falt.idFunc = func.idfunc and falt.idMotivo = m.idMotivo where MONTH(dia) = $mes and YEAR(dia) = $ano;";

        $result = mysqli_query($db, $query);
    ?>

<body>
    <table>
        <thead>
            <tr>
<<<<<<< HEAD
                <th colspan="9">Relatório de faltas - <?php echo "$meses[$mes] de $ano"?></th>
=======
                <th colspan="9">Relatorio de faltas - <?php if(empty($_POST['mes'])){ echo "$meses[$mes] de $ano"; } else { echo "Indefinido"; }?></th>
>>>>>>> 1c25d49247ac6653f7383538e7a991688ee06c51
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
                while($row = mysqli_fetch_array($result)){
                    echo "<tr>";
                    for($i = 0; $i <= 8; $i++){
                        echo "<td>$row[$i]</td>";
                    }
                    echo "</tr>";
                }
            ?>

    </table>
    <button><a href="javascript:window.print()">Imprimir<img src="./assets/impressora.png"></a></button>
</body>

</html>