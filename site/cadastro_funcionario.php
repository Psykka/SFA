<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <link rel="shortcut icon" href="assets/Logo2.png" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script type="text/javascript">
        $(document).ready(() =>{
            $('#RG').mask('00.000.000-0')
        })
    </script>
    <title>SFA | Cadastro</title>
</head>
<body>
    <?php
        require_once("php/CMS.php");
        $cms = new CMS();
        $db = $cms->conectar();

        $query = "SELECT * FROM cargo";

        $result = mysqli_query($db, $query);

        $rows = Array();

        while($i = mysqli_fetch_assoc($result)){
            $rows[] = $i;
        }
    
        session_start();

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

    <header>
        <a href="menu.php"><img src="./assets/back.png"></a>
        <label>Voltar</label>
        <a href="menu.php?logout=true"><img src="./assets/logout.png" class="logout"></a>
    </header>
 
    <div class="container">
        <div class="cadastro">
            <h1>Cadastro Funcionários</h1>
            <select name="cargo" form="form" class="custom-select" id="cargo" required>
                <?php
                    foreach ($rows as $value ) {
                        $id = $value['idCargo'];
                        $nome = $value['funcao'];

                        echo "<option value='$id'>$nome</option>";
                    }
                ?>
            </select>
            <form action="" method="post" id="form">
                <input type="text" name="nome" placeholder="Nome" id="nome" required>
		        <input type="text" name="rg" placeholder="RG" id="RG" required>
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
                cancelButtonColor: '#d33',
                confirmButtonText: 'SALVAR',
                confirmButtonColor: '#FF8300',
                showLoaderOnConfirm: true,
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
                allowOutsideClick: () => !Swal.isLoading()
            }).then(result =>{
                if(result.value >= 1){
                    Swal.fire({
                        type: 'success',
                        title: 'Funcionário cadastrado com sucesso!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }else{
                    if(result.dismiss === Swal.DismissReason.cancel) return Swal.fire('Cancelado!', 'As alteções não foram realizadas.', 'error');
                    Swal.fire('Erro!', result.value, 'error');
                }
            });
        }
    </script>
</body>
</html>