<?php define('BASE_URL', '/visual_tech/app'); ?>
<?php 
    $sqlClients = 'SELECT * FROM clients';
    $sqlProducts = 'SELECT * FROM products';
    $sqlSellers = 'SELECT * FROM sellers';
    $sqlSellersSessions = "SELECT id_seller FROM sellers WHERE id_seller = ?";
    $sqlPost = "INSERT INTO clients (name_complete, gender, date_birth, maternal_name, CPF, user_email, user_cell, landline, cep, street, num, complement, pass)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
?>