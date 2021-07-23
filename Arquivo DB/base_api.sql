-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23-Jul-2021 às 04:41
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `base_api`
--
CREATE DATABASE IF NOT EXISTS `base_api` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `base_api`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `embarcador`
--

CREATE TABLE `embarcador` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `doc` varchar(20) NOT NULL,
  `about` varchar(250) NOT NULL,
  `active` enum('true','false') NOT NULL,
  `site` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `embarcador`
--

INSERT INTO `embarcador` (`id`, `name`, `doc`, `about`, `active`, `site`) VALUES
(1, 'goFlux Brasil', '60.429.484/0001-10', 'goFlux, uma empresa especializada em inovar na contratação de fretes', 'true', 'https://goflux.com.br/'),
(2, 'Embarcador A', '88.888.140/0001-60', 'Embarcador sito à rua B', 'true', 'www.google.com'),
(3, 'Embarcador B', '88.888.140/0001-60', 'Embarcador sito à rua A', 'true', 'www.google.com');

-- --------------------------------------------------------

--
-- Estrutura da tabela `lance`
--

CREATE TABLE `lance` (
  `id_provider` int(11) NOT NULL,
  `id_offer` int(11) NOT NULL,
  `value` float NOT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `lance`
--

INSERT INTO `lance` (`id_provider`, `id_offer`, `value`, `amount`) VALUES
(12, 1, 105, 230),
(12, 5, 1000, 35),
(12, 6, 1500, 35);

-- --------------------------------------------------------

--
-- Estrutura da tabela `oferta`
--

CREATE TABLE `oferta` (
  `id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `_from` varchar(150) NOT NULL,
  `_to` varchar(150) NOT NULL,
  `initial_value` float NOT NULL,
  `amount` float NOT NULL,
  `amount_type` enum('TON','KG','L','M2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `oferta`
--

INSERT INTO `oferta` (`id`, `id_customer`, `_from`, `_to`, `initial_value`, `amount`, `amount_type`) VALUES
(1, 1, 'Porto Alegre - RS', 'São Paulo - SP', 130, 30, 'TON'),
(2, 3, 'São Bernardo do Campo - SP', 'Aracaju - SE', 100, 10, 'KG');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tokens_autorizados`
--

CREATE TABLE `tokens_autorizados` (
  `id` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `status` enum('S','N') NOT NULL DEFAULT 'S'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tokens_autorizados`
--

INSERT INTO `tokens_autorizados` (`id`, `token`, `status`) VALUES
(1, 'dG9rZW5nZXJhZG8==', 'S');

-- --------------------------------------------------------

--
-- Estrutura da tabela `transportador`
--

CREATE TABLE `transportador` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `doc` varchar(20) NOT NULL,
  `about` varchar(250) NOT NULL,
  `active` enum('true','false') CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `site` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `transportador`
--

INSERT INTO `transportador` (`id`, `name`, `doc`, `about`, `active`, `site`) VALUES
(1, 'Transportadora Rodoclub', '99.974.145/0001-50', 'Transportadora Rodoclub, transportando sonhos', 'true', 'https://goflux.com.br/'),
(2, 'Transportadora X', '99.999.145/0001-60', 'Transportadora sito à rua Y', 'true', 'www.google.com'),
(3, 'Transportadora Y', '88.888.140/0001-60', 'Transportadora sito à rua Z', 'true', 'www.google.com'),
(4, 'Transportadora Z', '88.888.140/0001-60', 'Transportadora sito à rua A', 'true', 'www.google.com');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `login`, `senha`) VALUES
(1, 'ricardo', '123'),
(2, 'nomeUser', 'senhaUser'),
(3, 'nomeUser2', 'senhaUser2'),
(4, 'nomeUser3', 'senhaUser3'),
(5, 'nomeUser4', 'senhaUser4');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `embarcador`
--
ALTER TABLE `embarcador`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `oferta`
--
ALTER TABLE `oferta`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tokens_autorizados`
--
ALTER TABLE `tokens_autorizados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token_UNIQUE` (`token`);

--
-- Índices para tabela `transportador`
--
ALTER TABLE `transportador`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `embarcador`
--
ALTER TABLE `embarcador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `oferta`
--
ALTER TABLE `oferta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tokens_autorizados`
--
ALTER TABLE `tokens_autorizados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `transportador`
--
ALTER TABLE `transportador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
