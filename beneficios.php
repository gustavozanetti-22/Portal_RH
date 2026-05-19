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
    <title>Benefícios - RH Digital</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="dashboard">

        <!-- MENU -->
        <div class="sidebar">

            <h2>RH Digital</h2>

            <ul>

                <li>
                    <a href="dashboard.php">Dashboard</a>
                </li>

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
                    <a href="reembolsos.php">Reembolsos</a>
                </li>

                <li>
                    <a href="beneficios.php">Benefícios</a>
                </li>

                <li>
                    <a href="logout.php">Sair</a>
                </li>

            </ul>

        </div>

        <!-- CONTEÚDO -->
        <div class="content">

            <div class="topo-beneficios">

                <h1>Benefícios</h1>

                <button class="btn-beneficio">
</html>