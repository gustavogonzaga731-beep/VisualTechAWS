<?php
 
// Credenciais via variáveis de ambiente (defina no servidor/.env)
$serverName = getenv('DB_HOST') ?: 'localhost';
$userName   = getenv('DB_USER') ?: 'root';
$pass       = getenv('DB_PASS') ?: '';
$db         = getenv('DB_NAME') ?: 'visual_tech';
 
$conn = new mysqli($serverName, $userName, $pass, $db);
 
// Verificação correta de erro de conexão
if ($conn->connect_error) {
    // Em produção, nunca exiba o erro real para o usuário
    error_log("Erro de conexão: " . $conn->connect_error);
    die("Erro ao conectar com o banco de dados. Tente novamente mais tarde.");
}
 
$conn->set_charset("utf8mb4");