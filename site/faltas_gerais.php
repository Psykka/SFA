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
            ?>
            <table class="table">
                <?php
                    if($result->num_rows == 0){
                        echo "Não há nada aqui...";
                        die();
                    }else{
                        echo "<thead><tr><th scope='col'>ID</th><th scope='col'>Funcionario</th><th scope='col'>Dia</th><th scope='col'>Motivo</th><th scope='col'>Atraso  em minutos</th><th scope='col'>Quantidade de Aulas</th><th scope='col'>Quantidade de HAES</th><th scope='col'>Justificatica</th><th scope='col'>Visto</th></tr></thead>";
                    }
                ?>
                <tbody>
                    <?php
                        while($row = mysqli_fetch_array($result)){
                            echo "<tr>";
                            for($i = 0; $i <= 8; $i++){
                                $id = $row[0];
                                if($i == 8 && $row[$i] == 1){
                                    $row[$i] = "<button type='button' class='btn btn-success' onClick='vistar($id)'>Vistar</button>";
                                }else if($i == 8 && $row[$i] == 2){
                                    $row[$i] = "<button type='button' class='btn btn-secondary' disabled>Vistado</button>";
                                }else if($i == 8 && $row[$i] == 0){
                                    $row[$i] = "<button type='button' class='btn btn-secondary btn-sm' disabled>Não Marcada</button>";
                                }
                                echo "<td>$row[$i]</td>";
                            }
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <script type="text/javascript">
            async function vistar(idFalta){
                await Swal.fire({
                    title: 'Deseja vistar?',
                    type: 'question',
                    showCancelButton: true,
                    focusConfirm: true,
                    cancelButtonText: 'CANCELAR',
                    cancelButtonColor: '#d9534f',
                    confirmButtonText: 'SIM',
                    confirmButtonColor: '#5cb85c',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false,
                    preConfirm: () => {
                        return $.ajax({
                            type: "POST",
                            url: 'php/VistarFalta.php',
                            data: {
                                id: idFalta,
                            },
                            dataType: 'html'
                        })
                    },
                }).then(result => {
                    if (result.value >= 1) {
                        Swal.fire({
                            type: 'success',
                            title: 'Falta marcada com sucesso!',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose: () =>{
                                window.location.reload();
                            }
                        })
                    } else {
                        if (result.value == 0 || result.dismiss === Swal.DismissReason.cancel) 
                            return Swal.fire('Cancelado!', 'As alteções não foram realizadas.', 'error');
                        Swal.fire('Erro!', result.value, 'error');
                    }
                });
            }
        </script>
    </div>
</body>
</html>