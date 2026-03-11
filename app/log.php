
<?php
    session_start();

    include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/config.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/conn.php';

    $sqlSellersSessions = "SELECT id_seller FROM sellers WHERE id_seller = ?";
    $stmt = $conn->prepare($sqlSellersSessions);
    $stmt->bind_param("i", $_SESSION['seller']);
    $stmt->execute();
    $result = $stmt->get_result();
    $seller = $result->fetch_assoc()['id_seller'];
    if (!$_SESSION['seller']) {
        header("Location: login.php");
        session_unset();
        session_destroy();
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs do Sistema</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilos do sistema */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        header {
            background-color: #0d6efd;
            color: #fff;
            padding: 1rem;
            text-align: center;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 1rem;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .filters {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .filters select, .filters input {
            padding: 0.5rem;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .logs-table {
            width: 100%;
            border-collapse: collapse;
        }
        .logs-table th, .logs-table td {
            text-align: left;
            padding: 0.8rem;
            border-bottom: 1px solid #ccc;
        }
        .logs-table th {
            background-color: #0d6efd;
            color: #fff;
        }
        .logs-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        footer {
            margin-top: 2rem;
            text-align: center;
            padding: 1rem;
            background-color: #0d6efd;
            color: #fff;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Logs do Sistema</h1>
        <p>Visualize e gerencie os registros de ações no sistema</p>
    </header>
    <div class="container">
        <?php 
            include_once $_SERVER['DOCUMENT_ROOT'] . '/visual_tech/app/src/components/buttonBack.php';
        ?>
        <div class="filters">
            <div>
                <label for="user-type">Filtrar por tipo de usuário:</label>
                <select id="user-type">
                    <option value="all">Todos</option>
                    <option value="vendedor">Vendedor</option>
                    <option value="client">Cliente</option>
                    <option value="master">Master</option>
                </select>
            </div>
            <div>
                <label for="search">Pesquisar:</label>
                <input type="text" id="search" placeholder="Digite a ação ou descrição..." autocomplete="off">
            </div>
        </div>
        <table class="logs-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Usuário</th>
                    <th>ID do Usuário</th>
                    <th>Ação</th>
                    <th>Descrição</th>
                    <th>Data/Hora</th>
                </tr>
            </thead>
            <tbody id="log-entries">
                <!-- Os registros de log serão carregados dinamicamente -->
            </tbody>
        </table>
    </div>
    <footer>
        &copy; 2024 Sistema de Gerenciamento
    </footer>
    <script>
        // Seletores de elementos
        const userTypeFilter = document.getElementById('user-type');
        const searchInput = document.getElementById('search');
        const logEntriesContainer = document.getElementById('log-entries');

        // Função para buscar os logs do banco
        async function fetchLogs() {
            try {
                const response = await fetch('logs.php');
                if (!response.ok) throw new Error('Erro ao buscar logs');
                const logs = await response.json();
                renderLogs(logs);
            } catch (error) {
                console.error('Erro:', error);
                logEntriesContainer.innerHTML = '<tr><td colspan="6">Erro ao carregar os logs.</td></tr>';
            }
        }

        // Função para renderizar logs na tabela
        function renderLogs(logs, filter = 'all', search = '') {
            logEntriesContainer.innerHTML = '';
            logs.forEach(log => {
                if ((filter === 'all' || log.user_type === filter) &&
                    (log.action.toLowerCase().includes(search.toLowerCase()) || 
                     (log.description || '').toLowerCase().includes(search.toLowerCase()))) {
                    const row = `
                        <tr>
                            <td>${log.id_log}</td>
                            <td>${log.user_type}</td>
                            <td>${log.user_id}</td>
                            <td>${log.action}</td>
                            <td>${log.description || 'Sem descrição'}</td>
                            <td>${log.timestamp}</td>
                        </tr>
                    `;
                    logEntriesContainer.innerHTML += row;
                }
            });
        }

        // Eventos para filtros
        userTypeFilter.addEventListener('change', () => {
            fetchLogs().then(logs => renderLogs(logs, userTypeFilter.value, searchInput.value));
        });

        searchInput.addEventListener('input', () => {
            fetchLogs().then(logs => renderLogs(logs, userTypeFilter.value, searchInput.value));
        });

        // Carregar os logs ao iniciar
        fetchLogs();
    </script>
</body>
</html>