<?php
 
include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/conn.php';
 
// Classe definida fora do bloco POST (boa prática)
class Products {
    public $img_product;
    public $name_product;
    public $description_product;
    public $price_product;
    public $id_seller;
 
    public function __construct($img_product, $name_product, $description_product, $price_product, $id_seller) {
        $this->img_product         = $img_product;
        $this->name_product        = $name_product;
        $this->description_product = $description_product;
        $this->price_product       = $price_product;
        $this->id_seller           = $id_seller;
    }
 
    public function cadastro_produto($conn) {
        $sql = 'INSERT INTO products (img_product, name_product, description_product, price_product, id_seller) VALUES (?, ?, ?, ?, ?)';
 
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            error_log("Erro ao preparar query: " . $conn->error);
            echo "Erro interno. Tente novamente mais tarde.";
            return;
        }
 
        $stmt->bind_param(
            "sssss",
            $this->img_product,
            $this->name_product,
            $this->description_product,
            $this->price_product,
            $this->id_seller
        );
 
        if ($stmt->execute()) {
            echo "Produto cadastrado com sucesso!";
        } else {
            error_log("Erro ao cadastrar produto: " . $stmt->error);
            echo "Erro ao cadastrar produto. Tente novamente.";
        }
 
        $stmt->close();
    }
}
 
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $error = null;
 
    // Verifica se a imagem foi enviada
    if (isset($_FILES['img_product']) && $_FILES['img_product']['error'] === UPLOAD_ERR_OK) {
 
        // CORRIGIDO: valida o tipo real do arquivo pelo conteúdo (não pela extensão)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $_FILES['img_product']['tmp_name']);
        finfo_close($finfo);
 
        if (!in_array($mimeType, $allowedTypes)) {
            $error = "Tipo de arquivo não permitido. Envie apenas JPG, PNG ou WEBP.";
        } else {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/uploads/products/';
 
            // Força extensão segura com base no mime type real
            $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
            $ext = $extensions[$mimeType];
 
            // Nome único sem depender do nome enviado pelo usuário
            $fileName   = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
            $uploadFile = $uploadDir . $fileName;
 
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
 
            if (move_uploaded_file($_FILES['img_product']['tmp_name'], $uploadFile)) {
                $img_product = '/visual_tech/uploads/products/' . $fileName;
            } else {
                $error = "Erro ao salvar a imagem no servidor.";
            }
        }
    } else {
        $error = "Erro no upload da imagem.";
    }
 
    $name_product        = $_POST['name_product']        ?? null;
    $description_product = $_POST['description_product'] ?? null;
    $price_product       = $_POST['price_product']       ?? null;
    $id_seller           = $_POST['id_seller']           ?? null;
 
    if (!isset($error)) {
        $product = new Products($img_product, $name_product, $description_product, $price_product, $id_seller);
        $product->cadastro_produto($conn);
    } else {
        echo $error;
    }
 
    $conn->close();
}