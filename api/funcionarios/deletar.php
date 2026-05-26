<?php

include("../config/database.php");

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"] ?? 0;
$email = trim($data["email"] ?? "");
$senha = trim($data["senha"] ?? "");

if (!$id || $email === "" || $senha === "") {
    echo json_encode([
        "success" => false,
        "message" => "Dados incompletos para exclusão."
    ]);
    exit;
}

$stmtUsuario = $conn->prepare(
    "SELECT id, senha FROM Usuarios WHERE email = ?"
);

if (!$stmtUsuario) {
    echo json_encode([
        "success" => false,
        "message" => "Erro ao validar credenciais",
        "erro" => $conn->error
    ]);
    exit;
}

$stmtUsuario->bind_param("s", $email);
$stmtUsuario->execute();

$resultadoUsuario = $stmtUsuario->get_result();

if ($resultadoUsuario->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "Email ou senha inválidos."
    ]);
    exit;
}

$usuario = $resultadoUsuario->fetch_assoc();

if (trim($usuario["senha"]) !== $senha) {
    echo json_encode([
        "success" => false,
        "message" => "Email ou senha inválidos."
    ]);
    exit;
}

$stmt = $conn->prepare(
    "DELETE FROM Funcionarios WHERE id = ?"
);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Erro ao preparar exclusão",
        "erro" => $conn->error
    ]);
    exit;
}

$stmt->bind_param("i", $id);

if (!$stmt->execute()) {
    echo json_encode([
        "success" => false,
        "message" => "Erro ao excluir funcionário",
        "erro" => $stmt->error
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "message" => "Funcionário excluído com sucesso"
]);

?>
