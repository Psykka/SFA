<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="assets/Logo2.png" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>SFA | Login</title>
</head>

<body>
    <?php
    require_once("php/CMS.php");
    $cms = new CMS();
    $db = $cms->conectar();

    // if($_SERVER["REQUEST_METHOD"] == "POST"){
    //     $username = mysqli_real_escape_string($db, $_POST["user"]);
    //     $userpass = md5(mysqli_real_escape_string($db, $_POST["pass"]));

    //     $query = "SELECT idUser FROM usuario WHERE username = '$username' and passwd = '$userpass'";

    //     $result = mysqli_query($db, $query);

    //     if($result){
    //         $row = mysqli_fetch_array($result);
    //         $active = $row['active'];
    //     }

    //     $count = mysqli_num_rows($result);

    //     if($count == 1) {
    //         $_SESSION['login_user'] = $username;
    //         header("location: menu.php");
    //     }else {
    //         $loginerror = "O nome de usuário ou senha estão incorretos";
    //     }
    // }
    ?>
    <div class="login">
        <h1>Login</h1>
        <img src="assets/Logo1.png">
        <form action="" method="post" id="form">
            <input type="text" name="user" id="user" placeholder="User" autocomplete="off">
            <input type="password" name="pass" id="pass" placeholder=Password autocomplete="off">
            <button type="submit" onclick="login()">Login</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript">
        $('form').submit((e) =>{
            e.preventDefault();
        })
        async function login() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                },
            })
            result = await $.ajax({
                type: "POST",
                url: 'php/Login.php',
                data: {
                    user: document.getElementById('user').value,
                    pass: document.getElementById('pass').value
                },
                dataType: 'html'
            })
            if (result != 1) {
                Toast.fire({
                    icon: 'success',
                    title: 'Logado com sucesso',
                    onClose: () => {
                        window.location.href = 'validate_sesson.php'
                    }
                })
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Nome de usuário ou senha incorretos'
                })
            }
        }
    </script>
    <style>
        button {
            background: none;
            display: block;
            margin: 20px auto;
            text-align: center;
            border: 3px solid #3F30A8;
            padding: 14px;
            width: 100px;
            outline: none;
            color: #241592;
            border-radius: 20px;
            transition: 0.25s;
            cursor: pointer;
        }

        button:hover {
            background-color: #3F30A8;
            color: #FFF;
        }
    </style>
</body>
</html>