<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
</head>
<body>
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/config.php'; ?>

<footer>
        <h5>Visual Tech</h5>
        <p>Loja Espacializada em produtos e-comerce <br>Agradecemos sua visita!</p>

        <div class="info-footer">
          <div>
            <h5>Contato</h5>
            <p><picture><img src="<?php echo BASE_URL; ?>./src/assets/icons/icon-whatsapp.svg" alt="Ícone do whatsapp"></picture>+55 (21) 99999-9999</p>
            <p><picture><img src="<?php echo BASE_URL; ?>./src/assets/icons/icon-de-mail.svg" alt="Ícone de mail"></picture>visual_tech.com.br</p>
            <p><picture><img src="<?php echo BASE_URL; ?>./src/assets/icons/icon-ponto-no-mapa.svg" alt="Ícone de ponto no mapa"></picture>Rua Fulano de tal, Nº 0101 - Loja A</p>

          </div>
          <div>
            <h5>Informações</h5>
            <p>Visual Tech Ltda.</p>
            <p>CNPJ: 00.000.000/0001-00</p>
            <p><picture><img src="<?php echo BASE_URL; ?>./src/assets/icons/icon-doc.svg" alt="Ícone do whatsapp"></picture>Politica de privacidade</p>
            <p><picture><img src="<?php echo BASE_URL; ?>./src/assets/icons/icon-doc.svg" alt="Ícone de mail"></picture>Termos de uso</p>
          </div>
          <div>
            <h5>Links úteis</h5>
            <a href="<?php echo BASE_URL ?>/produtos.php">Produtos</a>
            <a href="<?php echo BASE_URL ?>/login.php">Login</a>
            <a href="<?php echo BASE_URL ?>/cadastro.php">Cadastrar-se</a>
            <a href="">Comprar</a>
          </div>
          <div>
            <h5>Redes sociais</h5>
            <ul class="redes-sociais">
              <li><a href="#"><img src="<?php echo BASE_URL; ?>./src/assets/icons/icon-facebook.svg" alt=""></a></li>
              <li><a href="#"><img src="<?php echo BASE_URL; ?>./src/assets/icons/icon-instagran.svg" alt=""></a></li>
              <li><a href="#"><img src="<?php echo BASE_URL; ?>./src/assets/icons/icon-twitter.svg" alt=""></a></li>
              <li><a href="#"><img src="<?php echo BASE_URL; ?>./src/assets/icons/icon-youtube.svg" alt=""></a></li>
            </ul>
          </div>
        </div>
    </footer>
</body>
</html>