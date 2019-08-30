<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="assets/Logo2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>SFA | Sessão</title>
</head>
<body>
    <?php
        session_start();

        if(session_destroy()){
        }
    ?>
    <header>
        <div class="d-flex justify-content-center">
            <h1>Sessão Expirada</h1>
        </div>
    </header>
    <div class="container">
        <div class="sesson">
            <p>Sua sessão expirou!</p>
            <img src="./assets/sesson.png" height="200">
            <a href="index.php"><button>VOLTAR AO LOGIN</button></a>
        </div>
    </div>
</body>
</html>