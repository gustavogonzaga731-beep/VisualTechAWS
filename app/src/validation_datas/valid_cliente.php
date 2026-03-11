<?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/conn.php';

    if($_SERVER["REQUEST_METHOD"] === "POST") {

        $name_complete = $_POST['name_complete'] ?? null;
        $gender = $_POST['gender'] ?? null;
        $maternal_name = $_POST['maternal_name'] ?? null;
        $date_birth = $_POST['date_birth'] ?? null;
        $cpf = $_POST['cpf'] ?? null;
        $user_email = $_POST['user_email'] ?? null;
        $user_cell = $_POST['user_cell'] ?? null;
        $landline = $_POST['landline'] ?? ""; // Simplified
        $cep = $_POST['cep'] ?? null;
        $street = $_POST['street'] ?? null;
        $num = $_POST['num'] ?? null;
        $complement = $_POST['complement'] ?? null;

        if($_POST['pass'] === $_POST['c_pass']) {
            $pass = $_POST['pass']; 
        } else {
            echo "As senhas não são iguais";
            exit;
        }
    }

    class Clients {
        private $name_complete;
        private $gender;
        private $maternal_name;
        private $date_birth;
        private $cpf;
        private $user_email;
        private $user_cell;
        private $landline;
        private $cep;
        private $street;
        private $num;
        private $complement;
        private $pass;

        public function __construct($name_complete, $gender, $maternal_name, $date_birth, $cpf, $user_email, $user_cell, $landline, $cep, $street, $num, $complement, $pass) {
            $this->name_complete = $name_complete;
            $this->gender = $gender;
            $this->maternal_name = $maternal_name;
            $this->date_birth = $date_birth;
            $this->cpf = $cpf;
            $this->user_email = $user_email;
            $this->user_cell = $user_cell;
            $this->landline = $landline;
            $this->cep = $cep;
            $this->street = $street;
            $this->num = $num;
            $this->complement = $complement;
            $this->pass = $pass;
        }

        public function cadastrarClientes($conn) {

            $sql = "INSERT INTO clients (name_complete, gender, maternal_name, date_birth, cpf, user_email, user_cell, landline, cep, street, num, complement, password)
            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";    

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssssssss", 
                $this->name_complete, 
                $this->gender, 
                $this->maternal_name, 
                $this->date_birth, 
                $this->cpf, 
                $this->user_email, 
                $this->user_cell, 
                $this->landline, 
                $this->cep, 
                $this->street, 
                $this->num,
                $this->complement,
                $this->pass // Ensure password is stored in the correct column
            );

            if ($stmt->execute()) {
                echo "Cliente cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar cliente: " . $stmt->error;
            }

            $stmt->close();
        }
    }

    // Make sure the $conn variable is passed correctly to the method
    $cliente = new Clients($name_complete, $gender, $maternal_name, $date_birth, $cpf, $user_email, $user_cell, $landline, $cep, $street, $num, $complement, $pass);

    $cliente->cadastrarClientes($conn);

    $conn->close();
?>
