-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08-Jun-2024 às 02:17
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
-- Estrutura da tabela `amenities`
--

CREATE TABLE `amenities` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `amenities`
--

INSERT INTO `amenities` (`id`, `name`) VALUES
(1, 'Cama de casal'),
(2, 'Cama de solteiro'),
(3, 'Ar condicionado'),
(4, 'Aquecimento'),
(5, 'Wi-Fi'),
(6, 'Estacionamento gratuito'),
(7, 'Cozinha'),
(8, 'Máquina de lavar roupa'),
(9, 'Secadora'),
(10, 'Televisão'),
(11, 'Ferro de passar roupa'),
(12, 'Secador de cabelo'),
(13, 'Produtos de higiene pessoal gratuitos'),
(14, 'Jacuzzi'),
(15, 'Piscina'),
(16, 'Churrasqueira'),
(17, 'Varanda'),
(18, 'Academia'),
(19, 'Vista para o mar'),
(20, 'Berço'),
(21, 'Elevador'),
(22, 'Permitido animais de estimação'),
(23, 'Detector de fumaça'),
(24, 'Detector de monóxido de carbono'),
(25, 'Kit de primeiros socorros'),
(26, 'Extintor de incêndio'),
(27, 'Check-in 24 horas'),
(28, 'Guarda-chuva'),
(29, 'Lençóis e toalhas'),
(30, 'Roupa de cama extra'),
(31, 'Entrada privativa'),
(32, 'Cafeteira'),
(33, 'Micro-ondas'),
(34, 'Forno'),
(35, 'Lava-louças'),
(36, 'Utensílios de cozinha'),
(37, 'Pratos e talheres'),
(38, 'Geladeira'),
(39, 'Freezer'),
(40, 'Toalhas de piscina'),
(41, 'Livros e brinquedos infantis'),
(42, 'Jogos de tabuleiro'),
(43, 'Área de trabalho para laptop'),
(44, 'Quintal ou jardim'),
(45, 'Terraço'),
(46, 'Lareira'),
(47, 'Acessível para cadeirantes'),
(48, 'Banheira'),
(49, 'Banheiro privativo'),
(50, 'Check-in e check-out sem contato'),
(51, 'Espaço para eventos'),
(52, 'Espaço de coworking'),
(53, 'Serviço de limpeza'),
(54, 'Alarme de segurança'),
(55, 'Câmeras de segurança na propriedade'),
(56, 'Câmeras de segurança na entrada'),
(57, 'Cofre'),
(58, 'Espaço para guardar bicicletas'),
(59, 'Prancha de surf/stand-up paddle'),
(60, 'Equipamento de mergulho'),
(61, 'Área para piquenique'),
(62, 'Mesa de bilhar'),
(63, 'Ping-pong'),
(64, 'Videogame'),
(65, 'Proximidade de transporte público'),
(66, 'Próximo a atrações turísticas'),
(67, 'Bicicletas disponíveis'),
(68, 'Bar'),
(69, 'Restaurante no local'),
(70, 'Serviço de quarto'),
(71, 'Concierge'),
(72, 'Transfer do aeroporto'),
(73, 'Cadeirinha de bebê'),
(74, 'Banheira para bebê'),
(75, 'Cama dobrável'),
(76, 'Água filtrada'),
(77, 'Aparelho de som'),
(78, 'Blackout nas cortinas'),
(79, 'Espelho de corpo inteiro'),
(80, 'Roupão de banho'),
(81, 'Pantufas'),
(82, 'Ventilador de teto'),
(83, 'Despertador'),
(84, 'Comida e bebida de boas-vindas'),
(85, 'Vista para a montanha'),
(86, 'Vista para a cidade'),
(87, 'Proibido fumar'),
(88, 'Acessibilidade para idosos'),
(89, 'Quarto à prova de som'),
(90, 'Espaço para massagem'),
(91, 'Sauna'),
(92, 'Estação de recarga para veículos elétricos'),
(93, 'Máquina de gelo'),
(94, 'Smart TV'),
(95, 'Apple TV'),
(96, 'Chromecast'),
(97, 'Sistema de som surround'),
(98, 'Projetor e tela de projeção'),
(99, 'Mesa de jantar'),
(100, 'Máquina de café espresso'),
(101, 'Tábua de passar roupa'),
(102, 'Suporte para bagagens'),
(103, 'Toalhas de praia'),
(104, 'Pranchas de snowboard/esqui'),
(105, 'Suporte para pranchas de surf'),
(106, 'Cercadinho para bebê'),
(107, 'Espaço para meditação'),
(108, 'Biblioteca'),
(109, 'Netflix'),
(110, 'Amazon Prime Video'),
(111, 'Hulu'),
(112, 'Disney+'),
(113, 'Playground'),
(114, 'Praia privativa'),
(115, 'Espaço gourmet'),
(116, 'Forno a lenha'),
(117, 'Rooftop'),
(118, 'Hidromassagem'),
(119, 'Massagem a domicílio'),
(120, 'Serviço de compras'),
(121, 'Acesso à praia'),
(122, 'Acesso ao rio'),
(123, 'Acesso ao lago'),
(124, 'Equipamento de pesca'),
(125, 'Trilhas de caminhada'),
(126, 'Quadra de tênis'),
(127, 'Quadra de basquete'),
(128, 'Campo de futebol'),
(129, 'Campo de golfe'),
(130, 'Aula de ioga'),
(131, 'Aula de pilates'),
(132, 'Aula de dança'),
(133, 'Aula de culinária'),
(134, 'Passeios guiados'),
(135, 'Tour de vinícolas'),
(136, 'Aluguel de caiaques'),
(137, 'Aluguel de barcos'),
(138, 'Passeio de helicóptero'),
(139, 'Passeio de balão'),
(140, 'Observação de pássaros'),
(141, 'Observação de estrelas'),
(142, 'Mergulho com cilindro'),
(143, 'Mergulho livre'),
(144, 'Snorkeling'),
(145, 'Windsurf'),
(146, 'Kitesurf'),
(147, 'Parapente'),
(148, 'Paraquedismo'),
(149, 'Observação de baleias'),
(150, 'Passeio de cavalo'),
(151, 'Safari'),
(152, 'Tirolesa'),
(153, 'Arvorismo'),
(154, 'Jardim de infância'),
(155, 'Babá a domicílio'),
(156, 'Porteiro'),
(157, 'Controle de temperatura'),
(158, 'Tapetes antialérgicos'),
(159, 'Estacionamento coberto'),
(160, 'Espaço de camping'),
(161, 'Estacionamento para trailers');

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

