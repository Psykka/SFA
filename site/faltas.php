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

        $queryFunc = "SELECT * FROM funcionario";
        $queryMotivo = "SELECT * FROM motivo";

        $resultFunc = mysqli_query($db, $queryFunc);
        $resultMotivo = mysqli_query($db, $queryMotivo);

        $rowsFunc = Array();
        $rowsMotivo = Array();

        while($i = mysqli_fetch_assoc($resultFunc)){
            $rowsFunc[] = $i;
        }
        
        while($i = mysqli_fetch_assoc($resultMotivo)){
            $rowsMotivo[] = $i;
        }
        
        if(isset($_GET['logout']) == true){
            session_destroy();
            header("Location: index.php");
            die();
        }

        if(isset($_GET['funcId']) == true){
            $funcId = $_GET['funcId'];
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
                <input type="number" name="idFunc" id="idFunc" disabled>
                <input type="date" name="dia" id="dia" value="<?php echo gmdate("Y-m-j")?>" required>
                <input type="text" name="nome" placeholder="Nome" autocomplete="off" id="nomeFunc" disabled>
                <select name="motivo" form="form" id="motivo" required>
                    <option value="" selected>Motivo</option>
                    <?php
                        foreach ($rowsMotivo as $value) {
                            $id = $value['idMotivo'];
                            $nome = $value['motivo'];

                            echo "<option value='$id'>$nome</option>";
                        }
                    ?>
                </select>
                <input type="submit" value="Marcar falta">
            </form>
        </div>
    </div>
    <script type="text/javascript">
        const funcionarios = JSON.parse('<?php echo json_encode($rowsFunc); ?>');
    </script>
    <script type="text/javascript">
        function setValues(id, funcionarios){
            funcionario = funcionarios.filter(x => x.idFunc == id);
            if(!id || !funcionario) return;
            $(document).ready(() =>{
                $("#idFunc").val(id);
                $("#nomeFunc").val(funcionario[0].nome);
            });
        }
        setValues(<?php echo $funcId?>, funcionarios);
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
            cancelButtonColor: '#d9534f',
            confirmButtonText: 'SIM',
            confirmButtonColor: '#5cb85c',
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            onOpen: () => {
                if(!document.getElementById('nomeFunc').value)
                    return Swal.fire('Calma la!', 'Você precisa me dizer qual funcionario.', 'info');
            },
            preConfirm: () => {
                return $.ajax({
                    type: "POST",
                    url: 'php/MarcarFalta.php',
                    data: {
                        idFunc: document.getElementById('idFunc').value,
                        motivo: document.getElementById('motivo').value,
                        dia: document.getElementById('dia').value,
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
                    timer: 1500
                })
            } else {
                if (result.value == 0 || result.dismiss === Swal.DismissReason.cancel) 
                    return Swal.fire('Cancelado!', 'As alteções não foram realizadas.', 'error');
                Swal.fire('Erro!', result.value, 'error');
            }
        });
    }
    </script>
    <script src="./js/rowFaltasSearch.js"></script>
</body>

</html>