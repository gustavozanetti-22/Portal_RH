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

    <title>Editar Férias</title>

    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/ferias.css">

</head>
<body>

<div class="dashboard">

    <div class="sidebar">

        <h2>MacosTech</h2>

        <ul>

            <li>
                <a href="ferias.php">Voltar</a>
            </li>

        </ul>


    </div>

    <div class="content">

        <div class="form-ferias">

            <h1>Editar Férias</h1>

            <form id="formFerias">

                <div class="grid-ferias">

                    <div class="input-group">

                        <label>Funcionário</label>

                        <input 
                            type="text"
                            id="funcionario"
                            disabled
                        >

                    </div>

                    <div class="input-group">

                        <label>Últimas férias</label>

                        <input 
                            type="date"
                            id="ultimaFerias"
                        >

                    </div>

                    <div class="input-group">

                        <label>Saída férias</label>

                        <input 
                            type="date"
                            id="saidaFerias"
                        >

                    </div>

                    <div class="input-group">

                        <label>Vendeu 10 dias?</label>

                        <select id="vendeuDias">

                            <option>Não</option>

                            <option>Sim</option>

                        </select>

                    </div>

                    <div class="input-group">

                        <label>Férias pagas?</label>

                        <select id="feriasPagas">

                            <option>Não</option>

                            <option>Sim</option>

                        </select>

                    </div>

                </div>

                <button type="submit" class="btn-ferias">

                    Salvar

                </button>

            </form>

        </div>

    </div>

</div>

<script src="js/ferias.js"></script>

</body>
</html>