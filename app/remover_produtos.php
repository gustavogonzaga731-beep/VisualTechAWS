<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/conn.php';

// Verificar se o vendedor está autenticado
if (!isset($_SESSION['seller'])) {
    header("Location: login.php");
    session_unset();
    session_destroy();
    exit();
}

// Obter o ID do vendedor logado
$sqlSellersSessions = "SELECT id_seller FROM sellers WHERE id_seller = ?";
$stmt = $conn->prepare($sqlSellersSessions);
$stmt->bind_param("i", $_SESSION['seller']);
$stmt->execute();
$result = $stmt->get_result();
$seller = $result->fetch_assoc()['id_seller'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remover'])) {
    $id_product = intval($_POST['id_product']);

    // Verificar se o produto pertence ao vendedor
    $sqlCheckProduct = "SELECT * FROM products WHERE id_product = ? AND id_seller = ?";
    $stmt = $conn->prepare($sqlCheckProduct);
    $stmt->bind_param("ii", $id_product, $seller);
    $stmt->execute();
    $productResult = $stmt->get_result();

    if ($productResult->num_rows > 0) {
        // Remover o produto
        $sqlRemoveProduct = "DELETE FROM products WHERE id_product = ?";
        $stmt = $conn->prepare($sqlRemoveProduct);
        $stmt->bind_param("i", $id_product);
        if ($stmt->execute()) {
            // Registrar a ação no log
            registrar_log($conn, $seller, 'Remoção', "Removeu o produto ID: $id_product");
            echo "<script>alert('Produto removido com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao remover o produto.');</script>";
        }
    } else {
        echo "<script>alert('Produto não encontrado ou você não tem permissão para removê-lo.');</script>";
    }
}

/*
 * Função para registrar ação no log
 */
function registrar_log($conn, $id_seller, $action, $description) {
    // Obter o tipo de vendedor
    $sqlSellers = "SELECT cargo_seller FROM sellers WHERE id_seller = ?";
    $stmt = $conn->prepare($sqlSellers);
    $stmt->bind_param("i", $id_seller);
    $stmt->execute();
    $result = $stmt->get_result();
    $typeUser = $result->fetch_assoc()['cargo_seller'];

    // Registrar no log
    $sqlLOG = "INSERT INTO log (user_type, user_id, action, description) 
               VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sqlLOG);
    $stmt->bind_param("siss", $typeUser, $id_seller, $action, $description);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Deletar Produto</title>
    <link rel="stylesheet" href="src/css/forms.css" type="text/css">
</head>
<body>
    <form method="POST">
        <?php 
            include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/src/components/buttonBack.php';
        ?>
        <p id="message"></p>
        ID do Produto: <input type="text" id="id_product" name="id_product" required autocomplete="off"><br>
        <input type="submit" name="remover" value="Remover Produto">
        <script type="module" src="src/js/main.js"></script>
    </form>
</body>
</html>