<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="assets/Logo2.png" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <title>SFA | Horario</title>
</head>

<body onload="rowSearch(funcionarios, 'nome', 'search');">
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
        <div>
            <div class="cadastro">
                <h1>Controle de Faltas</h1>
            </div>
            <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Nome</span>
                </div>
                <input type="text" class="form-control" autocomplete="off" id="nome" onkeyup="rowSearch(funcionarios, 'nome', 'search');">
            </div>
            <div id="search" width="500" height="20"></div>
            <form action="" method="post" id="form" class="cadastro">
                <input type="date" name="dia" id="" value="<?php echo gmdate("Y-m-j")?>" required>
                <input type="text" name="idFunc" placeholder="Nome" autocomplete="off" id="idFunc" required>
                <select name="motivo" form="form" id="motivo">
                    <option value="" selected>Motivo</option>
                    <!-- Pegar no banco de dados os motivos... -->
                </select>
                <input type="submit" value="Marcar falta">
            </form>
        </div>
    </div>
    <script type="text/javascript">
    const funcionarios = JSON.parse('<?php echo json_encode($rows); ?>');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript">
    $('#form').submit(() => {
        insert();
        return false;
    });

    async function insert() {
        await Swal.fire({
            title: 'Deseja marcar a falta?',
            type: 'question',
            showCancelButton: true,
            focusConfirm: true,
            cancelButtonText: 'CANCELAR',
            cancelButtonColor: '#d33',
            confirmButtonText: 'SIM',
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            preConfirm: () => {
                return $.ajax({
                    type: "POST",
                    url: 'php/MarcarFalta.php',
                    data: {
                        nome: document.getElementById('idFunc').value,
                        motivo: document.getElementById('motivo').value
                    },
                    dataType: 'html'
                })
            },
        }).then(result => {
            if (result.value >= 1) {
                Swal.fire({
                    type: 'success',
                    title: 'Funcionário cadastrado com sucesso!',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else {
                if (result.value == 0 || result.dismiss === Swal.DismissReason.cancel) return Swal.fire(
                    'Cancelado!', 'As alteções não foram realizadas.', 'error');
                Swal.fire('Erro!', result.value, 'error');
            }
        });
    }
    </script>
    <script src="./js/rowSearch.js"></script>
</body>

</html>