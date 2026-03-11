<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre vendedor</title>
    <link rel="stylesheet" href="src/css/forms.css" type="text/css">
    <link rel="stylesheet" href="src/css/index.css" type="text/css">
    <link rel="stylesheet" href="src/css/footer.css" type="text/css">
    <link rel="stylesheet" href="src/css/header.css" type="text/css">
</head>
<body>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/config.php'; ?>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/conn.php'; ?>

    <?php 
    session_start();

        $stmt = $conn->prepare($sqlSellersSessions);
        $stmt->bind_param("i", $_SESSION['seller']);
        $stmt->execute();
        $result = $stmt->get_result();
        $seller = $result->fetch_assoc()['id_seller'];
        
        if (!$_SESSION['seller']) {
            header("Location: login.php");
            session_unset();
            session_destroy();
            exit();
        }
    ?>

    <div class="container-form">
        <form action="" method="POST" enctype="multipart/form-data">
        <p id="message"></p>

            <?php 
                include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/src/components/buttonBack.php';
            ?>
            <fieldset>
                <legend>Cadastre produto</legend>

                <span>Imagem do produto</span>
                <input type="file" name="img_product" id="img_product" required autocomplete="off">

                <span>Nome do produto</span>
                <input type="text" name="name_product" id="name_product" maxlength="500" required autocomplete="off">

                <span>Descrição do produto</span>
                <input type="text" name="description_product" id="description_product" maxlength="500" required autocomplete="off">

                <span>Quantidade</span>
                <input type="text" name="quantity_stock" id="quantity_stock"  required autocomplete="off">
             
                <span>Preço Unitário (R$)</span>
                <input type="text" name="price_product" id="price_product" required autocomplete="off">

                <span>Vendedor</span>
                <input type="hidden" name="id_seller" value="<?php echo $seller; ?>">

                <fieldset class="container-buttons">
                    <button type="submit">Cadastrar</button>
                    <button type="reset">Limpar</button>
                </fieldset>
            </fieldset>
        </form>
    </div>

    <script type="module" src="src/js/main.js"></script>
    <?php
require_once './conn.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $error = null;

    // Verifica se a imagem foi enviada
    if (isset($_FILES['img_product']) && $_FILES['img_product']['error'] === UPLOAD_ERR_OK) {
        // Diretório de upload
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/uploads/products/';
        
        // Gera um nome único para o arquivo
        $fileName = time() . '_' . basename($_FILES['img_product']['name']);
        $uploadFile = $uploadDir . $fileName;

        // Verifica se o diretório existe e tenta mover o arquivo
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Cria o diretório se ele não existir
        }

        if (move_uploaded_file($_FILES['img_product']['tmp_name'], $uploadFile)) {
            $img_product = '/visual_tech/uploads/products/' . $fileName; // Caminho relativo da imagem
        } else {
            $error = "Erro ao salvar a imagem no servidor.";
        }
    } else {
        $error = "Erro no upload da imagem.";
    }

    $name_product = $_POST['name_product'] ?? NULL;
    $description_product = $_POST['description_product'] ?? NULL;
    $quantity_stock = $_POST['quantity_stock'] ?? NULL;
    $price_product = $_POST['price_product'] ?? NULL;
    $id_seller = $_POST['id_seller'] ?? NULL;

    class products {
        private $img_product;
        private $name_product;
        private $description_product;
        private $quantity_stock;
        private $price_product;
        private $id_seller;

        public function __construct($img_product, $name_product, $description_product, $quantity_stock, $price_product, $id_seller) {
            $this->img_product = $img_product;
            $this->name_product = $name_product;
            $this->description_product = $description_product;
            $this->quantity_stock = $quantity_stock;
            $this->price_product = $price_product;
            $this->id_seller = $id_seller;
        }

        public function cadastro_produto($conn) {
            // SQL para inserir o produto
            $sql = 'INSERT INTO products (img_product, name_product, description_product, quantity_stock, price_product, id_seller) VALUES (?, ?, ?, ?, ?, ?)';

            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Erro na preparação da consulta: " . $conn->error);
            }

            // Vincula os parâmetros
            $stmt->bind_param("sssdis", 
                $this->img_product, 
                $this->name_product, 
                $this->description_product, 
                $this->quantity_stock, 
                $this->price_product,
                $this->id_seller
            );

            // Executa a consulta e verifica o sucesso
            if ($stmt->execute()) {
                echo "Produto cadastrado com sucesso!";
                
                // Após o cadastro, registrar no log
                $this->registrar_log($conn);
            } else {
                echo "Erro ao cadastrar produto: " . $stmt->error;
            }

            $stmt->close();
        }

        // Método para registrar a ação no log
        private function registrar_log($conn) {
            // Obter o tipo de vendedor
            $sqlSellers = "SELECT cargo_seller FROM sellers WHERE id_seller = ?";
            $stmt = $conn->prepare($sqlSellers);
            $stmt->bind_param("i", $this->id_seller);
            $stmt->execute();
            $result = $stmt->get_result();
            $typeUser = $result->fetch_assoc()['cargo_seller'];

            if ($typeUser == 'master') {
                $tSeller = 'master';
            } elseif ($typeUser == 'vendedor') {
                $tSeller = 'vendedor';
            } else {
                $tSeller = 'client';
            }

            // Registrar no log
            $sqlLOG = "INSERT INTO log (user_type, user_id, action, description) 
                       VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sqlLOG);
            $tSeller = $typeUser; 
            $action = 'Cadastro';
            $description = "Cadastrou o produto " . $this->name_product;
            $stmt->bind_param("siss", $tSeller, $this->id_seller, $action, $description);
            $stmt->execute();
        }
    }

    if (!isset($error)) {
        $product = new products($img_product, $name_product, $description_product, $quantity_stock, $price_product, $id_seller);
        $product->cadastro_produto($conn);
    } else {
        echo $error; // Exibe o erro, se houver
    }

    // Fecha a conexão
    $conn->close();
}
?>
</body>
</html>