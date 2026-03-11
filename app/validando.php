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

    <form action="" method="post">
        <label for="maternal_name">Selecione o nome da mãe:</label>
        <select id="maternal_name" name="maternal_name" required>
        <option value="">Selecione uma opção</option>
        <option value="Fernanda Montenegro">Fernanda Montenegro</option>
        <option value="Josephina Querino">Josephina Querino</option>
            <?php
                session_start();

                include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/conn.php'; 

                $sql = 'SELECT maternal_name FROM clients';
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['maternal_name'] . '">' . $row['maternal_name'] . '</option>';
                }
            ?>
            <option value="Tatsu Tatchuyu">Alerandra Tatchuyu</option>
        </select>
        <input type="submit" value="Confirmar">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $maternalName = $_POST['maternal_name'];

        // Consulta SQL para verificar se o nome da mãe confirmado corresponde ao nome da mãe armazenado no banco de dados
        $sql = "SELECT maternal_name, user_email, CPF FROM clients WHERE maternal_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $maternalName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Nome da mãe confirmado corresponde ao nome da mãe armazenado no banco de dados
            header('Location: user.php');
            exit();
        } else {
            // Nome da mãe confirmado não corresponde ao nome da mãe armazenado no banco de dados
            header('Location: login.php');
            session_destroy();
            session_unset();
            exit();
        }
    }
    ?>
</body>
</html>