--
-- Extraindo dados da tabela `clients`
--

INSERT INTO `clients` (`id`, `name`, `CPF`, `phone_number`, `email`, `created_at`, `updated_at`) VALUES
(1, 'casa', '134124121', '421541251', 'paulo@paulo.paulo', NULL, NULL);

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
(121, 'Muraro', '351301', '2323232', 'MuraroTeste@gmail.com', 1, '$2y$15$3tj8ukeDKfiYNnh8yaubbOtt80Hvso2MKWJEvQzoHqJwqisgAkG2u', NULL, NULL);

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
  `neighborhood` varchar(80) NOT NULL,
  `address_number` varchar(11) NOT NULL,
  `complement` varchar(80) NOT NULL,
  `city` varchar(80) NOT NULL,
  `UF` varchar(2) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `properties_amenities`
--

CREATE TABLE `properties_amenities` (
  `id` bigint(20) NOT NULL,
  `propertyId` bigint(20) NOT NULL,
  `amenityId` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

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
-- Índices para tabela `properties_amenities`
--
ALTER TABLE `properties_amenities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `propertiesId_fk` (`propertyId`),
  ADD KEY `amenitiesId_fk` (`amenityId`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT de tabela `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `client_properties`
--
ALTER TABLE `client_properties`
  MODIFY `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `properties_amenities`
--
ALTER TABLE `properties_amenities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `client_properties`
--
ALTER TABLE `client_properties`
  ADD CONSTRAINT `clientId_fk` FOREIGN KEY (`clientId`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `propertyId_fk` FOREIGN KEY (`propertyId`) REFERENCES `properties` (`id`);

--
-- Limitadores para a tabela `properties_amenities`
--
ALTER TABLE `properties_amenities`
  ADD CONSTRAINT `amenitiesId_fk` FOREIGN KEY (`amenityId`) REFERENCES `amenities` (`id`),
  ADD CONSTRAINT `propertiesId_fk` FOREIGN KEY (`propertyId`) REFERENCES `properties` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
