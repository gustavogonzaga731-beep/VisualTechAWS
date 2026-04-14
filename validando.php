<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validação</title>
</head>
 
<body>
 
<header>Visual Tech</header>
 
<style> 
body {
    font-family: Arial, sans-serif;
    background-color: #f0f8ff; 
    color: #333; 
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    flex-direction: column; 
}
 
header {
    font-size: 48px; 
    font-weight: bold;
    color: rgba(89, 89, 214, 0.8); 
    text-align: center;
    margin-bottom: 20px; 
}
 
form {
    background-color: #ffffff; 
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    box-sizing: border-box;
}
 
label {
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
    color: #333; 
}
 
select, input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
}
 
select {
    background-color: #f9f9f9; 
}
 
input[type="submit"] {
    background-color: #007bff; 
    color: #fff;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
 
input[type="submit"]:hover {
    background-color: #0056b3;
}
</style>
 
<?php
    session_start();
 
    // Garante que o usuário veio de um fluxo autenticado (tem e-mail na sessão)
    if (empty($_SESSION['user_email'])) {
        header('Location: login.php');
        exit();
    }
 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/conn.php';
 
    // Busca APENAS o nome da mãe do cliente logado, não de todos
    $sql  = "SELECT maternal_name FROM clients WHERE user_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['user_email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $maternal_name_db = $row['maternal_name'] ?? null;
?>
 
    <form action="" method="post">
        <label for="maternal_name">Digite o nome da sua mãe:</label>
        <!-- CORRIGIDO: campo de texto livre em vez de select com todos os nomes do banco -->
        <input type="text" id="maternal_name" name="maternal_name" required
               placeholder="Nome completo da mãe"
               style="width:100%;padding:10px;margin-bottom:15px;border:1px solid #ccc;border-radius:4px;font-size:14px;box-sizing:border-box;">
        <input type="submit" value="Confirmar">
    </form>
 
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // CORRIGIDO: compara com o valor do banco, não busca pelo valor enviado
        $maternalNameInput = trim($_POST['maternal_name'] ?? '');
 
        if (!empty($maternal_name_db) && strtolower($maternalNameInput) === strtolower($maternal_name_db)) {
            $_SESSION['validated'] = true;
            header('Location: user.php');
            exit();
        } else {
            session_destroy();
            header('Location: login.php');
            exit();
        }
    }
    ?>
 
</body>
</html>