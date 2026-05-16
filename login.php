<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - RH Digital</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="login-container">

        <form class="login-box" action="php/login_action.php" method="POST">

            <h1>Login</h1>

            <?php
            if(isset($_GET['erro'])){
                echo "<p class='erro'>Email ou senha inválidos</p>";
            }
            ?>

            <div class="input-group">

                <label>Email</label>

                <input 
                    type="email" 
                    name="email" 
                    placeholder="Digite seu email"
                    required
                >

            </div>

            <div class="input-group">

                <label>Senha</label>

                <input 
                    type="password" 
                    name="senha" 
                    placeholder="Digite sua senha"
                    required
                >

            </div>

            <button type="submit" class="btn-login">
                Entrar
            </button>

            <a href="index.php" class="voltar">
                ← Voltar
            </a>

        </form>

    </div>

</body>
</html>