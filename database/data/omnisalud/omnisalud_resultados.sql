-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 20-05-2022 a las 16:53:19
-- Versión del servidor: 5.7.38-log
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `listost3_002`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `omnisalud_resultados`
--

CREATE TABLE `omnisalud_resultados` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `req_id` int(11) NOT NULL,
  `omnisalud_asignacion_id` int(11) DEFAULT NULL,
  `tipo_documento` varchar(255) NOT NULL,
  `numero_documento` int(11) NOT NULL,
  `fecha_prueba` date NOT NULL,
  `fecha_resultado` date NOT NULL,
  `pdf_1` varchar(255) DEFAULT NULL,
  `pdf_2` varchar(255) DEFAULT NULL,
  `pdf_3` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `omnisalud_resultados`
--
ALTER TABLE `omnisalud_resultados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `req_id` (`req_id`),
  ADD KEY `omnisalud_asignacion_id` (`omnisalud_asignacion_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `omnisalud_resultados`
--
ALTER TABLE `omnisalud_resultados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
