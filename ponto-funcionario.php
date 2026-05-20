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

    <title>Folha de Ponto</title>

    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/ponto.css">

</head>
<body>

<div class="dashboard">

    <div class="sidebar">

        <h2>MacosTech</h2>

    </div>

    <div class="content">

        <div class="topo-ponto">

            <div>

                <h1 id="nomeFuncionario">

                    Folha de Ponto

                </h1>

                <p id="cargoFuncionario"></p>

            </div>

            <div class="acoes-topo">

                <button 
                    class="btn-salvar-tudo"
                    onclick="salvarTudo()"
                >

                    Salvar Tudo

                </button>

                <button 
                    class="btn-voltar"
                    onclick="voltarPonto()"
                >

                    Voltar

                </button>

            </div>

        </div>

        <div class="cards-ponto">

            <div class="card-ponto">

                <h3>Faltas</h3>

                <p id="totalFaltas">
                    0
                </p>

            </div>

            <div class="card-ponto">

                <h3>Atrasos</h3>

                <p id="tempoAtraso">
                    0 min
                </p>

            </div>

            <div class="card-ponto">

                <h3>Horas Extras</h3>

                <p id="tempoExtra">
                    0 min
                </p>

            </div>

            <div class="card-ponto">

                <h3>Descontos</h3>

                <p id="valorDesconto">
                    R$ 0
                </p>

            </div>

            <div class="card-ponto">

                <h3>Extra</h3>

                <p id="valorExtra">
                    R$ 0
                </p>

            </div>

        </div>

        <div class="config-box">

            <h2>Configuração do Expediente</h2>

            <div class="config-grid">

                <div>

                    <label>Entrada padrão</label>

                    <input 
                        type="time"
                        id="entradaPadrao"
                        value="08:00"
                    >

                </div>

                <div>

                    <label>Saída padrão</label>

                    <input 
                        type="time"
                        id="saidaPadrao"
                        value="17:00"
                    >

                </div>

                <div>

                    <button
                        class="btn-aplicar"
                        onclick="aplicarHorarioPadrao()"
                    >

                        Aplicar em todos

                    </button>

                </div>

            </div>

        </div>

        <div class="tabela-ponto">

            <table>

                <thead>

                    <tr>

                        <th>Data</th>

                        <th>Entrada</th>

                        <th>Saída</th>

                        <th>Falta</th>

                        <th>Atraso</th>

                        <th>Extra</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody id="tabelaDias">

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="js/ponto.js"></script>

</body>
</html>