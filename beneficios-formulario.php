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

    <title>Editar Benefícios</title>

    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/beneficios.css">

</head>
<body>

<div class="dashboard">

    <div class="sidebar">

        <h2>MacosRH</h2> 
        <ul>

            <li>
                <a href="beneficios.php">Voltar</a>
            </li>


        </ul>


    </div>

    <div class="content">

        <div class="form-beneficios">

            <h1>Editar Benefícios</h1>

            <form id="formBeneficios">

                <div class="grid-beneficios">

                    <div class="input-group">

                        <label>Funcionário</label>

                        <input 
                            type="text"
                            id="funcionario"
                            disabled
                        >

                    </div>

                    <div class="input-group">

                        <label>Convênio Médico</label>

                        <select id="convenio">

                            <option>Sim</option>

                            <option>Não</option>

                        </select>

                    </div>

                    <div class="input-group">

                        <label>Vale Transporte</label>

                        <select id="valeTransporte">

                            <option>Sim</option>

                            <option>Não</option>

                        </select>

                    </div>

                    <div class="input-group">

                        <label>Vale Refeição</label>

                        <select id="valeRefeicao">

                            <option>Sim</option>

                            <option>Não</option>

                        </select>

                    </div>

                    <div class="input-group">

                        <label>Plano Odontológico</label>

                        <select id="odontologico">

                            <option>Sim</option>

                            <option>Não</option>

                        </select>

                    </div>

                </div>

                <button type="submit" class="btn-salvar">

                    Salvar

                </button>

            </form>

        </div>

    </div>

</div>

<script src="js/beneficios.js"></script>

</body>
</html>