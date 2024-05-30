-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 29/05/2024 às 02:36
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `staynb`
--
CREATE DATABASE IF NOT EXISTS `staynb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `staynb`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `CPF` varchar(14) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `clients`
--

INSERT INTO `clients` (`id`, `name`, `CPF`, `phone_number`, `email`) VALUES
(3, 'paulo', '57867478833', '15997840494', 'paulo3@gmail.com'),
(16, 'paulo', '51267478839', '15997840494', 'paulo3@gcail.com'),
(17, 'paulo', '11267478839', '15997840494', 'paulo3@gaail.com'),
(18, 'paulo', '11267478831', '15997840494', 'paulo3@gzail.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `collaborators`
--

CREATE TABLE `collaborators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `CPF` varchar(14) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(250) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `password` varchar(250) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `collaborators`
--

INSERT INTO `collaborators` (`id`, `name`, `CPF`, `phone_number`, `email`, `is_admin`, `password`, `created_at`, `updated_at`) VALUES
(5, 'Pedro Santos', '999.888.777-66', '31987654321', 'pedro.santos@example.compp', 0, 'senha345', '2024-05-27 02:30:43', '2024-05-27 02:30:43'),
(6, 'Lucia Carvalho', '444.333.222-11', '31912345678', 'lucia.carvalho@example.com', 1, 'senha678', '2024-05-27 02:30:43', '2024-05-27 02:30:43'),
(7, 'Fernando Lima', '777.888.999-00', '41987654321', 'fernando.lima@example.com', 0, 'senha901', '2024-05-27 02:30:43', '2024-05-27 02:30:43'),
(8, 'Beatriz Costa', '222.111.000-33', '41912345678', 'beatriz.costa@example.com', 0, 'senha234', '2024-05-27 02:30:43', '2024-05-27 02:30:43'),
(9, 'Ricardo Mendes', '666.555.444-22', '51987654321', 'ricardo.mendes@example.com', 1, 'senha567', '2024-05-27 02:30:43', '2024-05-27 02:30:43'),
(10, 'Claudia Azevedo', '333.222.111-00', '51912345678', 'claudia.azevedo@example.com', 0, 'senha890', '2024-05-27 02:30:43', '2024-05-27 02:30:43'),
(141, 'jsdjsjs', '987.654.321-99', '15997840494', 'paulo@jjddjjd.com', 1, '$2y$15$ChLM4ypAWD3eQWx5Q33K8Ov2ezmAcQIEKldJBzNt3TV/Kf4z4aiyK', NULL, NULL),
(162, 'jsdjsjs', '987.654.321-91', '15997840494', 'paulo@jjdjjd.com', 1, '$2y$15$6C0c9HOPnj.kmQI4ncQwj.PzIMuVhl7XfnIlMO2osSmGSa9RtQdym', NULL, NULL),
(163, 'jsdjsjs', '987.654.321-92', '15997840494', 'paulo@jdjjd.com', 1, '$2y$15$4mkf.GyCMI1c0625msv83uKGlhHHecQoN/5T2GqNetM7bwfoy0w.6', NULL, NULL),
(164, 'jsdjsjs', '987.624.321-92', '15997840494', 'paulo@jadjjd.com', 1, '$2y$15$cjlVUy7pqpKaWXPwuQq/8uLy2N0SgvCU9CZNnmNNVPJtKEEoBMqbi', NULL, NULL),
(165, 'jsdjsjs', '987.624.321-95', '15997840494', 'paulo@jadjjda.com', 1, '$2y$15$qiLS/5p9cmVbcXX7kMSmL.thV6Jq3NHcdTPwYy031LkPCA4NvGzm6', NULL, NULL),
(166, 'huhuhuh', '109.283.746-22', '998738493', 'tetetetetetet@gmail.com', 1, '$2y$15$frF8FO9mbWrfY1H0JvfdxufbQA3cJs/87F8jrgFwwOQgVjjzogND.', NULL, NULL),
(167, 'huhuhuh', '109.283.746-21', '998738493', 'tetetetetet@gmail.com', 1, '$2y$15$fIgdI4JclrMS.WlrjWJ4I.alpcEHUMYRVwrx/nXezpPDlRP0VH8gW', NULL, NULL),
(169, 'huhuhuh', '109.283.746-26', '998738493', 'teetetet@gmail.com', 0, '$2y$15$2F78RQB5jsHThUoS1nD1Hu.aPfuG3GnWZe6NoIMtqcOXlFTFMyLpO', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `CPF` (`CPF`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `collaborators`
--
ALTER TABLE `collaborators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `collaborators_cpf_unique` (`CPF`),
  ADD UNIQUE KEY `collaborators_email_unique` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `collaborators`
--
ALTER TABLE `collaborators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

