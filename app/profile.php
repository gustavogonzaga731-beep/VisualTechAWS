<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/conn.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

// Gerar o token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Obter informações do usuário logado
$id_user = $_SESSION['id_user'];
$sql = "SELECT * FROM clients WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Processar formulário de atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validação do token CSRF
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Token CSRF inválido!");
    }

    // Obter dados do formulário
    $new_street = $_POST['street'] ?? $user['street'];
    $new_user_cell = $_POST['user_cell'] ?? $user['user_cell'];
    $new_pass = !empty($_POST['pass']) ? password_hash($_POST['pass'], PASSWORD_DEFAULT) : $user['pass'];
    $new_cep = $_POST['cep'] ?? $user['cep'];
    $new_num = $_POST['num'] ?? $user['num'];
    $new_complement = $_POST['complement'] ?? $user['complement'];

    // Atualizar dados no banco de dados
    $update_sql = "UPDATE clients SET street = ?, user_cell = ?, pass = ?, cep = ?, num = ?, complement = ? WHERE id_user = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssssi", $new_street, $new_user_cell, $new_pass, $new_cep, $new_num, $new_complement, $id_user);

    if ($update_stmt->execute()) {
        $_SESSION['message'] = "Informações atualizadas com sucesso!";
    } else {
        $_SESSION['message'] = "Erro ao atualizar informações.";
    }

    // Redirecionar para atualizar a página
    header("Location: profile.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Meu Perfil</h1>

        <!-- Mensagem de feedback -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info">
                <?= htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="name">Nome Completo</label>
                <input type="text" class="form-control" id="name" value="<?= htmlspecialchars($user['name_complete']); ?>" disabled>
            </div>

            <div class="form-group">
                <label for="user_email">E-mail</label>
                <input type="email" class="form-control" id="user_email" value="<?= htmlspecialchars($user['user_email']); ?>" disabled>
            </div>

            <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" class="form-control" name="cep" id="cep" placeholder="_____-___" maxlength="9" autocomplete="off" required value="<?= htmlspecialchars($user['cep']); ?>" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="street">Rua</label>
                <input type="text" class="form-control" name="street" id="street" placeholder="Digite seu endereço" maxlength="40" autocomplete="off" required readonly value="<?= htmlspecialchars($user['street']); ?>" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="num">Número</label>
                <input type="text" class="form-control" name="num" id="num" placeholder="Digite seu número" maxlength="10" autocomplete="off" required value="<?= htmlspecialchars($user['num']); ?>" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="complement">Complemento</label>
                <input type="text" class="form-control" name="complement" id="complement" placeholder="Próximo ao ..." maxlength="50" autocomplete="off" value="<?= htmlspecialchars($user['complement']); ?>" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="user_cell">Celular</label>
                <input type="tel" class="form-control" id="user_cell" name="user_cell" value="<?= htmlspecialchars($user['user_cell']); ?>" maxlength="15" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="pass">Nova Senha</label>
                <input type="password" class="form-control" id="pass" name="pass" placeholder="Deixe em branco para não alterar">
            </div>

            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

            <button type="submit" class="btn btn-primary">Atualizar Informações</button>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </form>
    </div>

    <script type="module" src="./src/js/main.js"></script>

    <script>
        // Função para buscar o endereço com o CEP
        document.getElementById('cep').addEventListener('input', function() {
            const cep = this.value.replace(/\D/g, ''); // Remove qualquer não-dígito

            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.erro) {
                            document.getElementById('street').value = '';
                            alert('CEP não encontrado!');
                        } else {
                            document.getElementById('street').value = data.logradouro;
                        }
                    })
                    .catch(() => alert('Erro ao buscar o endereço'));
            }
        });
    </script>
</body>
</html>