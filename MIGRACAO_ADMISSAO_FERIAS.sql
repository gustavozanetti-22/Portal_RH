USE ads_3b_grupo14;

ALTER TABLE Funcionarios
ADD COLUMN data_admissao DATE NULL AFTER email;

ALTER TABLE Ferias
ADD COLUMN nunca_tirou_ferias TINYINT(1) DEFAULT 0 AFTER ferias_pagas;

-- Opcional: coloque uma data de admissão padrão para funcionários antigos.
-- Depois você pode editar pela tela de Funcionários.
UPDATE Funcionarios
SET data_admissao = COALESCE(data_admissao, CURDATE())
WHERE data_admissao IS NULL;
