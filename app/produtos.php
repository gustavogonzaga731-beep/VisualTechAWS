<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Produtos</title>
    <link rel="stylesheet" href="../app/src/css/header.css" type="text/css">
    <link rel="stylesheet" href="../app/src/css/footer.css" type="text/css">
    <link rel="stylesheet" href="../app/src/css/index.css" type="text/css">
    <link rel="stylesheet" href="../app/src/css/cards.css" type="text/css">

</head>
<body>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/config.php'; ?>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/conn.php'; ?>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/src/components/header.php'; ?>
    
    <br><br><br>

    <!-- Container para os Produtos -->
    <section>
        <div class="container">
            <div class="row">
                <?php
                    // Verificação de conexão
                    if ($conn->connect_error) {
                        die("Falha na conexão: " . $conn->connect_error);
                    }

                    // Consulta SQL para buscar os produtos
                    $result = $conn->query($sqlProducts);

                    // Verificando se há produtos
                    if ($result->num_rows > 0) {
                        // Exibir cada produto como um card Bootstrap
                        while ($row = $result->fetch_assoc()) {
                            echo '
                            <div class="col-md-4 mb-4">
                                <div class="card" style="width: 100%; text-align: center;">
                                    <img class="card-img-top" src="' . $row['img_product'] . '" alt="Imagem de ' . $row['name_product'] . '" style="height: 18rem;     object-fit: contain;">
                                    <div class="card-body">
                                        <h5 class="card-title">' . $row['name_product'] . '</h5>
                                        <h5>R$' . number_format($row['price_product'], 2, ',', '.') . '</h5>
                                        <p class="card-text">' . $row['description_product'] . '</p>
                                        <a href="../app/login.php" class="btn btn-primary">Visitar</a>
                                    </div>
                                </div>
                            </div>
                            ';
                        }
                    } else {
                        echo "<p>Nenhum produto cadastrado.</p>";
                    }

                    // Fechar a conexão
                    $conn->close();
                ?>
            </div>
        </div>
    </section>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/src/components/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
