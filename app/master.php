<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id_seller']) && !isset($_SESSION['seller'])) {
    // Redirect the user to the login page
    header("Location: login.php");
    session_destroy();
    exit();
} else {
    // Obtain the id of the logged-in seller
    $seller = $_SESSION['seller'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($_SESSION['name']) ?></title>
    <link rel="stylesheet" href="./src/css/bottons.css">
</head>
<body>
    <div class="container">
        <a href="../app/cadastro_produtos.php?master=<?php echo $seller; ?>">Adicionar produtos</a>
        <a href="../app/alterar_produtos.php?master=<?php echo $seller; ?>">Alterar produtos</a>
        <a href="../app/remover_produtos.php?master=<?php echo $seller; ?>">Remover produtos</a>
        <a href="../app/deletar_produtos.php?master=<?php echo $seller; ?>">Deletar produtos</a>
        <a href="../app/atualizar_quantidade.php?master=<?php echo $seller; ?>">Atualizar quantidade</a>
        <a href="../app/cadastro_vendedor.php?master=<?php echo $seller; ?>">Cadastrar vendedor</a>
        <a href="../app/cadastro.php?master=<?php echo $seller; ?>">Cadastrar usuário</a>
        <a href="../app/consulta.php?master=<?php echo $seller; ?>">Consultar usuário</a>
        <a href="../app/log.php?master=<?php echo $seller; ?>">Logs</a>
        <a href="../app/deletar_usuario.php?master=<?php echo $seller; ?>">Deletar usuário</a>
        <a href="../app/alterar_senha.php?master=<?php echo $seller; ?>">Alterar senha</a>
        <a href="../app/produtos.php?master=<?php echo $seller; ?>">Página de produtos</a>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>