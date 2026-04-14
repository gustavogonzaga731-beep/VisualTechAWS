<?php
 
include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/conn.php';
 
// Classe definida fora do bloco POST (boa prática)
class Sellers {
    public $img_seller;
    public $name_seller;
    public $gender;
    public $email_seller;
    public $cargo_seller;
    public $pass_seller;
 
    public function __construct($img_seller, $name_seller, $gender, $email_seller, $cargo_seller, $pass_seller) {
        $this->img_seller   = $img_seller;
        $this->name_seller  = $name_seller;
        $this->gender       = $gender;
        $this->email_seller = $email_seller;
        $this->cargo_seller = $cargo_seller;
        $this->pass_seller  = $pass_seller;
    }
 
    public function cadastro_vendedor($conn) {
        $sql = 'INSERT INTO sellers (img_seller, name_seller, gender, email_seller, cargo_seller, pass_seller) VALUES (?, ?, ?, ?, ?, ?)';
 
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            error_log("Erro ao preparar query: " . $conn->error);
            echo "Erro interno. Tente novamente mais tarde.";
            return;
        }
 
        $stmt->bind_param(
            "ssssss",
            $this->img_seller,
            $this->name_seller,
            $this->gender,
            $this->email_seller,
            $this->cargo_seller,
            $this->pass_seller
        );
 
        if ($stmt->execute()) {
            echo "Vendedor cadastrado com sucesso!";
        } else {
            error_log("Erro ao cadastrar vendedor: " . $stmt->error);
            echo "Erro ao cadastrar vendedor. Tente novamente.";
        }
 
        $stmt->close();
    }
}
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $error = null;
 
    // Verifica se a imagem foi enviada
    if (isset($_FILES['img_seller']) && $_FILES['img_seller']['error'] === UPLOAD_ERR_OK) {
 
        // CORRIGIDO: valida o tipo real do arquivo pelo conteúdo (não pela extensão)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $_FILES['img_seller']['tmp_name']);
        finfo_close($finfo);
 
        if (!in_array($mimeType, $allowedTypes)) {
            $error = "Tipo de arquivo não permitido. Envie apenas JPG, PNG ou WEBP.";
        } else {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/uploads/sellers/';
 
            // Força extensão segura com base no mime type real
            $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
            $ext = $extensions[$mimeType];
 
            // Nome único sem depender do nome enviado pelo usuário
            $fileName   = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
            $uploadFile = $uploadDir . $fileName;
 
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
 
            if (move_uploaded_file($_FILES['img_seller']['tmp_name'], $uploadFile)) {
                $img_seller = '/visual_tech/uploads/sellers/' . $fileName;
            } else {
                $error = "Erro ao salvar a imagem no servidor.";
            }
        }
    } else {
        $error = "Erro no upload da imagem.";
    }
 
    $name_seller  = $_POST['name_seller']  ?? null;
    $gender       = $_POST['gender']       ?? null;
    $email_seller = $_POST['email_seller'] ?? null;
    $cargo_seller = $_POST['cargo_seller'] ?? null;
 
    if (!isset($error)) {
        if ($_POST['pass_seller'] === $_POST['c_pass']) {
            $pass_seller = password_hash($_POST['pass_seller'], PASSWORD_BCRYPT);
        } else {
            $error = "As senhas não coincidem.";
        }
    }
 
    if (!isset($error)) {
        $seller = new Sellers($img_seller, $name_seller, $gender, $email_seller, $cargo_seller, $pass_seller);
        $seller->cadastro_vendedor($conn);
    } else {
        echo $error;
    }
 
    $conn->close();
}
