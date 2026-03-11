<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/conn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $error = null;

    // Verifica se a imagem foi enviada
    if (isset($_FILES['img_seller']) && $_FILES['img_seller']['error'] === UPLOAD_ERR_OK) {
        // Diretório de upload
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/uploads/sellers/';
        
        // Gera um nome único para o arquivo
        $fileName = time() . '_' . basename($_FILES['img_seller']['name']);
        $uploadFile = $uploadDir . $fileName;

        // Verifica se o diretório existe e tenta mover o arquivo
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Cria o diretório se ele não existir
        }

        if (move_uploaded_file($_FILES['img_seller']['tmp_name'], $uploadFile)) {
            $img_seller = '/visual_tech/uploads/sellers/' . $fileName; // Caminho relativo da imagem
        } else {
            $error = "Erro ao salvar a imagem no servidor.";
        }
    } else {
        $error = "Erro no upload da imagem.";
    }

    $name_seller = $_POST['name_seller'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $email_seller = $_POST['email_seller'] ?? null;
    $cargo_seller = $_POST['cargo_seller'] ?? null;

    // Verifica se as senhas coincidem
    if ($_POST['pass_seller'] === $_POST['c_pass']) {
        $pass_seller = password_hash($_POST['pass_seller'], PASSWORD_BCRYPT);
    } else {
        $error = "As senhas não coincidem.";
    }

    // Classe para vendedores
    class Sellers {
        public $img_seller;
        public $name_seller;
        public $gender;
        public $email_seller;
        public $cargo_seller;
        public $pass_seller;

        public function __construct($img_seller, $name_seller, $gender, $email_seller, $cargo_seller, $pass_seller) {
            $this->img_seller = $img_seller;
            $this->name_seller = $name_seller;
            $this->gender = $gender;
            $this->email_seller = $email_seller;
            $this->cargo_seller = $cargo_seller;
            $this->pass_seller = $pass_seller;
        }

        public function cadastro_vendedor($conn) {
            $sql = 'INSERT INTO sellers (img_seller, name_seller, gender, email_seller, cargo_seller, pass_seller) VALUES (?, ?, ?, ?, ?, ?)';

            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Erro na preparação da consulta: " . $conn->error);
            }

            // Bind parameters
            $stmt->bind_param("ssssss", 
                $this->img_seller, 
                $this->name_seller, 
                $this->gender, 
                $this->email_seller, 
                $this->cargo_seller, 
                $this->pass_seller
            );

            // Execute and check for success
            if ($stmt->execute()) {
                echo "Vendedor cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar vendedor: " . $stmt->error;
            }

            $stmt->close();
        }
    }

    // Verifica se não houve erro antes de prosseguir
    if (!isset($error)) {
        $seller = new Sellers($img_seller, $name_seller, $gender, $email_seller, $cargo_seller, $pass_seller);
        $seller->cadastro_vendedor($conn);
    } else {
        echo $error; // Exibe o erro, se houver
    }

    // Fecha a conexão
    $conn->close();
}
?>
