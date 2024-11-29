<?php
session_start();
include_once('config.php');

// Verifica se o usuário está logado
if ((!isset($_SESSION['email']) || !isset($_SESSION['senha']))) {
    unset($_SESSION['email'], $_SESSION['senha']);
    header('Location: login.php');
    exit;
}

// Recupera informações do usuário logado
$logado = $_SESSION['email'];

// Simulação de dados de usuários (caso precise)
$usuarios = [
    ['id' => 1, 'nome' => 'Kaue Henrique', 'email' => 'kaue.henrique3@hotmail.com', 'telefone' => '43984145785', 'sexo' => 'Masculino', 'data_nasc' => '2004-03-03', 'cidade' => 'Londrina', 'estado' => 'PR', 'endereco' => 'Rua Mario Barbosa Junior'],
    ['id' => 2, 'nome' => 'SID\'S', 'email' => 'marmitaria.villa.34@gmail.com', 'telefone' => '43999026218', 'sexo' => 'Masculino', 'data_nasc' => '1996-06-12', 'cidade' => 'Londrina', 'estado' => 'PR', 'endereco' => 'Rua Figueira 575']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, rgb(20, 147, 220), rgb(17, 54, 71));
            color: white;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background: #333;
            padding: 10px 20px;
        }
        .navbar .menu-icon {
            background: #555;
            color: white;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            margin-right: 15px;
        }
        .navbar .menu-icon:hover {
            background: #666;
        }
        .side-menu {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            background: #444;
            color: white;
            transition: all 0.3s ease-in-out;
            overflow: hidden;
            z-index: 999;
        }
        .side-menu.active {
            left: 0;
        }
        .side-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
            margin-top: 60px;
        }
        .side-menu ul li {
            padding: 15px;
            text-align: left;
            padding-left: 20px;
        }
        .side-menu ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            display: block;
        }
        .side-menu ul li a:hover {
            background: #555;
            border-radius: 4px;
        }
        .welcome-message {
            margin-top: 50px;
            font-size: 36px;
            font-weight: bold;
        }
        .box-search {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
        }
        .box-search input {
            width: 300px;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
        }
        .box-search button {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
        }
        .table-bg {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px 15px 0 0;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <span class="menu-icon" id="menu-icon">☰</span>
            <a class="navbar-brand text-white" href="#">SID'S Pizzaria e Hamburgueria</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto">
                    <a href="sair.php" class="btn btn-danger">Sair</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Menu Lateral -->
    <div class="side-menu" id="side-menu">
        <ul>
            <li><a href="sistema.php">Início</a></li>
            <li><a href="itens.php">Itens</a></li>
            <li><a href="contasPagas.php">Contas Pagas</a></li>
            <li><a href="contasAPagar.php">Contas a Pagar</a></li>
            <li><a href="cartao.php">Quanto Usou no Cartão</a></li>
            <li><a href="fechamentoDia.php">Fechamento do Dia</a></li>
            <li><a href="fechamentoMes.php">Fechamento do Mês</a></li>
        </ul>
    </div>

    <!-- Conteúdo Principal -->
    <div class="container">
        <div class="welcome-message text-center">
            <?php echo "Bem vindo <u>$logado</u>"; ?>
        </div>

        <!-- Barra de Pesquisa -->
        <div class="box-search">
            <input type="search" class="form-control" placeholder="Pesquisar Usuários">
            <button class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a.5.5 0 0 0-.115-.1zM12 6.5a5.5.5 0 1 1-11 0 5.5.5.5 0 0 1 11 0z"/>
                </svg>
            </button>
        </div>

        <!-- Tabela de Usuários -->
        <div class="m-5">
            <table class="table text-white table-bg">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Sexo</th>
                        <th scope="col">Data de Nascimento</th>
                        <th scope="col">Cidade</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Endereço</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($usuarios as $usuario) {
                        echo "<tr>";
                        echo "<td>" . $usuario['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($usuario['nome'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($usuario['email'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($usuario['telefone'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($usuario['sexo'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($usuario['data_nasc'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($usuario['cidade'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($usuario['estado'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($usuario['endereco'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        var menuIcon = document.getElementById('menu-icon');
        var sideMenu = document.getElementById('side-menu');

        menuIcon.addEventListener('click', function() {
            sideMenu.classList.toggle('active');
        });

        sideMenu.addEventListener('mouseleave', function() {
            sideMenu.classList.remove('active');
        });
    </script>
</body>
</html>
