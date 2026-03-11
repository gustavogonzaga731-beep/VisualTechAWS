<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre vendedor</title>
    <link rel="stylesheet" href="src/css/forms.css" type="text/css">
    <link rel="stylesheet" href="src/css/index.css" type="text/css">
    <link rel="stylesheet" href="src/css/footer.css" type="text/css">
    <link rel="stylesheet" href="src/css/index.css" type="text/css">
    <link rel="stylesheet" href="src/css/header.css" type="text/css">

</head>
<body>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/config.php'; ?>

    <div class="container-form">
        <form action="" method="POST" enctype="multipart/form-data">
        <p id="message"></p>

            <a href="javascript:void(0)" onclick="window.history.back()" class="back_page">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M224,128a8,8,0,0,1-8,8H59.31l58.35,58.34a8,8,0,0,1-11.32,11.32l-72-72a8,8,0,0,1,0-11.32l72-72a8,8,0,0,1,11.32,11.32L59.31,120H216A8,8,0,0,1,224,128Z"></path></svg>
            </a>
            <fieldset>
                <legend>Cadastre vendedor</legend>

                <span>Foto do vendedor</span>
                <input type="file" name="img_seller" id="img_seller" required autocomplete="off">

                <span>Nome do vendedor</span>
                <input type="text" name="name_seller" id="name_seller" maxlength="80" minlength="15" required autocomplete="off">
                
                <span>Gênero</span>
                <select name="gender" id="gender" required>
                    <option value="">Selecione</option>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                    <option value="OT">Outros</option>
                </select>

                <span>E-mail vendedor</span>
                <input type="text" name="email_seller" id="email_seller"  maxlength="50" placeholder="alexia.morais@visual _tech.com.br" autocomplete="off" required autocomplete="off">
        
                <span>Cargo</span>
                <input type="text" name="cargo_seller" id="cargo_seller" value="vendedor" readonly required autocomplete="off">

                <span>Senha</span>
                <input type="password" name="pass_seller" id="pass_seller"  maxlength="8" placeholder="*********" autocomplete="off" required>

                <span>Confirme a senha</span>
                <input type="password" name="c_pass" id="c_pass"  maxlength="8" placeholder="*********"  required>

                <fieldset class="container-buttons">
                    <button type="submit">Cadastrar</button>
                    <button type="reset">Limpar</button>
                </fieldset>
            </fieldset>
        </form>
    </div>

    <script type="module" src="src/js/main.js"></script>
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

    </body>
</html>