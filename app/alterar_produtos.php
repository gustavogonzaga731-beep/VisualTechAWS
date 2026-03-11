<html>
    <head>
        <title>Alterar Produto</title>
        <link rel="stylesheet" href="src/css/forms.css" type="text/css">
        <link rel="stylesheet" href="src/css/footer.css" type="text/css">
        <link rel="stylesheet" href="src/css/index.css" type="text/css">
        <link rel="stylesheet" href="src/css/header.css" type="text/css">
    </head>
    <form method="POST">

        <?php
        session_start();
        
        include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/src/components/buttonBack.php';

        include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/config.php';
        include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/conn.php';

        $sqlSellersSessions = "SELECT id_seller FROM sellers WHERE id_seller = ?";
        $stmt = $conn->prepare($sqlSellersSessions);
        // ...
        ?>

        <p id="message"></p>

        ID do Produto: <input type="text" name="id_product" required autocomplete="off"><br>
        Novo Nome: <input type="text" name="name_product" autocomplete="off"><br>
        Novo Preço: <input type="text" name="price_product"> autocomplete="off"<br>
        Nova quantidade: <input type="number" name="quantity_stock" autocomplete="off"><br>
        <input type="hidden" id="<?php echo $seller; ?>"><br>
        <input type="submit" name="alterar" value="Alterar Produto" autocomplete="off">
    </form>
    <script type="module" src="src/js/main.js"></script>
</html>