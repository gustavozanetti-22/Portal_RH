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
</head>
<body>

    <div class="dashboard">

        <!-- MENU LATERAL -->
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
                    <a href="#">Férias</a>
                </li>

                <li>
                    <a href="#">Controle de Ponto</a>
                </li>

                <li>
                    <a href="#">Reembolsos</a>
                </li>

                <li>
                    <a href="logout.php">Sair</a>
                </li>

            </ul>

        </div>

        <!-- CONTEÚDO -->
        <div class="content">

            <div class="topo-funcionarios">

                <h1>Funcionários</h1>

                <button class="btn-cadastrar">
                    + Novo Funcionário
                </button>

            </div>

            <!-- FORMULÁRIO -->
            <div class="form-funcionario">

                <h2>Cadastrar Funcionário</h2>

                <form>

                    <div class="grid-form">

                        <div class="input-group">
                            <label>Nome</label>
                            <input type="text">
                        </div>

                        <div class="input-group">
                            <label>Email</label>
                            <input type="email">
                        </div>

                        <div class="input-group">
                            <label>Cargo</label>
                            <input type="text">
                        </div>

                        <div class="input-group">
                            <label>Salário</label>
                            <input type="number">
                        </div>

                    </div>

                    <button type="submit" class="btn-salvar">
                        Salvar Funcionário
                    </button>

                </form>

            </div>

            <!-- TABELA -->
            <div class="tabela-funcionarios">

                <h2>Lista de Funcionários</h2>

                <table>

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Cargo</th>
                            <th>Salário</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    <tbody>

                        <tr>
                            <td>1</td>
                            <td>Gustavo Zanetti</td>
                            <td>gustavo@email.com</td>
                            <td>Desenvolvedor</td>
                            <td>R$ 5.000</td>

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
                            <td>maria@email.com</td>
                            <td>RH</td>
                            <td>R$ 4.200</td>

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