<?php 
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
    $query = 'SELECT name_complete FROM clients WHERE id_user = ?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['name'] = $row['name_complete'];
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visual Tech</title>
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

        .accessibility-mode .navbar {
            color: #8B8B8C;
        }
        
        .accessibility-mode a {
            color: #0d6efd;
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

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" style="font-size: 1.5rem;" href="<?php echo BASE_URL;?>/user.php">Visual Tech</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basic-navbar-nav" aria-controls="basic-navbar-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="basic-navbar-nav">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
          </li>
        </ul>
        <div class="other-links">
          <span>Bem-vindo, <a href="profile.php"><?php echo htmlspecialchars($_SESSION['name']); ?>!</a></span>
          <a href="<?php echo BASE_URL; ?>/logout.php" class="logout-button">Logout</a>
        </div>
      </div>
    </nav>
    <button id="accessibilityButton" class="btn btn-secondary mt-2">Alternar Modo de Acessibilidade</button>
</header>

<script>
    document.getElementById('accessibilityButton').addEventListener('click', function() {
        document.body.classList.toggle('accessibility-mode');
    });
</script>

</body>
</html>
