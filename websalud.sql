-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-09-2024 a las 23:11:46
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
-- Base de datos: `websalud`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador_de_web`
--

CREATE TABLE `administrador_de_web` (
  `id_administrador` char(20) NOT NULL,
  `admin_nombre` char(20) DEFAULT NULL,
  `admin_apellido` char(20) DEFAULT NULL,
  `admin_password` char(20) DEFAULT NULL,
  `correo` char(30) DEFAULT NULL,
  `id_municipalidad` int(11) DEFAULT NULL,
  `rut` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro_salud`
--

CREATE TABLE `centro_salud` (
  `Id_centro_salud` int(11) NOT NULL,
  `nombre` char(20) DEFAULT NULL,
  `direccion` char(40) DEFAULT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `recursos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `id_consulta` int(11) NOT NULL,
  `fecha_consulta` date DEFAULT NULL,
  `rut` char(10) DEFAULT NULL,
  `id_centro_salud` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionario`
--

CREATE TABLE `funcionario` (
  `id_funcionario` char(10) NOT NULL,
  `nombre` char(20) DEFAULT NULL,
  `apellido` char(20) DEFAULT NULL,
  `trabajo` char(30) DEFAULT NULL,
  `id_centro_salud` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recomendacion`
--

CREATE TABLE `recomendacion` (
  `id_recomendacion` int(11) NOT NULL,
  `razon` char(250) DEFAULT NULL,
  `id_centro_salud` int(11) DEFAULT NULL,
  `id_situacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `situacion_salud`
--

CREATE TABLE `situacion_salud` (
  `id_situacion` int(11) NOT NULL,
  `gravedad` int(11) DEFAULT NULL,
  `descripcion` char(250) DEFAULT NULL,
  `rut` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `rut` char(10) NOT NULL,
  `nombre` char(20) DEFAULT NULL,
  `apellido` char(20) DEFAULT NULL,
  `pass` char(20) DEFAULT NULL,
  `correo` char(30) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `ubicacion` char(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`rut`, `nombre`, `apellido`, `pass`, `correo`, `fecha_nacimiento`, `ubicacion`) VALUES
('123456789', 'Alan', 'Brito', '12345', 'Alan@gmail.com', '2005-07-21', 'Temuco');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador_de_web`
--
ALTER TABLE `administrador_de_web`
  ADD PRIMARY KEY (`id_administrador`);

--
-- Indices de la tabla `centro_salud`
--
ALTER TABLE `centro_salud`
  ADD PRIMARY KEY (`Id_centro_salud`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`id_consulta`),
  ADD KEY `id_centro_salud` (`id_centro_salud`);

--
-- Indices de la tabla `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id_funcionario`),
  ADD KEY `id_centro_salud` (`id_centro_salud`);

--
-- Indices de la tabla `recomendacion`
--
ALTER TABLE `recomendacion`
  ADD PRIMARY KEY (`id_recomendacion`),
  ADD KEY `id_centro_salud` (`id_centro_salud`),
  ADD KEY `id_situacion` (`id_situacion`);

--
-- Indices de la tabla `situacion_salud`
--
ALTER TABLE `situacion_salud`
  ADD PRIMARY KEY (`id_situacion`),
  ADD KEY `rut` (`rut`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`rut`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `consulta_ibfk_1` FOREIGN KEY (`id_centro_salud`) REFERENCES `centro_salud` (`Id_centro_salud`);

--
-- Filtros para la tabla `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `funcionario_ibfk_1` FOREIGN KEY (`id_centro_salud`) REFERENCES `centro_salud` (`Id_centro_salud`);

--
-- Filtros para la tabla `recomendacion`
--
ALTER TABLE `recomendacion`
  ADD CONSTRAINT `recomendacion_ibfk_1` FOREIGN KEY (`id_centro_salud`) REFERENCES `centro_salud` (`Id_centro_salud`),
  ADD CONSTRAINT `recomendacion_ibfk_2` FOREIGN KEY (`id_situacion`) REFERENCES `situacion_salud` (`id_situacion`);

--
-- Filtros para la tabla `situacion_salud`
--
ALTER TABLE `situacion_salud`
  ADD CONSTRAINT `situacion_salud_ibfk_1` FOREIGN KEY (`rut`) REFERENCES `usuario` (`rut`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
