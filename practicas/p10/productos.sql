-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-10-2024 a las 21:16:00
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `marketzone`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `marca` varchar(25) DEFAULT NULL,
  `modelo` varchar(25) DEFAULT NULL,
  `precio` double(10,2) NOT NULL DEFAULT 0.00,
  `detalles` varchar(250) DEFAULT NULL,
  `unidades` int(11) NOT NULL DEFAULT 0,
  `imagen` varchar(100) DEFAULT NULL,
  `eliminado` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `marca`, `modelo`, `precio`, `detalles`, `unidades`, `imagen`, `eliminado`) VALUES
(1, 'Hello Kitty', 'Mattel', 'HKT069Y', 324.67, '', 120, 'img/hellokity.jpg', 1),
(2, 'Ajolote Rosa', 'Mattel', 'arf01', 703.00, 'Peluche Ajolote Colores Adorable Axolotl Kawaii Regalo 20CM Rosa', 300, 'img/ajoloterosa.jpg', 0),
(3, 'ajoloteazul', 'funbu', 'aaf02', 705.00, 'Peluche Ajolote Colores Adorable Axolotl Kawaii Regalo 20CM Azul', 200, './img/ajoloteazul.jpg', 0),
(4, 'Marie', 'Disney', 'mdr01', 917.80, 'Just Play Disney Classics Bean Plush Marie Blanco y Rosa 20CM', 250, './img/marie.jpg', 1),
(5, 'Perro Husky Negro', 'SXPC ', 'hns01', 653.24, 'Lindo Perro Husky Adornos de Peluche Kawaii Felpa Adornos Decorativos 20CM', 300, './img/husky.jpg', 0),
(6, 'nombre_producto', 'marca_producto', 'modelo_producto', 1.00, 'detalles_producto', 1, 'img/imagen.png', 1),
(12, 'Mickey y Minie', 'Disney', 'mmd01', 968.98, 'Juego de 2 juguetes de peluche de Mickey y Minnie Mouse de 10 pulgadas\r\n', 500, 'img/mickey&minie.jpeg', 1),
(13, 'Minie', 'Mattel', 'mnd01', 564.45, 'Minnie 10776 Disney Pink 11 pulgadas Beans Plush', 600, 'img/minie.jpg', 0),
(14, 'Togepi', 'Pokemon', 'tgp01', 320.70, 'Peluche Pokemon Togepi 23 cm color crema\r\n', 120, 'img/togepi.jpg', 0),
(15, 'Pikachu', 'Pokemon', 'pkp01', 414.85, 'Peluche Oficial de Pikachu de 20.3 cm de Calidad Premium, Adorable, ultrasuave, Juguete de Peluche, Perfecto para Jugar y exhibir', 453, 'img/pikachu.jpg', 0),
(16, 'princesa ariel', 'Fisher Price', 'HMX84', 150.00, 'Las piezas están fabricadas con plástico resistente, ideal para niños de 1 a 5 años de edad.', 1, 'img/princesaariel.jpg', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
