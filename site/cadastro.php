<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="assets/Logo2.png" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
        $(document).ready(() => {
            $('#RG').mask('00.000.000-0')
        })
    </script>
    <title>SFA | Cadastro</title>
</head>

<body>
    <?php
    session_start();

    require_once("php/CMS.php");
    $cms = new CMS();
    $db = $cms->conectar();

    $query = "SELECT * FROM cargo";

    $result = mysqli_query($db, $query);

    $rows = array();

    while ($i = mysqli_fetch_assoc($result)) {
        $rows[] = $i;
    }

    if (!isset($_SESSION['login_user'])) {
        header("location:sessao.php");
        die();
    }

    if (isset($_GET['logout']) == true) {
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

    <div class="container cadastro">
        <h1>Cadastro</h1>
        <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu1">Cargos</a></li>
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu2">Funcionários</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu3">Motivos</a></li>
        </ul>

        <div class="tab-content">
            <div id="menu1" class="tab-pane fade">
                <form method="post" id="form1">
                    <input type="text" id="cargoCadastro" placeholder="Nome do cargo" required>
                    <input type="submit" value="Cadastrar">
                </form>
            </div>
            <div id="menu2" class="tab-pane active">
                <select name="cargo" form="form2" class="custom-select" id="cargo" required>
                    <option value="" selected>Escolha um cargo...</option>
                    <?php
                    foreach ($rows as $value) {
                        $id = $value['idCargo'];
                        $nome = $value['funcao'];

                        echo "<option value='$id'>$nome</option>";
                    }
                    ?>
                </select>
                <form method="post" id="form2">
                    <input type="text" name="nome" placeholder="Nome" autocomplete="off" id="nome" required>
                    <input type="text" name="rg" placeholder="RG" autocomplete="off" id="RG" required>
                    <input type="submit" value="Cadastrar">
                </form>
            </div>
            <div id="menu3" class="tab-pane fade">
                <form method="post" id="form3">
                    <input type="text" id="motivo" placeholder="Motivo" required>
                    <input type="submit" value="Cadastrar">
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript">
        $('#form1').submit(() => {
            insert('cargo');
            return false;
        });

        $('#form2').submit(() => {
            insert('funcionario');
            return false;
        });

        $('#form3').submit(() => {
            insert('motivo');
            return false;
        });

        async function insert(inset) {
            url = '';
            data = {};
            switch (inset) {
                case 'motivo':
                    url = 'php/CadastroMotivo.php'
                    data = {
                        motivo: document.getElementById('motivo').value
                    }
                    break;
                case 'funcionario':
                    url = 'php/CadastroFunc.php'
                    data = {
                        nome: document.getElementById('nome').value,
                        rg: document.getElementById('RG').value,
                        cargo: document.getElementById('cargo').value
                    }
                    break;
                case 'cargo':
                    url = 'php/CadastroCargo.php'
                    data = {
                        cargo: document.getElementById('cargoCadastro').value
                    }
            }


            await Swal.fire({
                title: 'Deseja cadastrar?',
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
                        url: url,
                        data: data,
                        dataType: 'html'
                    })
                }
            }).then(result => {
                if (result.value >= 1) {
                    Swal.fire({
                        type: 'success',
                        title: 'Cadastrado com sucesso!',
                        showConfirmButton: false,
                        timer: 1500,
                        onClose: () => {
                            window.location.reload();
                        }
                    })
                } else {
                    if (result.value == 0 || result.dismiss === Swal.DismissReason.cancel) return Swal.fire(
                        'Cancelado!', 'As alterações não foram realizadas.', 'error');
                    Swal.fire('Erro!', result.value, 'error');
                }
            });
        }
    </script>
</body>

</html>