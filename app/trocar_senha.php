<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Visual_Tech/app/conn.php'; // Conexão com o banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    $userId = $_SESSION['id_user'] ?? null;

    if (!$userId) {
        echo "Usuário não autenticado.";
        exit;
    }

    if ($newPassword === $confirmPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); // Criptografa a senha
        $query = "UPDATE clients SET pass = ? WHERE id_user = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('si', $hashedPassword, $userId);

        if ($stmt->execute()) {
            echo "Senha alterada com sucesso!";
            header('Location: login.php'); // Redireciona para a página de login
            session_start(); // Inicia a sessão se ainda não estiver ativa
            // Remove todas as variáveis de sessão
            session_unset(); 

            // Destroi a sessão
            session_destroy(); 

            exit;
        } else {
            $error = "Erro ao alterar a senha. Tente novamente mais tarde.";
        }
    } else {
        $error = "A confirmação da nova senha não coincide.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trocar Senha</title>
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

        h2 {
            text-align: center;
            margin-bottom: 20px;
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
        <h2>Trocar Senha</h2>
        <label for="newPassword">Nova Senha:</label>
        <input type="password" id="newPassword" name="newPassword" placeholder="Digite sua nova senha" required autocomplete="off">
        
        <label for="confirmPassword">Confirmar Nova Senha:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirme sua nova senha" required autocomplete="off">
        
        <button type="submit">Alterar Senha</button>
    </form>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
</body>
</html>