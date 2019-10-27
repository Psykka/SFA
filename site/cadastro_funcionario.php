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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(() =>{
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

        $rows = Array();

        while($i = mysqli_fetch_assoc($result)){
            $rows[] = $i;
        }

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
            <h1>Cadastro Funcionários</h1>
            <select name="cargo" form="form" class="custom-select" id="cargo" required>
                <option value="" selected>Escolha um cargo...</option>
                <?php
                    foreach ($rows as $value) {
                        $id = $value['idCargo'];
                        $nome = $value['funcao'];

                        echo "<option value='$id'>$nome</option>";
                    }
                ?>
            </select>
            <form action="" method="post" id="form">
                <input type="text" name="nome" placeholder="Nome" autocomplete="off" id="nome" required>
		        <input type="text" name="rg" placeholder="RG" autocomplete="off" id="RG" required>
                <input type="submit" value="Cadastrar">
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript">
        $('#form').submit(() => {
            insert();
            return false;
        });

        async function insert(){
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
                preConfirm: () =>{
                    return $.ajax({
                            type: "POST",
                            url: 'php/Cadastro.php',
                            data: {
                                nome: document.getElementById('nome').value,
                                rg: document.getElementById('RG').value,
                                cargo: document.getElementById('cargo').value
                            },
                            dataType: 'html'
                    })
                },
            }).then(result =>{
                if(result.value >= 1){
                    Swal.fire({
                        type: 'success',
                        title: 'Funcionário cadastrado com sucesso!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }else{
                    if(result.value == 0 || result.dismiss === Swal.DismissReason.cancel) return Swal.fire('Cancelado!', 'As alteções não foram realizadas.', 'error');
                    Swal.fire('Erro!', result.value, 'error');
                }
            });
        }
    </script>
</body>
</html>