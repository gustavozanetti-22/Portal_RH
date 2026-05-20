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

    <title>Funcionários - RH Digital</title>

    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/funcionarios.css">

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
                    <a href="ferias.php">Férias</a>
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

            <div class="topo-funcionarios">

                <h1>Funcionários</h1>

                <button class="btn-funcionario" onclick="abrirFormulario()">
                    + Novo Funcionário
                </button>

            </div>

            <!-- CARDS -->
            <div class="cards-funcionarios">

                <div class="card-funcionario">

                    <h3>Total Funcionários</h3>

                    <p id="totalFuncionarios">0</p>

                </div>

                <div class="card-funcionario">

                    <h3>Folha Salarial</h3>

                    <p id="folhaSalarial">R$ 0</p>

                </div>

            </div>

            <!-- FILTROS -->
            <div class="form-funcionario">

                <h2>Filtrar Funcionários</h2>

                <div class="grid-funcionarios">

                    <div class="input-group">

                        <label>Nome</label>

                        <input 
                            type="text"
                            id="filtroNome"
                            placeholder="Digite o nome"
                        >

                    </div>

                    <div class="input-group">

                        <label>Cargo</label>

                        <input 
                            type="text"
                            id="filtroCargo"
                            placeholder="Digite o cargo"
                        >

                    </div>

                </div>

            </div>

            <!-- TABELA -->
            <div class="tabela-funcionarios">

                <h2>Lista de Funcionários</h2>

                <table>

                    <thead>

                        <tr>

                            <th>ID</th>
                            <th>Nome</th>
                            <th>Cargo</th>
                            <th>Salário</th>
                            <th>Email</th>
                            <th>Ações</th>

                        </tr>

                    </thead>

                    <tbody id="tabelaFuncionarios">

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <script src="js/funcionarios.js"></script>

</body>
</html>