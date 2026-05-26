USE ads_3b_grupo14;

-- Rode este arquivo uma vez no MySQL Workbench.
-- Ele NÃO apaga nada. Só acrescenta campos/chaves necessários.

ALTER TABLE Funcionarios
ADD COLUMN data_admissao DATE NULL AFTER email;

ALTER TABLE Ferias
ADD COLUMN nunca_tirou_ferias TINYINT(1) DEFAULT 0 AFTER ferias_pagas;

ALTER TABLE Ferias
ADD UNIQUE KEY unico_funcionario_ferias (funcionario_id);

UPDATE Funcionarios
SET data_admissao = COALESCE(data_admissao, CURDATE())
WHERE data_admissao IS NULL;
