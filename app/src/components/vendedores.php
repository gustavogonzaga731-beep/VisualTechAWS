<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/vendedores.css">
    <title>Vendedores</title>
    <link rel="stylesheet" href="../css/header.css" type="text/css">
    <link rel="stylesheet" href="../css/footer.css" type="text/css">
    <link rel="stylesheet" href="../css/vendedores.css" type="text/css">
</head>
<body>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/config.php'; ?>

    <div class="grid-container">
    <a  class="grid-item" href="javascript:void(0)" onclick="window.history.back()" class="back_page">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M224,128a8,8,0,0,1-8,8H59.31l58.35,58.34a8,8,0,0,1-11.32,11.32l-72-72a8,8,0,0,1,0-11.32l72-72a8,8,0,0,1,11.32,11.32L59.31,120H216A8,8,0,0,1,224,128Z"></path></svg>
            </a>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/conn.php';

// Consulta para buscar todos os vendedores
$sql = "SELECT * FROM sellers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr>
            <th>ID</th>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Gênero</th>
            <th>Email</th>
            <th>Cargo</th>
            <th>Status</th>
            <th>Data de Registro</th>
          </tr>";

    // Exibe os resultados em uma tabela
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id_seller'] . "</td>";
        echo "<td><img src='" . $row['img_seller'] . "' alt='Imagem do Vendedor' width='100'></td>";
        echo "<td>" . $row['name_seller'] . "</td>";
        echo "<td>" . $row['gender'] . "</td>";
        echo "<td>" . $row['email_seller'] . "</td>";
        echo "<td>" . $row['cargo_seller'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td>" . $row['date_registration'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Nenhum vendedor encontrado.";
}

$conn->close();
?>

    </div>

</body>
</html>
