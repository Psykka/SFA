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
            $('#editRG').mask('00.000.000-0')
        })
    </script>
    <title>SFA | Funcionarios</title>
</head>
<body>
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
    
    <header>
        <a href="menu.php"><img src="./assets/back.png"></a>
        <label>Voltar</label>
        <a href="menu.php?logout=true"><img src="./assets/logout.png" class="logout"></a>
    </header>

    <div class="container">
        <label>Nome:</label><input type="text" id="nome" onkeyup="rowSearch(funcionarios, 'nome', 'search');">

        <div id="search" width="500"></div>
    </div>
    
    <script type="text/javascript">
        const funcionarios = JSON.parse('<?php echo json_encode($rows); ?>');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript">
        async function editFunc(id) {
            let func = funcionarios.map( f =>{ return {nome: f.nome, id: f.idFunc, rg: f.rg} })
                .filter( n =>{ return n.id == id })

            
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
                cancelButtonColor: '#d33',
                confirmButtonText: 'SALVAR',
                confirmButtonColor: '#FF8300',
                showLoaderOnConfirm: true,
                preConfirm: () =>{
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
                allowOutsideClick: () => !Swal.isLoading()
            }).then(result => {
                if(result >=1){
                    Swal.fire('Sucesso!', 'As alteções foram realizadas.', 'success').then(result =>{
                        window.location.href = ('funcionarios.php')
                    })
                }else{
                    if(result.dismiss === Swal.DismissReason.cancel) return Swal.fire('Cancelado!', 'As alteções não foram realizadas.', 'error')
                    Swal.fire('Erro!', result.value, 'error');
                }
            });
        }
    </script>
    <?php       
        if(isset($_GET['funcId'])){
            echo "<script type='text/javascript'> editFunc(". $_GET['funcId'] .");</script>\n";
        }
    ?>
    <script src="./js/rowSearch.js"></script>
</body>
</html>