<?php 
    $serverName = "localhost";
    $userName = "root";
    $pass = "";
    $db = "visual_tech";

    // Tentativa de conexão usando mysqli
    $conn = new mysqli($serverName, $userName, $pass, $db);

    // Verificação de erro de conexão
    if (!$conn) {
        echo '';
    } else {
        echo '';
    }

?>

