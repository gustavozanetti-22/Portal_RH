<?php

include("../config/database.php");

$data = json_decode(file_get_contents("php://input"), true);

$email = trim($data["email"] ?? "");
$senha = trim($data["senha"] ?? "");

if ($email === "" || $senha === "") {
    echo json_encode([
        "success" => false,
        "message" => "Informe email e senha."
    ]);
    exit;
}

$stmt = $conn->prepare(
    "SELECT id, senha FROM Usuarios WHERE email = ?"
);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Erro ao validar credenciais",
        "erro" => $conn->error
    ]);
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "Email ou senha inválidos."
    ]);
    exit;
}

$usuario = $resultado->fetch_assoc();

if (trim($usuario["senha"]) !== $senha) {
    echo json_encode([
        "success" => false,
        "message" => "Email ou senha inválidos."
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "message" => "Credenciais validadas com sucesso."
]);

?>
