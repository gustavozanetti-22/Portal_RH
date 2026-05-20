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

    <title>Funcionário</title>

    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/funcionarios.css">

</head>
<body>

    <div class="dashboard">

        <div class="sidebar">

            <h2>MacosTech</h2>

        </div>

        <div class="content">

            <div class="form-funcionario">

                <h1>Cadastro de Funcionário</h1>

                <form id="formFuncionario">

                    <div class="grid-funcionarios">

                        <div class="input-group">

                            <label>Nome</label>

                            <input 
                                type="text"
                                id="nome"
                                required
                            >

                        </div>

                        <div class="input-group">

                            <label>Cargo</label>

                            <input 
                                type="text"
                                id="cargo"
                                required
                            >

                        </div>

                        <div class="input-group">

                            <label>Salário</label>

                            <input 
                                type="number"
                                id="salario"
                                required
                            >

                        </div>

                        <div class="input-group">

                            <label>Email</label>

                            <input 
                                type="email"
                                id="email"
                                required
                            >

                        </div>

                    </div>

                    <button type="submit" class="btn-funcionario">

                        Salvar Funcionário

                    </button>

                </form>

            </div>

        </div>

    </div>

    <script src="js/funcionarios.js"></script>

</body>
</html>