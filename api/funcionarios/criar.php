<?php

include("../config/database.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "Nenhum dado chegou na API"
    ]);
    exit;
}

$nome = trim($data["nome"] ?? "");
$cpf = preg_replace('/\D/', '', $data["cpf"] ?? "");
$cargo = trim($data["cargo"] ?? "");
$salario = $data["salario"] ?? 0;
$email = trim($data["email"] ?? "");
$data_admissao = $data["data_admissao"] ?? null;
$horario_entrada = $data["horario_entrada"] ?? null;
$horario_saida = $data["horario_saida"] ?? null;

if ($nome === "" || $cpf === "" || $cargo === "" || $email === "") {
    echo json_encode([
        "success" => false,
        "message" => "Preencha todos os campos obrigatórios."
    ]);
    exit;
}

if (strlen($cpf) !== 11) {
    echo json_encode([
        "success" => false,
        "message" => "CPF inválido. Informe 11 números."
    ]);
    exit;
}

$stmtVerifica = $conn->prepare(
    "SELECT id FROM Funcionarios WHERE cpf = ?"
);

if (!$stmtVerifica) {
    echo json_encode([
        "success" => false,
        "message" => "Erro ao verificar CPF",
        "erro" => $conn->error
    ]);
    exit;
}

$stmtVerifica->bind_param("s", $cpf);
$stmtVerifica->execute();

$resultadoCpf = $stmtVerifica->get_result();

if ($resultadoCpf->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "message" => "Esse CPF já está cadastrado"
    ]);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO Funcionarios (
        nome,
        cpf,
        cargo,
        salario,
        email,
        data_admissao,
        horario_entrada,
        horario_saida
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Erro no prepare SQL",
        "erro" => $conn->error
    ]);
    exit;
}

$stmt->bind_param(
    "sssdssss",
    $nome,
    $cpf,
    $cargo,
    $salario,
    $email,
    $data_admissao,
    $horario_entrada,
    $horario_saida
);

if (!$stmt->execute()) {
    echo json_encode([
        "success" => false,
        "message" => "Erro ao inserir funcionário",
        "erro" => $stmt->error
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "message" => "Funcionário cadastrado com sucesso"
]);

?>
