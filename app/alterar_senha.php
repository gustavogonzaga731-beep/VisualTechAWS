
<head>
    <title>Alterar Senha</title>
    <link rel="stylesheet" href="src/css/forms.css">
</head>

<form method="POST">
<a href="javascript:void(0)" onclick="window.history.back()" class="back_page">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#0d6efd" viewBox="0 0 256 256">
                <path d="M224,128a8,8,0,0,1-8,8H59.31l58.35,58.34a8,8,0,0,1-11.32,11.32l-72-72a8,8,0,0,1,0-11.32l72-72a8,8,0,0,1,11.32,11.32L59.31,120H216A8,8,0,0,1,224,128Z"></path>
            </svg>
        </a>
<?php
// alterar_senha.php
require_once './conn.php';

if (isset($_POST['alterar'])) {
    // Verifica se os campos 'id_seller' e 'pass_seller' estão definidos no array $_POST
    if (isset($_POST['id_seller']) && isset($_POST['pass_seller'])) {
        $id_seller = $_POST['id_seller'];
        $pass_seller = password_hash($_POST['pass_seller'], PASSWORD_DEFAULT);

        // Use consulta preparada para evitar SQL injection
        $sql = "UPDATE sellers SET pass_seller=? WHERE id_seller=?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Vincula os parâmetros e executa a consulta
            $stmt->bind_param("si", $pass_seller, $id_seller);

            if ($stmt->execute()) {
                echo "Senha alterada com sucesso.";
            } else {
                echo "Erro ao alterar a senha: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Erro ao preparar a consulta: " . $conn->error;
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}
?>
    <p id="message"></p>

    ID do Usuário: <input type="text" name="id_seller" required><br>
    Nova Senha: <input type="password" name="pass_seller" required><br>
    <input type="submit" name="alterar" value="Alterar Senha">
    <script type="module" src="src/js/main.js"></script>
</form>
