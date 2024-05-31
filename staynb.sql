-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29-Maio-2024 às 02:23
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `clients`
--

CREATE TABLE `clients` (
  `id` bigint(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `CPF` varchar(14) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(250) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `client_properties`
--

CREATE TABLE `client_properties` (
  `id` bigint(11) UNSIGNED NOT NULL,
  `clientId` bigint(11) NOT NULL,
  `propertyId` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `collaborators`
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
-- Extraindo dados da tabela `collaborators`
--

INSERT INTO `collaborators` (`id`, `name`, `CPF`, `phone_number`, `email`, `is_admin`, `password`, `created_at`, `updated_at`) VALUES
(86, 'Muraro', '353535353', '2323232', 'muraro@bolas.com', 0, '$2y$15$qauabi5qnMKtpqBkUavigunO3zcz2363WbvmP0iMoOlAstfJDt1se', NULL, NULL),
(89, 'Muraro', '353523232335', '2323232', 'mur23232o@bolas.com', 0, '$2y$15$21jqCkhdRK8/5JQu7f7fieZfsyyHSbj/9.goo/rWxeLAxZoVkcb0K', NULL, NULL),
(109, 'Muraro', '35352323', '2323232', 'mur232o@bolas.com', 1, '$2y$15$7.FzK5eN/BmrZyUiyp1PnuaW7O5X0axSQygVjtJqJAmaPElHZgsSy', NULL, NULL),
(116, 'Muraro', '3535224242323', '2323232', '23@bolas.com', 1, '$2y$15$SZKHIfPH7tKMH31ewsJooe05hAu1ViOtKueyMcCPYc4s6IktaTUQC', NULL, NULL),
(118, 'Muraro', '35352243333242', '2323232', '23333333@bolas.com', 1, '$2y$15$t04hyDfT8kY7qpHLkI2MbuFgfHW/hbnGwrnUebWHGmH8/5b/g4.w.', NULL, NULL),
(121, 'Muraro', '351301', '2323232', 'MuraroTeste@bolas.com', 1, '$2y$15$CznUOMQz0759.xeLNLHv9eYvtri1y67vT01lUVeD2fPYNlegtIvWC', NULL, NULL),
(122, 'PAULO', '23425424242', '32323232', 'paulinho@gmail.com', 1, '$2y$15$froijj2IsrW/DmPnFDCmkerpacoSCoGmxAiaURKmlWaF1KXQ0sl1G', NULL, NULL),
(124, 'PAULO', '235434273', '523435', 'paulin2ho3334444333@gmail.com', 1, '$2y$15$4QPUO2QhRK9ZxDxVJs3JDOBSGpPjRGpJGMx8N9DI9.asaHAvmk2wu', NULL, NULL),
(126, 'PAULO', '235', '523435', 'paulin2ho@gmail.com', 1, '$2y$15$FtMd7N1vEG.1DLdCC5PFre3zxj1dZFr/Scea0ZSMBCITs8g.CxVnq', NULL, NULL),
(129, 'PAULO', '2357', '523435', 'pauli4n2ho@gmail.com', 1, '$2y$15$FZjxEWbZC3KHreSXvO.lJ.45QgWX8LGxGYtQ/BAOcSd55Vpl.EKju', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_03_31_012748_create_clients_table', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `properties`
--

CREATE TABLE `properties` (
  `id` bigint(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `CEP` varchar(10) NOT NULL,
  `neighborhood` int(11) NOT NULL,
  `number` int(5) NOT NULL,
  `complement` varchar(80) NOT NULL,
  `city` varchar(80) NOT NULL,
  `UF` varchar(2) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `client_properties`
--
ALTER TABLE `client_properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientId_fk` (`clientId`),
  ADD KEY `propertyId_fk` (`propertyId`);

--
-- Índices para tabela `collaborators`
--
ALTER TABLE `collaborators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `collaborators_cpf_unique` (`CPF`),
  ADD UNIQUE KEY `collaborators_email_unique` (`email`);

--
-- Índices para tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `client_properties`
--
ALTER TABLE `client_properties`
  MODIFY `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `collaborators`
--
ALTER TABLE `collaborators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `properties`
--
ALTER TABLE `properties`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `client_properties`
--
ALTER TABLE `client_properties`
  ADD CONSTRAINT `clientId_fk` FOREIGN KEY (`clientId`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `propertyId_fk` FOREIGN KEY (`propertyId`) REFERENCES `properties` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
