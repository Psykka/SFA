<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="assets/Logo2.png" type="image/x-icon">
    <title>SFA | Sessão</title>
</head>
<body>
    <?php
        session_start();

        if(session_destroy()){
        }
    ?>
    <header><div class="title"><h1>Sessão Expirada</h1></div></header>
    <div class="container">
        <div class="sesson">
            <p>Sua sessão expirou!</p>
            <img src="./assets/sesson.png" height="200">
            <a href="index.php"><button>VOLTAR AO LOGIN</button></a>
        </div>
    </div>
</body>
</html>