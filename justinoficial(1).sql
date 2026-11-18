-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22-Jul-2026 às 21:17
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
-- Banco de dados: `justinoficial`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','completed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `status`) VALUES
(1, 7, '2026-07-21 23:06:27', 'completed'),
(2, 7, '2026-07-21 23:09:06', 'completed'),
(3, 7, '2026-07-21 23:15:18', 'completed'),
(4, 7, '2026-07-21 23:39:54', 'completed'),
(5, 7, '2026-07-22 00:06:39', 'completed'),
(6, 10, '2026-07-22 00:19:54', 'completed'),
(7, 7, '2026-07-22 00:34:07', 'completed'),
(8, 7, '2026-07-22 00:34:20', 'pending'),
(9, 7, '2026-07-22 00:34:26', 'pending'),
(10, 7, '2026-07-22 00:34:44', 'completed'),
(11, 7, '2026-07-22 00:35:58', 'pending'),
(12, 7, '2026-07-22 00:36:43', 'pending'),
(13, 7, '2026-07-22 00:37:05', 'completed'),
(14, 10, '2026-07-22 00:37:42', 'pending'),
(15, 7, '2026-07-22 00:46:06', 'pending'),
(16, 7, '2026-07-22 00:46:50', 'pending'),
(17, 7, '2026-07-22 00:47:33', 'pending'),
(18, 7, '2026-07-22 00:47:42', 'pending'),
(19, 7, '2026-07-22 00:47:49', 'pending'),
(20, 7, '2026-07-22 00:47:54', 'pending'),
(21, 7, '2026-07-22 00:55:31', 'pending'),
(22, 7, '2026-07-22 00:55:39', 'pending'),
(23, 7, '2026-07-22 00:56:38', 'pending'),
(24, 7, '2026-07-22 00:56:38', 'pending'),
(25, 7, '2026-07-22 00:57:27', 'pending'),
(26, 7, '2026-07-22 00:57:30', 'completed'),
(27, 7, '2026-07-22 00:58:47', 'pending'),
(28, 7, '2026-07-22 01:00:00', 'pending'),
(29, 7, '2026-07-22 01:00:04', 'pending'),
(30, 7, '2026-07-22 01:00:38', 'pending'),
(31, 7, '2026-07-22 01:00:53', 'pending'),
(32, 7, '2026-07-22 01:01:59', 'completed'),
(33, 7, '2026-07-22 01:03:39', 'pending'),
(34, 7, '2026-07-22 01:03:41', 'pending'),
(35, 7, '2026-07-22 01:03:43', 'pending'),
(36, 7, '2026-07-22 01:03:51', 'pending'),
(37, 7, '2026-07-22 01:13:32', 'completed'),
(38, 7, '2026-07-22 01:14:22', 'pending'),
(39, 7, '2026-07-22 01:15:03', 'pending'),
(40, 7, '2026-07-22 01:15:56', 'pending'),
(41, 7, '2026-07-22 01:20:17', 'pending'),
(42, 7, '2026-07-22 01:37:16', 'completed'),
(43, 7, '2026-07-22 01:38:07', 'completed'),
(44, 7, '2026-07-22 01:46:12', 'completed'),
(45, 11, '2026-07-22 17:19:24', 'completed'),
(46, 7, '2026-07-22 17:21:56', 'completed'),
(47, 7, '2026-07-22 18:48:05', 'pending'),
(48, 7, '2026-07-22 18:50:41', 'pending'),
(49, 7, '2026-07-22 18:55:25', 'pending'),
(50, 7, '2026-07-22 18:58:05', 'pending');

-- --------------------------------------------------------

--
-- Estrutura da tabela `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 2, 3, 1),
(5, 2, 4, 1),
(6, 2, 7, 1),
(7, 3, 1, 1),
(8, 3, 6, 1),
(9, 3, 7, 1),
(10, 3, 8, 1),
(11, 4, 2, 1),
(13, 5, 1, 1),
(14, 5, 3, 1),
(15, 5, 4, 1),
(16, 6, 2, 1),
(17, 6, 3, 1),
(18, 6, 4, 1),
(26, 14, 2, 1),
(27, 15, 2, 1),
(28, 15, 1, 1),
(29, 15, 3, 1),
(30, 15, 4, 1),
(31, 16, 7, 1),
(32, 16, 8, 1),
(33, 16, 5, 1),
(34, 16, 6, 1),
(36, 17, 7, 1),
(37, 17, 8, 1),
(38, 17, 5, 1),
(40, 18, 7, 1),
(41, 18, 8, 1),
(61, 37, 10, 1),
(62, 37, 2, 2),
(63, 38, 7, 1),
(64, 39, 10, 1),
(65, 40, 1, 1),
(66, 41, 1, 1),
(67, 42, 2, 1),
(68, 43, 2, 1),
(69, 43, 1, 1),
(70, 44, 1, 1),
(71, 45, 11, 1),
(72, 45, 10, 1),
(73, 46, 3, 1),
(74, 46, 4, 1),
(75, 46, 1, 1),
(76, 46, 2, 1),
(77, 47, 2, 1),
(78, 48, 3, 1),
(79, 49, 2, 5),
(80, 50, 17, 1),
(81, 50, 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `description`, `image`, `price`, `stock`) VALUES
(1, 't-shirt', 't-shirts', 'Edicão limitada.', 'imagens/camiseta1.jpg', 69.99, 50),
(2, 't-shirt', 't-shirts', 'Edicão limitada.', 'imagens/camiseta2.jpg', 99.99, 50),
(3, 't-shirt', 't-shirts', 'Edicão limitada.', 'imagens/camiseta3.jpg', 69.99, 50),
(4, 't-shirt', 't-shirts', 'Edicão limitada.', 'imagens/camisa4rosa.png', 69.99, 50),
(5, 'moletom', 'Moletom', 'Edicão limitada.', 'imagens/moletom1amarelo.png', 199.99, 50),
(6, 'moletom', 'Moletom', 'Edicão limitada.', 'imagens/casacorosa.png', 199.99, 50),
(7, 'moletom', 'Moletom', 'Edicão limitada.', 'imagens/casaco3preto.png', 199.99, 50),
(8, 'posters', 'posters', 'Edicão limitada.', 'imagens/poster1.jpg', 39.99, 50),
(10, 'posters', 'posters', 'Edicão limitada.', 'imagens/poster3.jpg', 39.99, 50),
(11, 'ingressos', 'ingressos', 'Edicão limitada.', 'imagens/tick.jpg', 599.99, 50),
(17, 't-shirt', 't-shirt', 'otima qualidade!', '', 50.00, 19);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(7, 'iracema', 'iracema@gmail.com', '$2y$10$KvDVtY5WP.fO6vuoSdnimOQPZ8HbY8H93D0SYMwI4ZLnlxWXPWNUa', 'admin'),
(10, 'ana', 'ana@gmail.com', '$2y$10$9MPbrdz0SIllu00yegG8ZOf6WEkmf2tQVtciMxG9aynNxurIR/.ZK', 'user'),
(11, 'adri', 'drikka@gmail.com', '$2y$10$nHxLrAaJNKFLxpKVuQGBXud3slfr.oK3FAKKdkzuMcZTOGUlGZIpm', 'user');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Índices para tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
