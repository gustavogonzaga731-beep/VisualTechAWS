<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Visual_Tech/app/conn.php'; // Conexão com o banco

// Busca os logs
$sql = "SELECT * FROM log ORDER BY timestamp DESC";
$result = $conn->query($sql);

// Transforma os resultados em JSON para o front-end
$logs = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
}

// Envia os dados como JSON
header('Content-Type: application/json');
echo json_encode($logs);

$conn->close();
?>
