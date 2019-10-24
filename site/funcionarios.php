<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <link rel="shortcut icon" href="assets/Logo2.png" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
    $(document).ready(() => {
        $('#editRG').mask('00.000.000-0')
    })
    </script>
    <title>SFA | Funcionarios</title>
</head>

<body onload="rowSearch(funcionarios, 'nome', 'search');">
    <?php
        session_start();

        if(!isset($_SESSION['login_user'])){
            header("location:sessao.php");
            die();
        }

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
        <div class="cadastro">
            <h1>Funcionários</h1>
        </div>
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Nome</span>
            </div>
            <input type="text" class="form-control" autocomplete="off" id="nome" onkeyup="rowSearch(funcionarios, 'nome', 'search');">
        </div>
        <div id="search" width="500"></div>
    </div>

    <script type="text/javascript">
    const funcionarios = JSON.parse('<?php echo json_encode($rows); ?>');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript">
    async function editFunc(id) {
        let func = funcionarios.map(f => {
                return {
                    nome: f.nome,
                    id: f.idFunc,
                    rg: f.rg
                }
            })
            .filter(n => {
                return n.id == id
            })


        await Swal.fire({
            title: `<strong>FUNCIONÁRIO (ID: ${func[0].id})</strong>`,
            type: 'info',
            html: `<form action="" method="post">
                            <p>
                                Nome:<input class="swal2-input" value="${func[0].nome}" id="editNome"><br />
                                RG:<input class="swal2-input" value="${func[0].rg}" id="editRG" maxlength="9">
                            </p>
                        </form>`,
            showCancelButton: true,
            focusConfirm: true,
            cancelButtonText: 'CANCELAR',
            cancelButtonColor: '#d9534f',
            confirmButtonText: 'SALVAR',
            confirmButtonColor: '#5cb85c',
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            preConfirm: () => {
                return $.ajax({
                    type: "POST",
                    url: 'php/Update.php',
                    data: {
                        nome: document.getElementById('editNome').value,
                        rg: document.getElementById('editRG').value,
                        id: func[0].id
                    },
                    dataType: 'html'
                })
            },
        }).then(result => {
            if (result.value >= 1) {
                Swal.fire('Sucesso!', 'As alteções foram realizadas.', 'success').then(result => {
                    window.location.href = ('funcionarios.php')
                })
            } else {
                if (result.value == 0 || result.dismiss === Swal.DismissReason.cancel) return Swal.fire(
                    'Cancelado!', 'As alteções não foram realizadas.', 'error')
                Swal.fire('Erro!', result.value, 'error');
            }
        });
    }
    </script>
    <script type="text/javascript">
    async function deleteFunc(id) {
        let func = funcionarios.map(f => {
                return {
                    nome: f.nome,
                    id: f.idFunc,
                    rg: f.rg
                }
            })
            .filter(n => {
                return n.id == id
            })

        await Swal.fire({
            title: `Deseja deletar o funcinario:\n${func[0].nome}`,
            type: 'info',
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
                    url: 'php/Delete.php',
                    data: {
                        id: func[0].id
                    },
                    dataType: 'html'
                })
            },
        }).then(result => {
            if (result.value >= 1) {
                Swal.fire('Sucesso!', 'O funcionário foi deletado com sucesso.', 'success').then(result => {
                    window.location.href = ('funcionarios.php')
                })
            } else {
                if (result.value == 0 || result.dismiss === Swal.DismissReason.cancel) return Swal.fire(
                    'Cancelado!', 'As alteções não foram realizadas.', 'error')
                Swal.fire('Erro!', result.value, 'error');
            }
        });
    }
    </script>
    <?php       
        if(isset($_GET['funcId'])){
            echo "<script type='text/javascript'> editFunc(". $_GET['funcId'] .");</script>\n";
        }

        if(isset($_GET['deleteId'])){
            echo "<script type='text/javascript'> deleteFunc(". $_GET['deleteId'] .");</script>\n";
        }
    ?>
    <script src="./js/rowSearch.js"></script>
</body>

</html>