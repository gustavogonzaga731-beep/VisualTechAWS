<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/conn.php';

    if($_SERVER['REQUEST_METHOD'] === "POST") {
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
        $price_product = $_POST['price_product'] ?? NULL;
        $id_seller = $_POST['id_seller'] ?? NULL;

        class products {
            public $img_product;
            public $name_product;
            public $description_product;
            public $price_product;
            public $id_seller;

            public function __construct($img_product, $name_product, $description_product, $price_product, $id_seller) {
                $this->img_product = $img_product;
                $this->name_product = $name_product;
                $this->description_product = $description_product;
                $this->price_product = $price_product;
                $this->id_seller = $id_seller;
            }

            public function cadastro_produto($conn) {
                $sql = 'INSERT INTO products (img_product, name_product, description_product, price_product,id_seller) VALUES (?, ?, ?, ?, ?)';
    
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    die("Erro na preparação da consulta: " . $conn->error);
                }
    
                // Bind parameters
                $stmt->bind_param("sssss", 
                    $this->img_product, 
                    $this->name_product, 
                    $this->description_product, 
                    $this->price_product,
                    $this->id_seller
                );
    
                // Execute and check for success
                if ($stmt->execute()) {
                    echo "Produto cadastrado com sucesso!";
                } else {
                    echo "Erro ao cadastrar produto: " . $stmt->error;
                }
    
                $stmt->close();
            }
        }
    
        // Verifica se não houve erro antes de prosseguir
        if (!isset($error)) {
            $product = new products($img_product, $name_product, $description_product, $price_product, $id_seller);
            $product->cadastro_produto($conn);
        } else {
            echo $error; // Exibe o erro, se houver
        }
    
        // Fecha a conexão
        $conn->close();
        }
?>