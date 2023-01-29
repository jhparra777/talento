-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 20-05-2022 a las 16:52:43
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
-- Estructura de tabla para la tabla `omnisalud_examenes_medicos`
--

CREATE TABLE `omnisalud_examenes_medicos` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `omnisalud_examenes_medicos`
--

INSERT INTO `omnisalud_examenes_medicos` (`id`, `descripcion`, `codigo`, `active`, `created_at`, `updated_at`) VALUES
(1, 'CONSULTA MEDICA ESPECIALIZADA (REUBICACION  POS INCAPACIDAD  ACCIDENTES  AUSENTISMOS ALTOS Y OTROS)\r\n', 'CME', 1, '2020-12-08 00:03:53', '2020-12-08 00:03:53'),
(2, 'PRUEBA DE ALCOHOL EN ALIENTO', 'PAA', 1, '2020-12-08 00:07:55', '2020-12-08 00:07:55'),
(3, 'EXAMEN DE AUDIOMETRIA  SIMPLE  O TONAL', 'AUS', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(4, 'EXAMEN DE AUDIOMETRIA  CLINICA', 'AUC', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(5, 'COLESTEROL TOTAL', 'COT', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(6, 'COPROLOGICO', 'COP', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(7, 'CREATININA', 'CRE', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(8, 'ELECTROCARDIOGRAMA  SIMPLE', 'ELS', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(9, 'ESPIROMETRIA OCUPACIONAL', 'ESO', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(10, 'EVALUACION MEDICA PARA TRABAJO EN ALTURAS / EVALUCION  MEDICA CON ENFASIS EN VERTIGO  NEUROLOGICO Y OSTEOMUSCULAR/CUESTIONARIO DE ESTADO DE SALUD', 'ETA', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(11, 'EXAMEN MEDICO OCUPACIONAL DE INGRESO', 'MOI', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(12, 'EXAMEN MEDICO OCUPACIONAL PERIODICO', 'MOP', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(13, 'EXAMEN MEDICO OCUPACIONAL DE EGRESO', 'MOE', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(14, 'PRUEBA PSICOSENSOMETRICA', 'PSI', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(15, 'FROTIS DE UÑA', 'FDU', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(16, 'FROTIS DE GARGANTA', 'FDG', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(17, 'GLICEMIA', 'GLI', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(18, 'SEROLOGIA', 'SER', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(19, 'SEROLOGIA (NAC)', 'SEN', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(20, 'HEMOCLASIFICACION', 'HCN', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(21, 'HEMOGRAMA', 'HMG', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(22, 'EXAMEN OPTOMETRICO OCUPACIONAL', 'OPO', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(23, 'PARCIAL DE ORINA', 'PDO', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(24, 'PERFIL LIPIDICO', 'PLI', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(25, 'PRUEBA MULTIDROGAS CINCO SUSTANCIAS', 'MCS', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(26, 'PRUEBA MULTIDROGAS DOS SUSTANCIAS', 'MDS', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(27, 'RADIOGRAFIA DE COLUMNA LUMBOSACRA AP Y LATERAL', 'RCL', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(28, 'RADIOGRAFIA DE TORAX (PA O AP Y LATERAL  DECUBITO LATERAL  OBLICUAS O LATERAL', 'RDT', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(29, 'TRIGLICERIDOS', 'TRI', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(30, 'VACUNA ANTITETANICA', 'VAT', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(31, 'VACUNA FIEBRE AMARILLA', 'VFA', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(32, 'VACUNA HEPATITIS B', 'VHB', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(33, 'VISIOMETRIA OCUPACIONAL (REALIZADA POR OPTOMETRA)', 'VOC', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(34, 'HEMOGLOBINA', 'HEM', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(35, 'UREA BUN', 'URE', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(36, 'ALT(GPT)', 'ALT', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(37, 'AST(GOT)', 'AST', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(38, 'COLINESTERASA SERICA', 'COL', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(39, 'BETA CUANTITATIVA', 'BET', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(40, 'PIE CUALITATIVA', 'PIE', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(41, 'CULTIVO FARINGEO', 'CUL', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(42, 'PPD (PRUEBA DE TUBERCULINA)', 'PPD', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(43, 'EVALUACION DE LA VOZ', 'EVV', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(44, 'VACUNA MENINGOCOCO', 'VME', 1, '2020-12-08 00:08:16', '2020-12-08 00:08:16'),
(45, 'FROTIS DE GARGANTA BOGOTÁ', 'FGB', 1, '2021-03-29 15:17:49', '2021-03-29 15:17:49');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `omnisalud_examenes_medicos`
--
ALTER TABLE `omnisalud_examenes_medicos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `omnisalud_examenes_medicos`
--
ALTER TABLE `omnisalud_examenes_medicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
