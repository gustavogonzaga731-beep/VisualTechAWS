<?php
// estoque.php
require_once './conn.php';

$sql = "SELECT * FROM produtos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Nome</th><th>Preço</th><th>Quantidade</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['id_produto']}</td><td>{$row['nome_produto']}</td><td>{$row['preco']}</td><td>{$row['quantidade']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum produto encontrado no estoque.";
}
?>
