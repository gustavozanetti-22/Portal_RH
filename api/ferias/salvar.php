<?php

include("../config/database.php");

$data = json_decode(
    file_get_contents("php://input"),
    true
);

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "Nenhum dado recebido."
    ]);
    exit;
}

$funcionario_id = $data["funcionario_id"] ?? 0;
$ultima_feria = ($data["ultima_feria"] ?? "") ?: null;
$proxima_feria = ($data["proxima_feria"] ?? "") ?: null;
$data_saida = ($data["data_saida"] ?? "") ?: null;
$retorno_ferias = ($data["retorno_ferias"] ?? "") ?: null;
$vendeu_10_dias = $data["vendeu_10_dias"] ?? 0;
$ferias_pagas = $data["ferias_pagas"] ?? 0;
$nunca_tirou_ferias = $data["nunca_tirou_ferias"] ?? 0;
$observacoes = $data["observacoes"] ?? "";

$verifica = $conn->prepare(
    "SELECT id FROM Ferias WHERE funcionario_id = ?"
);

if (!$verifica) {
    echo json_encode([
        "success" => false,
        "message" => "Erro ao verificar férias.",
        "erro" => $conn->error
    ]);
    exit;
}

$verifica->bind_param("i", $funcionario_id);
$verifica->execute();

$resultado = $verifica->get_result();

if ($resultado->num_rows > 0) {

    $stmt = $conn->prepare(
        "UPDATE Ferias SET
            ultima_feria = ?,
            proxima_feria = ?,
            data_saida = ?,
            retorno_ferias = ?,
            vendeu_10_dias = ?,
            ferias_pagas = ?,
            nunca_tirou_ferias = ?,
            observacoes = ?
        WHERE funcionario_id = ?"
    );

    if (!$stmt) {
        echo json_encode([
            "success" => false,
            "message" => "Erro no SQL de atualização.",
            "erro" => $conn->error
        ]);
        exit;
    }

    $stmt->bind_param(
        "ssssiiisi",
        $ultima_feria,
        $proxima_feria,
        $data_saida,
        $retorno_ferias,
        $vendeu_10_dias,
        $ferias_pagas,
        $nunca_tirou_ferias,
        $observacoes,
        $funcionario_id
    );

} else {

    $stmt = $conn->prepare(
        "INSERT INTO Ferias (
            funcionario_id,
            ultima_feria,
            proxima_feria,
            data_saida,
            retorno_ferias,
            vendeu_10_dias,
            ferias_pagas,
            nunca_tirou_ferias,
            observacoes
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        echo json_encode([
            "success" => false,
            "message" => "Erro no SQL de cadastro.",
            "erro" => $conn->error
        ]);
        exit;
    }

    $stmt->bind_param(
        "issssiiis",
        $funcionario_id,
        $ultima_feria,
        $proxima_feria,
        $data_saida,
        $retorno_ferias,
        $vendeu_10_dias,
        $ferias_pagas,
        $nunca_tirou_ferias,
        $observacoes
    );

}

if (!$stmt->execute()) {
    echo json_encode([
        "success" => false,
        "message" => "Erro ao salvar férias.",
        "erro" => $stmt->error
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "message" => "Férias salvas com sucesso."
]);

?>