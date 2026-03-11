<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="src/css/forms.css" type="text/css">
    <link rel="stylesheet" href="src/css/footer.css" type="text/css">
    <link rel="stylesheet" href="src/css/index.css" type="text/css">
    <link rel="stylesheet" href="src/css/header.css" type="text/css">
    <style>
        /* Esquema de cores acessíveis */
        .high-contrast {
            background-color: #000;
            color: #FFF;
        }
        .high-contrast input, 
        .high-contrast select, 
        .high-contrast button {
            background-color: #444;
            color: #FFF;
        }
        .high-contrast input::placeholder {
            color: #bbb;
        }
        .container-form {
            display: grid;
            justify-content: center;
        }
        #toggleAccessibility {
            background-color: #0d6efd !important;
            border-radius: 5px;
            height: 3rem;
            width: 100%;
            border: 0;
        }
        #toggleAccessibility:hover {
            background-color: #454545 !important;
            color: #fff;
            cursor: pointer;
        }
        .success {
            color: green;
            text-align: center;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container-form">
        <button id="toggleAccessibility" onclick="toggleAccessibility()" style="margin-bottom: 20px;">Alternar Modo de Acessibilidade</button>
        <div id="mensage" style="color: brown; text-align: center; font-size: 1.5rem;"></div>
        <form action="" method="POST">
            <p id="message"></p>
            <a href="javascript:void(0)" onclick="window.history.back()" class="back_page">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#0d6efd" viewBox="0 0 256 256">
                    <path d="M224,128a8,8,0,0,1-8,8H59.31l58.35,58.34a8,8,0,0,1-11.32,11.32l-72-72a8,8,0,0,1,0-11.32l72-72a8,8,0,0,1,11.32,11.32L59.31,120H216A8,8,0,0,1,224,128Z"></path>
                </svg>
            </a>
            <fieldset>
                <legend>Cadastre-se</legend>
                <label for="name_complete">Nome completo</label>
                <p id="nameError" style="color: brown;"></p>
                <input type="text" name="name_complete" id="name_complete" placeholder="Nome completo" maxlength="80" minlength="15" autocomplete="off" required autofocus>
                <label for="date_birth">Data de nascimento</label>
                <input type="date" name="date_birth" id="date_birth" required>
                <label for="gender">Gênero</label>
                <select name="gender" id="gender" required>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                    <option value="OT">Outros</option>
                </select>
                <label for="maternal_name">Nome materno</label>
                <p id="nameMaternalError" style="color: brown;"></p>
                <input type="text" name="maternal_name" id="maternal_name" placeholder="Nome materno" maxlength="30" autocomplete="off" required>
                <p id="nameMaternalError" style="color: brown;"></p>
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" id="cpf" placeholder="___.___.___-__" maxlength="14" autocomplete="off" required>
                <label for="user_email">Email</label>
                <input type="email" name="user_email" id="user_email" maxlength="50" placeholder="Digite seu e-mail" autocomplete="off" required>
                <label for="user_cell">Tel. celular</label>
                <input type="text" name="user_cell" id="user_cell" placeholder="(__) _____-____" maxlength="15" autocomplete="off" required>
                <label for="pass">Senha</label>
                <input type="password" name="pass" id="pass" maxlength="8" placeholder="********" autocomplete="off" required>
                <label for="c_pass">Confirme a senha</label>
                <input type="password" name="c_pass" id="c_pass" maxlength="8" placeholder="********" required>
                <fieldset class="container-buttons">
                    <button type="submit">Cadastrar</button>
                    <button type="reset">Limpar</button>
                </fieldset>
            </fieldset>
        </form>
    </div>
    <script>
        function toggleAccessibility() {
            document.body.classList.toggle('high-contrast');
        }
    </script>
    <?php
    require_once './conn.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name_complete = $_POST['name_complete'] ?? null;
        $gender = $_POST['gender'] ?? null;
        $date_birth = $_POST['date_birth'] ?? null;
        $maternal_name = $_POST['maternal_name'] ?? null;
        $cpf = $_POST['cpf'] ?? null;
        $user_email = $_POST['user_email'] ?? null;
        $user_cell = $_POST['user_cell'] ?? null;
        $pass = $_POST['pass'] ?? null;
        $c_pass = $_POST['c_pass'] ?? null;

        if ($pass === $c_pass) {
            $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO Clients (name_complete, gender, date_birth, maternal_name, cpf, user_email, user_cell, pass) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssssssss", $name_complete, $gender, $date_birth, $maternal_name, $cpf, $user_email, $user_cell, $pass_hash);
                if ($stmt->execute()) {
                    echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href = 'login.php';</script>";
                } else {
                    echo "<div class='error'>Erro ao cadastrar. Tente novamente.</div>";
                }
                $stmt->close();
            }
        } else {
            echo "<div class='error'>As senhas não coincidem.</div>";
        }
        $conn->close();
    }
    ?>
    <script type="module" src="./src/js/main.js"></script>
</body>
</html>