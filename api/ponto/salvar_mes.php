<?php

include("../config/database.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data["pontos"]) || !is_array($data["pontos"])) {
    echo json_encode([
        "success" => false,
        "message" => "Nenhum ponto recebido"
    ]);
    exit;
}

$conn->begin_transaction();

try {

    $stmt = $conn->prepare(
        "INSERT INTO Ponto (
            funcionario_id,
            data_ponto,
            horario_entrada,
            horario_saida,
            atraso_minutos,
            hora_extra_minutos,
            valor_desconto,
            valor_extra,
            falta,
            falta_atestado,
            tipo_dia,
            observacoes
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            horario_entrada = VALUES(horario_entrada),
            horario_saida = VALUES(horario_saida),
            atraso_minutos = VALUES(atraso_minutos),
            hora_extra_minutos = VALUES(hora_extra_minutos),
            valor_desconto = VALUES(valor_desconto),
            valor_extra = VALUES(valor_extra),
            falta = VALUES(falta),
            falta_atestado = VALUES(falta_atestado),
            tipo_dia = VALUES(tipo_dia),
            observacoes = VALUES(observacoes)"
    );

    if (!$stmt) {
        throw new Exception($conn->error);
    }

    foreach ($data["pontos"] as $ponto) {

        $funcionario_id = (int) ($ponto["funcionario_id"] ?? 0);
        $data_ponto = $ponto["data_ponto"] ?? null;
        $horario_entrada = $ponto["horario_entrada"] ?? null;
        $horario_saida = $ponto["horario_saida"] ?? null;
        $atraso_minutos = (int) ($ponto["atraso_minutos"] ?? 0);
        $hora_extra_minutos = (int) ($ponto["hora_extra_minutos"] ?? 0);
        $valor_desconto = (float) ($ponto["valor_desconto"] ?? 0);
        $valor_extra = (float) ($ponto["valor_extra"] ?? 0);
        $falta = (int) ($ponto["falta"] ?? 0);
        $falta_atestado = (int) ($ponto["falta_atestado"] ?? 0);
        $tipo_dia = $ponto["tipo_dia"] ?? "normal";
        $observacoes = $ponto["observacoes"] ?? "";

        $stmt->bind_param(
            "isssiiddiiss",
            $funcionario_id,
            $data_ponto,
            $horario_entrada,
            $horario_saida,
            $atraso_minutos,
            $hora_extra_minutos,
            $valor_desconto,
            $valor_extra,
            $falta,
            $falta_atestado,
            $tipo_dia,
            $observacoes
        );

        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
    }

    $conn->commit();

    echo json_encode([
        "success" => true,
        "message" => "Ponto do mês salvo com sucesso"
    ]);

} catch (Exception $e) {

    $conn->rollback();

    echo json_encode([
        "success" => false,
        "message" => "Erro ao salvar ponto do mês",
        "erro" => $e->getMessage()
    ]);
}

?>
