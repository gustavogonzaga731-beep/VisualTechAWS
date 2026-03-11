<?php
session_start(); // Inicia a sessão se ainda não estiver ativa

// Remove todas as variáveis de sessão
session_unset(); 

// Destroi a sessão
session_destroy(); 

// Limpa os cookies de sessão (se usados)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 0, 
        $params["path"], $params["domain"], 
        $params["secure"], $params["httponly"]
    );
}

// Redireciona para a página de login ou qualquer outra página
header("Location: /visual_tech/app/produtos.php");
exit();
?>
