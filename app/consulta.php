<?php
// Inclua a conexão com o banco de dados
include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/conn.php';

// Detecta se é uma requisição para buscar dados
if (isset($_GET['search']) && isset($_GET['filter'])) {
    $substring = $_GET['search'];
    $filter = $_GET['filter']; // 'name' ou 'cpf'

    // Prepare a consulta com base no filtro
    if ($filter === 'name') {
        $sql = $conn->prepare("SELECT id_user, name_complete, user_email FROM clients WHERE name_complete LIKE CONCAT('%', ?, '%')");
    } elseif ($filter === 'cpf') {
        $sql = $conn->prepare("SELECT id_user, name_complete, user_email FROM clients WHERE CPF LIKE CONCAT('%', ?, '%')");
    } else {
        echo json_encode([]);
        exit; // Saída para filtros inválidos
    }

    $sql->bind_param("s", $substring);
    $sql->execute();
    $result = $sql->get_result();

    // Converte os resultados em JSON
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($users);

    $conn->close();
    exit; // Encerra o script após enviar o JSON
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        input, select { margin-bottom: 10px; padding: 8px; }
        input { width: 300px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
<a href="javascript:void(0)" onclick="window.history.back()" class="back_page">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#0d6efd" viewBox="0 0 256 256">
                <path d="M224,128a8,8,0,0,1-8,8H59.31l58.35,58.34a8,8,0,0,1-11.32,11.32l-72-72a8,8,0,0,1,0-11.32l72-72a8,8,0,0,1,11.32,11.32L59.31,120H216A8,8,0,0,1,224,128Z"></path>
            </svg>
        </a>
    <h1>Lista de Usuários</h1>
    <select id="filter" onchange="clearResults()">
        <option value="name">Nome</option>
        <option value="cpf">CPF</option>
    </select>
    <input type="text" id="search" id="cpf" placeholder="Digite o valor..." onkeyup="searchUsers()">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome Completo</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody id="user-list">
            <!-- Resultados serão adicionados aqui -->
        </tbody>
    </table>

    <script>
        function clearResults() {
            document.getElementById('user-list').innerHTML = '';
            document.getElementById('search').value = '';
        }

        async function searchUsers() {
            const search = document.getElementById('search').value;
            const filter = document.getElementById('filter').value;

            if (!search.trim()) {
                document.getElementById('user-list').innerHTML = '';
                return;
            }

            try {
                const response = await fetch(`?search=${encodeURIComponent(search)}&filter=${encodeURIComponent(filter)}`);
                if (!response.ok) throw new Error('Erro ao buscar os usuários');
                const users = await response.json();

                const userList = document.getElementById('user-list');
                userList.innerHTML = '';
                users.forEach(user => {
                    userList.innerHTML += `
                        <tr>
                            <td>${user.id_user}</td>
                            <td>${user.name_complete}</td>
                            <td>${user.user_email}</td>
                        </tr>
                    `;
                });
            } catch (error) {
                console.error(error);
                alert('Houve um problema ao carregar os dados.');
            }
        }
    </script>
    <script type="module" src="./src/js/main.js"></script>
</body>
</html>
