<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

$id = $_GET["id"] ?? 0;
$nome = $_GET["nome"] ?? "funcionário";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Exclusão - MacosRH</title>
    <link rel="stylesheet" href="css/funcionarios.css">
</head>
<body>

    <div class="container">

        <div class="topo">
            <h1>Confirmar exclusão</h1>

            <div class="acoes-topo">
                <a href="funcionarios.php" class="btn-home">Voltar</a>
            </div>
        </div>

        <div class="card-form card-exclusao">

            <h2>Credenciais obrigatórias</h2>

            <p class="texto-exclusao">
                Para excluir <strong><?php echo htmlspecialchars($nome); ?></strong>,
                informe o email e a senha de login cadastrados no banco de dados.
            </p>

            <form id="form-exclusao">

                <input type="hidden" id="funcionario_id" value="<?php echo htmlspecialchars($id); ?>">

                <div class="grid-form">

                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" id="email_credencial" required>
                    </div>

                    <div class="input-group">
                        <label>Senha</label>
                        <input type="password" id="senha_credencial" required>
                    </div>

                </div>

                <button type="submit" class="btn-salvar">
                    Validar e excluir
                </button>

            </form>

        </div>

    </div>

    <script>
        const form = document.getElementById("form-exclusao");

        form.addEventListener("submit", async function(e) {
            e.preventDefault();

            const id = document.getElementById("funcionario_id").value;
            const email = document.getElementById("email_credencial").value;
            const senha = document.getElementById("senha_credencial").value;

            try {
                const responseValidacao = await fetch("api/funcionarios/validar_credenciais.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        email: email,
                        senha: senha
                    })
                });

                const validacao = await responseValidacao.json();

                if (!validacao.success) {
                    alert(validacao.message || "Credenciais inválidas.");
                    return;
                }

                const confirmar = confirm("Tem certeza que deseja excluir o funcionário?");

                if (!confirmar) {
                    window.location.href = "funcionarios.php";
                    return;
                }

                const responseExcluir = await fetch("api/funcionarios/deletar.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        id: id,
                        email: email,
                        senha: senha
                    })
                });

                const resultado = await responseExcluir.json();

                if (!resultado.success) {
                    alert(resultado.message + "\n" + (resultado.erro || ""));
                    return;
                }

                alert("Funcionário excluído com sucesso");
                window.location.href = "funcionarios.php";

            } catch (error) {
                console.error(error);
                alert("Erro ao validar credenciais ou excluir funcionário.");
            }
        });
    </script>

</body>
</html>
