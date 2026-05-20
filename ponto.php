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

    <title>Controle de Ponto</title>

    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/ponto.css">

</head>
<body>

<div class="modal-mes" id="modalMes">

    <div class="modal-box">

        <h2>Selecionar Mês</h2>

        <input type="month" id="mesSelecionado">

        <button onclick="selecionarMes()">

            Continuar

        </button>

    </div>

</div>

<div class="dashboard">

    <div class="sidebar">

        <h2>MacosTech</h2>

        <ul>

            <li>
                <a href="dashboard.php">Página inicial</a>
            </li>

            <li>
                <a href="funcionarios.php">Funcionários</a>
            </li>

            <li>
                <a href="beneficios.php">Benefícios</a>
            </li>

            <li>
                <a href="ferias.php">Férias</a>
            </li>

        </ul>

    </div>

    <div class="content">

        <div class="topo-ponto">

            <h1>

                Controle de Ponto

            </h1>

            <button 
                class="btn-relatorio"
                onclick="gerarRelatorio()"
            >

                Gerar Relatório

            </button>

        </div>

        <div class="cards-ponto">

            <div class="card-ponto">

                <h3>Total Folha</h3>

                <p id="totalFolha">
                    R$ 0
                </p>

            </div>

            <div class="card-ponto">

                <h3>Total Atrasos</h3>

                <p id="totalAtrasos">
                    0 min
                </p>

            </div>

            <div class="card-ponto">

                <h3>Horas Extras</h3>

                <p id="horasExtras">
                    0 min
                </p>

            </div>

        </div>

        <div class="tabela-ponto">

            <table>

                <thead>

                    <tr>

                        <th>Funcionário</th>

                        <th>Cargo</th>

                        <th>Salário</th>

                        <th>Total Receber</th>

                        <th>Atrasos</th>

                        <th>Horas Extras</th>

                        <th>Ações</th>

                    </tr>

                </thead>

                <tbody id="tabelaFuncionarios">

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="js/ponto.js"></script>

</body>
</html>