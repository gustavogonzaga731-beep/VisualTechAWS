<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Produtos</title>
    <link rel="stylesheet" href="../app/src/css/header.css">
    <link rel="stylesheet" href="../app/src/css/footer.css">
    <link rel="stylesheet" href="../app/src/css/index.css">
    <link rel="stylesheet" href="../app/src/css/cards.css">
</head>
<body>
    
<?php 
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/conn.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/src/components/header_user.php';

// Função para definir links de produtos
function getProductLink($productName) {
    $links = [
        'Notebook Gamer G15' => 'https://pag.ae/7_5BuG6Xa',
        'Fone de ouvido sem fio JBL Tune 520BT Dobrável Preto' => 'https://pag.ae/7_5BxM_eq',
        'Kindle 11ª Geração' => 'https://pag.ae/7_5BwLKTJ',
    ];
    return $links[$productName] ?? '../app/login.php';
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Produtos</title>
    <link rel="stylesheet" href="../app/src/css/header.css">
    <link rel="stylesheet" href="../app/src/css/footer.css">
    <link rel="stylesheet" href="../app/src/css/index.css">
    <link rel="stylesheet" href="../app/src/css/cards.css">
</head>
<body>
    <br><br><br>
    <section>
        <div class="container">
            <div class="row">
                <?php
                // Consulta os produtos
                $sqlProducts = "SELECT name_product, img_product, price_product, description_product FROM products";
                $resultProducts = $conn->query($sqlProducts);

                if ($resultProducts && $resultProducts->num_rows > 0) {
                    while ($row = $resultProducts->fetch_assoc()) {
                        $productLink = getProductLink($row['name_product']);
                        echo '
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="card text-center" style="width: 100%;">
                                <img class="card-img-top" src="' . htmlspecialchars($row['img_product']) . '" alt="' . htmlspecialchars($row['name_product']) . '" style="height: 18rem; object-fit: contain;">
                                <div class="card-body">
                                    <h5 class="card-title">' . htmlspecialchars($row['name_product']) . '</h5>
                                    <h5>R$ ' . number_format($row['price_product'], 2, ',', '.') . '</h5>
                                    <p class="card-text">' . htmlspecialchars($row['description_product']) . '</p>
                                    <a href="' . htmlspecialchars($productLink) . '" class="btn btn-primary">Visitar</a>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                } else {
                    echo "<p class='text-center w-100'>Nenhum produto cadastrado.</p>";
                }
                ?>
            </div>
        </div>
    </section>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/src/components/footer_user.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
