<?php

session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Dashboard - RH Digital</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="dashboard">

        <div class="sidebar">

            <div class="logo-dashboard">
                <img src="img/logo.png" alt="Macos RH">
            </div>

            <ul>

                <li>
                    <a href="funcionarios.php">Funcionários</a>
                </li>

                <li>
                    <a href="ferias.php">Férias</a>
                </li>

                <li>
                    <a href="ponto.php">Controle de Ponto</a>
                </li>

                <li>
                    <a href="beneficios.php">Benefícios</a>
                </li>

                <li>
                    <a href="index.php">Logout</a>
                </li>

            </ul>

        </div>

        <div class="content">

            <h1>Bem-vindo ao Portal RH</h1>

            <div class="cards">

                <a href="funcionarios.php" class="card-link">
                    <div class="card">
                        <h3>Funcionários</h3>
                        <p>Gerencie os colaboradores</p>
                    </div>
                </a> 

                <a href="ferias.php" class="card-link">
                    <div class="card">
                        <h3>Férias</h3>
                        <p>Controle de férias</p>
                    </div>
                </a>

                <a href="ponto.php" class="card-link">
                    <div class="card">
                        <h3>Ponto</h3>
                        <p>Registro de jornada</p>
                    </div>
                </a> 

                <a href="beneficios.php" class="card-link">
                    <div class="card">
                        <h3>Benefícios</h3>
                        <p>Controle de benefícios</p>
                    </div>
                </a> 

            </div>

        </div>

    </div>

</body>
</html>