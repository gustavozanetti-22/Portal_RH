<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Funcionários - MacosRH
    </title>

    <link rel="stylesheet" href="css/funcionarios.css">

</head>
<body>

    <div class="container">

        <div class="topo">

            <h1>
                Funcionários
            </h1>
<a href="relatorio_funcionarios.php" target="_blank" style="padding:10px 16px;background:#2563eb;color:white;border-radius:10px;text-decoration:none;font-weight:600;">Gerar Relatório PDF</a>

            <div class="acoes-topo">

                <a
                    href="dashboard.php"
                    class="btn-home"
                >
                    Página Inicial
                </a>


            </div>

        </div>

        <div class="card-form">

            <h2>
                Cadastro de Funcionários
            </h2>

            <form id="form-funcionario">

                <div class="grid-form">

                    <div class="input-group">

                        <label>
                            Nome
                        </label>

                        <input
                            type="text"
                            id="nome"
                            required
                        >

                    </div>

                    <div class="input-group">

                        <label>
                            CPF
                        </label>

                        <input
                            type="text"
                            id="cpf"
                            maxlength="14"
                            placeholder="000.000.000-00"
                            required
                        >

                    </div>

                    <div class="input-group">

                        <label>
                            Cargo
                        </label>

                        <input
                            type="text"
                            id="cargo"
                            required
                        >

                    </div>

                    <div class="input-group">

                        <label>
                            Salário
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            id="salario"
                            required
                        >

                    </div>

                    <div class="input-group">

                        <label>
                            Email
                        </label>

                        <input
                            type="email"
                            id="email"
                            required
                        >

                    </div>

                    <div class="input-group">

                        <label>
                            Data de admissão
                        </label>

                        <input
                            type="date"
                            id="data_admissao"
                            required
                        >

                    </div>

                    <div class="input-group">

                        <label>
                            Horário Entrada
                        </label>

                        <input
                            type="time"
                            id="horario_entrada"
                        >

                    </div>

                    <div class="input-group">

                        <label>
                            Horário Saída
                        </label>

                        <input
                            type="time"
                            id="horario_saida"
                        >

                    </div>

                </div>

                <button
                    type="submit"
                    class="btn-salvar"
                >
                    Salvar Funcionário
                </button>

            </form>

        </div>

        <div class="card-tabela">

            <h2>
                Lista de Funcionários
            </h2>

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>Nome</th>

                            <th>CPF</th>

                            <th>Cargo</th>

                            <th>Salário</th>

                            <th>Email</th>

                            <th>Admissão</th>

                            <th>Entrada</th>

                            <th>Saída</th>

                            <th>Ações</th>

                        </tr>

                    </thead>

                    <tbody id="tbody-funcionarios">

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <script src="js/funcionarios.js"></script>

</body>
</html>
