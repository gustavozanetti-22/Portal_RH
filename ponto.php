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
    <title>Controle de Ponto - RH Digital</title>

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

            <div class="topo-ponto">

                <h1>Controle de Ponto</h1>

                <button class="btn-ponto">
                    + Novo Registro
                </button>

            </div>

            <!-- CARDS -->
            <div class="cards-ponto">

                <div class="card-ponto">
                    <h3>Horas Trabalhadas</h3>
                    <p>160h</p>
                </div>

                <div class="card-ponto">
                    <h3>Horas Extras</h3>
                    <p>12h</p>
                </div>

                <div class="card-ponto">
                    <h3>Faltas</h3>
                    <p>1</p>
                </div>

            </div>

            <!-- FORMULÁRIO -->
            <div class="form-ponto">

                <h2>Registrar Ponto</h2>

                <form>

                    <div class="grid-ponto">

                        <div class="input-group">
                            <label>Funcionário</label>
                            <input type="text">
                        </div>

                        <div class="input-group">
                            <label>Data</label>
                            <input type="date">
                        </div>

                        <div class="input-group">
                            <label>Entrada</label>
                            <input type="time">
                        </div>

                        <div class="input-group">
                            <label>Saída</label>
                            <input type="time">
                        </div>

                    </div>

                    <button type="submit" class="btn-salvar-ponto">
                        Salvar Registro
                    </button>

                </form>

            </div>

            <!-- TABELA -->
            <div class="tabela-ponto">

                <h2>Registros de Ponto</h2>

                <table>

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Funcionário</th>
                            <th>Data</th>
                            <th>Entrada</th>
                            <th>Saída</th>
                            <th>Horas Extras</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>1</td>
                            <td>Gustavo Zanetti</td>
                            <td>14/05/2026</td>
                            <td>08:00</td>
                            <td>18:00</td>
                            <td>2h</td>

                            <td>

                                <button class="btn-editar">
                                    Editar
                                </button>

                                <button class="btn-excluir">
                                    Excluir
                                </button>

                            </td>

                        </tr>

                        <tr>

                            <td>2</td>
                            <td>Maria Silva</td>
                            <td>14/05/2026</td>
                            <td>09:00</td>
                            <td>17:00</td>
                            <td>0h</td>

                            <td>

                                <button class="btn-editar">
                                    Editar
                                </button>

                                <button class="btn-excluir">
                                    Excluir
                                </button>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>
</html>