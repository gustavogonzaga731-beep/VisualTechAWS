<head>
    <title>Atualizar cadastro</title>
    <link rel="stylesheet" href="src/css/forms.css">
</head>
<form method="POST">
<a href="javascript:void(0)" onclick="window.history.back()" class="back_page">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#0d6efd" viewBox="0 0 256 256">
                <path d="M224,128a8,8,0,0,1-8,8H59.31l58.35,58.34a8,8,0,0,1-11.32,11.32l-72-72a8,8,0,0,1,0-11.32l72-72a8,8,0,0,1,11.32,11.32L59.31,120H216A8,8,0,0,1,224,128Z"></path>
            </svg>
        </a>
        <?php
// atualizar_quantidade.php
require_once './conn.php';

if (isset($_POST['atualizar'])) {
    $id_product = $_POST['id_product'];
    $nova_quantidade = $_POST['quantidade'];

    $sql = "UPDATE products SET quantity_stock='$nova_quantidade' WHERE id_product='$id_product'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Quantidade atualizada com sucesso.";
    } else {
        echo "Erro ao atualizar a quantidade: " . $conn->error;
    }
}
?> <br><br>

    ID do Produto: <input type="text" name="id_product" required autocomplete="off"><br>
    Nova Quantidade: <input type="number" name="quantidade" required autocomplete="off"><br>
    <input type="submit" name="atualizar" value="Atualizar Quantidade">
    <script type="module" src="src/js/main.js"></script>
</form>
