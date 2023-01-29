-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 20-05-2022 a las 16:53:29
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
-- Estructura de tabla para la tabla `omnisalud_tipo_admision`
--

CREATE TABLE `omnisalud_tipo_admision` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `codigo` varchar(200) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `omnisalud_tipo_admision`
--

INSERT INTO `omnisalud_tipo_admision` (`id`, `descripcion`, `codigo`, `active`, `created_at`, `updated_at`) VALUES
(1, 'EXAMEN DE EGRESO', 'EE', 1, '2020-12-07 20:46:04', '2020-12-07 20:46:04'),
(2, 'DE PREINGRESO-OSTEOMUSCULAR', 'PR', 1, '2020-12-07 20:46:36', '2020-12-07 20:46:36'),
(3, 'CONTROL PERIODICO-OSTEOMUSCULAR', 'OS', 1, '2020-12-07 20:51:06', '2020-12-07 20:51:06'),
(4, 'DE CONTROL PERIÓDICO-MANIPULACIÓN DE ALIMENTOS', 'MA', 1, '2020-12-07 20:51:15', '2020-12-07 20:51:15'),
(5, 'DE CONTROL PERIÓDICO-TRABAJO EN ALTURAS', 'TA', 1, '2020-12-07 20:51:15', '2020-12-07 20:51:15'),
(6, 'DE CONTROL PERIÓDICO OCUPACIONAL-TELEMEDICINA/TELCONSULTA', 'TM', 1, '2020-12-07 20:51:15', '2020-12-07 20:51:15'),
(7, 'DE CONTROL PERIÓDICO -- POR CAMBIO DE OCUPACION LABORAL', 'CO', 1, '2020-12-07 20:51:15', '2020-12-07 20:51:15'),
(8, 'DE PREINGRESO - MANUPULACION DE ALIMENTOS', 'PM', 1, '2020-12-07 20:51:15', '2020-12-07 20:51:15'),
(9, 'DE PREINGRESO - TRABAJO EN ALTURAS', 'PT', 1, '2020-12-07 20:51:15', '2020-12-07 20:51:15'),
(10, 'DE PREINGRESO OCUPACIONAL-TELEMECINA/TELECONSULTA', 'PO', 1, '2020-12-07 20:51:15', '2020-12-07 20:51:15'),
(11, 'EXAMEN DE EGRESO-TELEMECINA/TELECONSULTA', 'ET', 1, '2020-12-07 20:51:15', '2020-12-07 20:51:15'),
(12, 'EXAMEN MEDICO LABORAL', 'ML', 1, '2020-12-07 20:51:15', '2020-12-07 20:51:15'),
(13, 'EXAMEN MEDICO LABORAL-TELEMECINA/TELECONSULTA', 'MT', 1, '2020-12-07 20:51:15', '2020-12-07 20:51:15');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `omnisalud_tipo_admision`
--
ALTER TABLE `omnisalud_tipo_admision`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `omnisalud_tipo_admision`
--
ALTER TABLE `omnisalud_tipo_admision`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
