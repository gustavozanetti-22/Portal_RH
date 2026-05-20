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

    <title>Benefícios</title>

    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/beneficios.css">

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
                    <a href="ferias.php">Férias</a>
                </li>

                <li>
                    <a href="ponto.php">Controle de Ponto</a>
                </li>



    </div>

    <!-- CONTEÚDO -->
    <div class="content">

        <div class="topo-beneficios">

            <h1>Controle de Benefícios</h1>

            <button 
                class="btn-relatorio"
                onclick="gerarRelatorioPDF()"
            >

                Gerar Relatório PDF

            </button>

        </div>

        <!-- CARDS -->
        <div class="cards-beneficios">

            <div class="card-beneficio">

                <h3>Total Funcionários</h3>

                <p id="totalFuncionarios">0</p>

            </div>

            <div class="card-beneficio">

                <h3>Convênio Ativo</h3>

                <p id="totalConvenio">0</p>

            </div>

            <div class="card-beneficio">

                <h3>Vale Transporte</h3>

                <p id="totalVT">0</p>

            </div>

        </div>

        <!-- FILTROS -->
        <div class="filtro-box">

            <h2>Filtros</h2>

            <div class="grid-filtro">

                <input 
                    type="text"
                    id="filtroNome"
                    placeholder="Buscar funcionário"
                >

                <select id="filtroConvenio">

                    <option value="">
                        Todos os convênios
                    </option>

                    <option value="Sim">
                        Convênio ativo
                    </option>

                    <option value="Não">
                        Sem convênio
                    </option>

                </select>

            </div>

        </div>

        <!-- TABELA -->
        <div class="tabela-beneficios">

            <table>

                <thead>

                    <tr>

                        <th>Funcionário</th>

                        <th>Convênio</th>

                        <th>Vale Transporte</th>

                        <th>Vale Refeição</th>

                        <th>Plano Odontológico</th>

                        <th>Ações</th>

                    </tr>

                </thead>

                <tbody id="tabelaBeneficios">

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="js/beneficios.js"></script>

</body>
</html>