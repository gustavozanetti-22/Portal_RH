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

    <title>Férias</title>

    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/ferias.css">

</head>
<body>

<div class="dashboard">

    <!-- MENU -->
    <div class="sidebar">

        <h2>MacosTech</h2>

            <ul>

                <li>
                    <a href="dashboard.php">Página Inicial</a>
                </li>

                <li>
                    <a href="funcionarios.php">Funcionários</a>
                </li>

                <li>
                    <a href="ponto.php">Controle de Ponto</a>
                </li>

                <li>
                    <a href="beneficios.php">Benefícios</a>
                </li>


    </div>

    <!-- CONTEÚDO -->
    <div class="content">

        <div class="topo-ferias">

            <h1>Controle de Férias</h1>

            <button class="btn-relatorio" onclick="gerarRelatorio()">

                Gerar Relatório

            </button>

        </div>

        <!-- CARDS -->
        <div class="cards-ferias">

            <div class="card-ferias">

                <h3>Total Funcionários</h3>

                <p id="totalFuncionarios">0</p>

            </div>

            <div class="card-ferias">

                <h3>Em férias</h3>

                <p id="emFerias">0</p>

            </div>

            <div class="card-ferias">

                <h3>Férias pagas</h3>

                <p id="feriasPagas">0</p>

            </div>

        </div>

        <!-- TABELA -->
        <div class="tabela-ferias">

            <table>

                <thead>

                    <tr>

                        <th>Funcionário</th>

                        <th>Últimas férias</th>

                        <th>Dias desde férias</th>

                        <th>Saída</th>

                        <th>Retorno</th>

                        <th>Vendeu 10 dias</th>

                        <th>Férias pagas</th>

                        <th>Ações</th>

                    </tr>

                </thead>

                <tbody id="tabelaFerias">

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="js/ferias.js"></script>

</body>
</html>