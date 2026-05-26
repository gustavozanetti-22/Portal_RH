<?php

include("../config/database.php");

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $conn->prepare(
    "UPDATE Funcionarios SET
        nome = ?,
        cargo = ?,
        salario = ?,
        email = ?,
        data_admissao = ?,
        horario_entrada = ?,
        horario_saida = ?
    WHERE id = ?"
);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Erro no SQL",
        "erro" => $conn->error
    ]);
    exit;
}

$stmt->bind_param(
    "ssdssssi",
    $data["nome"],
    $data["cargo"],
    $data["salario"],
    $data["email"],
    $data["data_admissao"],
    $data["horario_entrada"],
    $data["horario_saida"],
    $data["id"]
);

if (!$stmt->execute()) {
    echo json_encode([
        "success" => false,
        "message" => "Erro ao atualizar funcionário",
        "erro" => $stmt->error
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "message" => "Funcionário atualizado com sucesso"
]);

?>
