<?php
// deletar_produtos.php
require_once './conn.php';

if (isset($_POST['deletar'])) {
    // Verifique se 'id_product' está definido
    if (isset($_POST['id_product'])) {
        $id_product = $_POST['id_product'];

        // Use uma consulta preparada para evitar SQL Injection
        $sql = "DELETE FROM products WHERE id_product = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            // Vincula o parâmetro
            $stmt->bind_param("i", $id_product); // "i" indica que é um inteiro
            
            // Executa a consulta
            if ($stmt->execute()) {
                $message =  "Produto deletado com sucesso.";
            } else {
                $message =  "Erro ao deletar o produto: ";
            }
            $stmt->close();
        } else {
            echo "Erro ao preparar a consulta: " . $conn->error;
        }
    } else {
        echo "ID do produto não foi informado.";
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
    <p><?php $message ?></p>

                    <option value="M">Masculino</option>
    ID do Produto: <input type="text" name="id_product" required autocomplete="off"><br>
    <input type="submit" name="deletar" value="Deletar Produto">
    <script type="module" src="src/js/main.js"></script>
</form>
