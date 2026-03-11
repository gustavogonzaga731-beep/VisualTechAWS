<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visual Tech</title>
    <!-- Link para o CSS do Bootstrap -->
    <link rel="stylesheet" href="../css/login.css">
    <style>
        .accessibility-mode {
            background-color: #000;
            color: #fff;
        }
        .accessibility-mode .navbar,
        .accessibility-mode header,
        .accessibility-mode .card,
        .accessibility-mode footer {
            background-color: #000;
            color: #fff;
        }
        .accessibility-mode a {
            color: #0d6efd; /* Cor de link acessível */
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/config.php'; ?>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" style="font-size: 1.5rem;" href="<?php echo BASE_URL; ?>/produtos.php">Visual Tech</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basic-navbar-nav" aria-controls="basic-navbar-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="basic-navbar-nav">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
          </li>
        </ul>
        <div class="other-links">
          <a class="item-link" href="">Produtos</a>
          <a href="<?php echo BASE_URL; ?>/login.php" class="item-link">Entrar</a>  
          <a href="<?php echo BASE_URL; ?>/cadastro.php" class="item-link">Cadastre-se</a>

        </div>
      </div>
    </nav>
    <!-- Botão para alternar o modo de acessibilidade -->
    <button id="accessibilityButton" class="btn btn-secondary mt-2">Alternar Modo de Acessibilidade</button>
</header>

<script>
    document.getElementById('accessibilityButton').addEventListener('click', function() {
        document.body.classList.toggle('accessibility-mode');
    });
</script>

</body>
</html>