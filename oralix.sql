-- Dump do banco de dados para ORALIX
-- Criado para importação no phpMyAdmin

CREATE DATABASE IF NOT EXISTS `oralix` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `oralix`;

-- Tabela de unidades de saúde (UBS) - opcional
CREATE TABLE IF NOT EXISTS `ubs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `endereco` VARCHAR(255) DEFAULT NULL,
  `telefone` VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `cpf` VARCHAR(20) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `tipo` ENUM('cidadao','ubs','admin') NOT NULL DEFAULT 'cidadao',
  `ubs_id` INT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf_unico` (`cpf`),
  KEY `idx_ubs_id` (`ubs_id`),
  CONSTRAINT `fk_usuarios_ubs` FOREIGN KEY (`ubs_id`) REFERENCES `ubs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados de teste para login conforme comentado no código
INSERT INTO `usuarios` (`nome`, `cpf`, `senha`, `email`, `tipo`, `ubs_id`) VALUES
('Usuário Cidadão', '11111111111', '123456', 'cidadao@example.com', 'cidadao', NULL),
('Usuário UBS', '22222222222', '123456', 'ubs@example.com', 'ubs', NULL),
('Administrador', '00000000000', '123456', 'admin@example.com', 'admin', NULL);

-- Exemplo de UBS (opcional)
INSERT INTO `ubs` (`nome`, `endereco`, `telefone`) VALUES
('UBS Central', 'Rua das Flores, 123', '(11) 1234-5678');

-- Atualiza referência ubs_id do usuário UBS para a UBS criada
UPDATE `usuarios` SET `ubs_id` = (SELECT `id` FROM `ubs` WHERE `nome` = 'UBS Central' LIMIT 1) WHERE `cpf` = '22222222222';

-- Fim do dump
