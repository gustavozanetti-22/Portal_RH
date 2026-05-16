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

        <!-- SIDEBAR -->
        <div class="sidebar">

            <h2>RH Digital</h2>

            <ul>

                <li>
                    <a href="funcionarios.php">Funcionários</a>
                </li>

                <li>
                    <a href="#">Férias</a>
                </li>

                <li>
                    <a href="#">Controle de Ponto</a>
                </li>

                <li>
                    <a href="#">Reembolsos</a>
                </li>

                <li>
                    <a href="#">Benefícios</a>
                </li>

                <li>
                    <a href="#">Desligamentos</a>
                </li>

            </ul>

        </div>

        <!-- CONTEÚDO -->
        <div class="content">

            <h1>Bem-vindo ao RH Digital</h1>

            <div class="cards">

<a href="funcionarios.php" class="card-link">

    <div class="card">
        <h3>Funcionários</h3>
        <p>Gerencie os colaboradores</p>
    </div>

</a>

                <div class="card">
                    <h3>Férias</h3>
                    <p>Controle de solicitações</p>
                </div>

                <div class="card">
                    <h3>Ponto</h3>
                    <p>Registro de jornada</p>
                </div>

                <div class="card">
                    <h3>Reembolsos</h3>
                    <p>Gestão de despesas</p>
                </div>

            </div>

        </div>

    </div>

</body>
</html>