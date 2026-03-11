<?php
// Inclui a conexão com o banco de dados
include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/conn.php';

session_start();

// Função para redirecionar o usuário com base no cargo
function redirecionarUsuario($cargo, $name_seller) {
    switch ($cargo) {
        case 'master':
            header("Location: master.php?seller=" . $name_seller);
            break;
        case 'vendedor':
            header("Location: seller.php?seller=" . $name_seller);
            break;
        case 'client':
            header("Location: validando.php");
            break;
        default:
            echo "<script>alert('Cargo não reconhecido.');</script>";
            break;
    }
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $email = $_POST['email'];
    $password = $_POST['pass'];

    // Consulta para verificar se é um vendedor
    $query = "SELECT * FROM sellers WHERE email_seller = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        if ($password === $user['pass_seller']) {
            $_SESSION['email'] = $email;
            $_SESSION['seller'] = $user['id_seller'];
            $_SESSION['name'] = $user['name_seller'];
            redirecionarUsuario($user['cargo_seller'], $user['name_seller']);
            exit();
        }
    } else {
        // Verifica se é um cliente
        $query = "SELECT * FROM clients WHERE user_email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $client = mysqli_fetch_assoc($result);
            if (password_verify($password, $client['pass'])) {
                $_SESSION['email'] = $email;
                $_SESSION['id_user'] = $client['id_user'];
                redirecionarUsuario('client', $client['id_user']);
                exit();
            }
        }
    }
    echo "<script>alert('Usuário ou senha inválidos.');</script>";
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../app/src/css/login.css">
    <style>
        .accessibility-mode {
            background-color: #000;
            color: #fff;
        }
        .accessibility-mode header,
        .accessibility-mode .login-container {
            background-color: #000;
            color: #fff;
            border: 1px solid white;
        }
        .accessibility-mode a {
            color: #0d6efd;
        }
        #accessibilityButton {
            background-color: #454545;
        }
        #accessibilityButton:hover {
            background-color: #0d6e0d;
            color: #fff;
        }
        form button {
            background-color: #0d6efd;
        }
        form button:hover {
            background-color: #454545;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="user-info" id="userInfo">Usuário: Não autenticado</div>
    <div class="login-container">
        <button id="accessibilityButton" class="btn btn-secondary mt-2">Alternar Modo de Acessibilidade</button>
        <a href="./produtos.php" class="back_page">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#0d6efd" viewBox="0 0 256 256">
                <path d="M224,128a8,8,0,0,1-8,8H59.31l58.35,58.34a8,8,0,0,1-11.32,11.32l-72-72a8,8,0,0,1,0-11.32l72-72a8,8,0,0,1,11.32,11.32L59.31,120H216A8,8,0,0,1,224,128Z"></path>
            </svg>
        </a>
        <h2>Login</h2>
        <span id="loginError" style="color: brown;"></span>
        <form id="loginForm" action="" method="POST">
            <label for="email">E-mail</label>
            <input type="text" id="email" name="email" required autofocus autocomplete="off">
            <label for="pass">Senha</label>
            <input type="password" id="pass" name="pass" required>
            <input type="submit" value="Entrar">
            Não tem uma conta? <a href="cadastro.php">Cadastre-se</a> <br>
            Esqueceu a senha? <a href="recuperar.php">Trocar</a>
        </form>
    </div>
    <script>
        document.getElementById('accessibilityButton').addEventListener('click', function() {
            document.body.classList.toggle('accessibility-mode');
        });
    </script>
</body>
</html>