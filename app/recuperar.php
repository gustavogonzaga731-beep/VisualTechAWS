<?php
session_start(); // Inicia a sessão
require_once $_SERVER['DOCUMENT_ROOT'] . '/Visual_Tech/app/conn.php'; // Conexão com o banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;
    $cpf = $_POST['cpf'] ?? null;
    $motherName = $_POST['motherName'] ?? null;

    if ($email && $cpf && $motherName) {
        // Previne SQL Injection usando prepared statements
        $query = "SELECT id_user FROM clients WHERE user_email = ? AND CPF = ? AND maternal_name = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $email, $cpf, $motherName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc(); // Obtém os dados como array associativo
            $_SESSION['id_user'] = $user['id_user']; // Define o ID do usuário na sessão
            header('Location: trocar_senha.php'); // Redireciona para a página de alteração de senha
            exit;
        } else {
            $error = "CPF, E-mail ou Nome da Mãe inválidos.";
        }
    } else {
        $error = "Por favor, preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input {
            width: 94%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h2 style="text-align: center; margin-bottom: 20px;">Verificar Usuário</h2>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required autocomplete="off">
        
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" required autocomplete="off">
        
        <label for="motherName">Nome da Mãe:</label>
        <input type="text" id="motherName" name="motherName" placeholder="Digite o nome da sua mãe" required autocomplete="off">
        
        <button type="submit">Verificar</button>
    </form>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
</body>
</html>