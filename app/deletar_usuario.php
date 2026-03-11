<?php
// deletar_usuario.php
require_once './conn.php';

if (isset($_POST['deletar'])) {
    $id_usuario = $_POST['id_usuario'];

    $sql = "DELETE FROM usuarios WHERE id_usuario='$id_usuario'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Usuário deletado com sucesso.";
    } else {
        echo "Erro ao deletar o usuário: " . $conn->error;
    }
}
?>
<head>
    <title>Deletar Produto</title>
    <link rel="stylesheet" href="src/css/forms.css" type="text/css">
</head>

<form method="POST">
<a href="javascript:void(0)" onclick="window.history.back()" class="back_page">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#0d6efd" viewBox="0 0 256 256">
                <path d="M224,128a8,8,0,0,1-8,8H59.31l58.35,58.34a8,8,0,0,1-11.32,11.32l-72-72a8,8,0,0,1,0-11.32l72-72a8,8,0,0,1,11.32,11.32L59.31,120H216A8,8,0,0,1,224,128Z"></path>
            </svg>
        </a>
    <p id="message"></p>

    ID do Usuário: <input type="text" name="id_usuario" required autocomplete="off"><br>
    <input type="submit" name="deletar" value="Deletar Usuário">
    <script type="module" src="src/js/main.js"></script>
</form>
