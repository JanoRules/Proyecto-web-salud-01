-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-10-2024 a las 20:39:34
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
-- Base de datos: `base_datos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agendar_hora`
--

CREATE TABLE `agendar_hora` (
  `id` int(11) NOT NULL,
  `id_centro` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `agendar_hora`
--

INSERT INTO `agendar_hora` (`id`, `id_centro`, `fecha`, `hora`) VALUES
(11, 2, '2024-10-25', '18:22:00'),
(12, 2, '2024-10-24', '19:30:00'),
(13, 2, '2024-10-25', '19:30:00'),
(14, 2, '2024-10-25', '22:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centros_salud`
--

CREATE TABLE `centros_salud` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `lat` decimal(10,7) NOT NULL,
  `lng` decimal(10,7) NOT NULL,
  `atencion` enum('publico','privado') NOT NULL,
  `tipo` enum('hospital','clinica','cesfam','consultorio') NOT NULL,
  `horario` varchar(100) NOT NULL,
  `horario_atencion` varchar(255) DEFAULT NULL,
  `capacidad_total` int(11) DEFAULT NULL,
  `personas_atencion_baja` int(11) DEFAULT NULL,
  `personas_atencion_media` int(11) DEFAULT NULL,
  `personas_atencion_inmediata` int(11) DEFAULT NULL,
  `servicios` text DEFAULT NULL,
  `reseñas` text DEFAULT NULL,
  `rating` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `centros_salud`
--

INSERT INTO `centros_salud` (`id`, `nombre`, `lat`, `lng`, `atencion`, `tipo`, `horario`, `horario_atencion`, `capacidad_total`, `personas_atencion_baja`, `personas_atencion_media`, `personas_atencion_inmediata`, `servicios`, `reseñas`, `rating`) VALUES
(1, 'Hospital Dr. Hernán Henríquez Aravena', -38.7375000, -72.5982000, 'publico', 'hospital', '24/7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Clínica Alemana Temuco', -38.7485000, -72.6198000, 'privado', 'clinica', 'Lunes a Viernes 08:00 - 20:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Centro de Salud Familiar Amanecer', -38.7414000, -72.6236000, 'publico', 'cesfam', 'Lunes a Viernes 08:00 - 20:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Centro de Salud Familiar Pedro de Valdivia', -38.7244000, -72.6096000, 'publico', 'cesfam', 'Lunes a Viernes 08:00 - 18:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Centro de Salud Familiar Santa Rosa', -38.7262000, -72.6342000, 'publico', 'cesfam', 'Lunes a Viernes 08:00 - 20:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Clínica Mayor', -38.7396000, -72.6014000, 'privado', 'clinica', 'Lunes a Viernes 08:00 - 18:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Consultorio Miraflores', -38.7265000, -72.5957000, 'publico', 'consultorio', 'Lunes a Viernes 08:00 - 18:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Centro Médico RedSalud Temuco', -38.7421000, -72.6214000, 'privado', 'clinica', 'Lunes a Viernes 08:00 - 20:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Centro de Salud Familiar Labranza', -38.7659000, -72.7161000, 'publico', 'cesfam', 'Lunes a Viernes 08:00 - 18:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id` int(11) NOT NULL,
  `tipo_queja` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id`, `tipo_queja`, `region`, `descripcion`, `fecha`) VALUES
(1, 'negligencia ', 'Arica y Parinacota', 'wqe', '2024-10-15 16:50:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `rut` varchar(12) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`id`, `rut`, `username`, `password`) VALUES
(1, '22.016.050-5', 'nicolas.fuentes2024', '$2y$10$kW9OsyZwf3jssb142i3GVeUlHFGcl/RYsmKtTFKIRMxMfuCUevIXu'),
(2, '132006005', 'vegetta777', '$2y$10$AlvYFpa0vRDyY1sa/NYHOukiKwvK2OX.05QMU7RsUKAf0IUMaMahu'),
(4, '145008005', 'willyrex', '$2y$10$dde8O0RO9ySTTOm0vALyHescmULIUIxKY.nLv0gIUb/56o5/04FKC'),
(5, '125135405', 'kylianmbappe7', '$2y$10$uWPsUhBajAsXwa0JIdywxO4lhDMRrcG66VRgxibDG9yny06aSDnsm'),
(6, '214445552', 'Maxpayne', '$2y$10$RCgZ8m56yaSV1.skvvYDmugfSrQ212beCfVplYNuLv0JKnoveHTWO'),
(7, '19.800.695-1', 'nfuentes', '$2y$10$GBFHkJCGd5.fKJJ2AaOQleVdPJw3BhrBJgAd.wE/mUrk7g9o6H5Ou'),
(8, '200806008', 'Montapuercos', '$2y$10$Mh1Q0ywx/srLi88P3lGFaORidWiWJkGi3cyusTQq1j7KxQehR3cKS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

CREATE TABLE `registro` (
  `id` int(11) NOT NULL,
  `rut` varchar(12) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `ubicacion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro`
--

INSERT INTO `registro` (`id`, `rut`, `nombre`, `apellidos`, `correo`, `fechaNacimiento`, `ubicacion`) VALUES
(1, '22.016.050-5', 'nicolas', 'fuentes', 'nicola@gmail.com', '2024-08-28', 'Temuco'),
(2, '132006005', 'Samuel', 'DeLuque', 'vegetta777@gmail.com', '2024-09-15', 'Temuco'),
(5, '145008005', 'wily', 'rex', 'wilyrex1@gmail.com', '2024-08-28', 'Temuco'),
(6, '125135405', 'Kylian ', 'Mbappe', 'kylianmbappe7@gmail.com', '2024-09-02', 'Puente alto'),
(7, '214445552', 'Max', 'Payne', 'max@gmail.com', '2024-08-29', 'Puente alto'),
(8, '19.800.695-1', 'Nicolás', 'Fuentes Calfullán', 'olaola@gmail.com', '2006-01-08', 'Temuco'),
(9, '200806008', 'Monta', 'Puercos', 'figfuj5fg615@gfdfd.com', '2000-06-02', 'Temuco');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `rut` char(10) NOT NULL,
  `nombre` char(20) DEFAULT NULL,
  `password` char(20) DEFAULT NULL,
  `correo` char(30) DEFAULT NULL,
  `ubicacion` char(30) DEFAULT NULL,
  `estado_salud` char(30) DEFAULT NULL,
  `apellidos` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `fechaNacimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`rut`, `nombre`, `password`, `correo`, `ubicacion`, `estado_salud`, `apellidos`, `username`, `fechaNacimiento`) VALUES
('227584938', 'sfddsfds', '$2y$10$pjpW4WGlL6.Eh', 'waza50@gmail.com', 'asasa', NULL, 'sdfsdfsd', 'asasa', '2024-09-20'),
('333333333', 'dadssa', '$2y$10$0aclx2vUO47NZ', 'emeraldchaos30@gmail.com', 'Mexico', NULL, 'sadasdsad', 'afadssadasd', '2024-09-07');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agendar_hora`
--
ALTER TABLE `agendar_hora`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_centro` (`id_centro`);

--
-- Indices de la tabla `centros_salud`
--
ALTER TABLE `centros_salud`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rut` (`rut`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indices de la tabla `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rut` (`rut`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`rut`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agendar_hora`
--
ALTER TABLE `agendar_hora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `centros_salud`
--
ALTER TABLE `centros_salud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `agendar_hora`
--
ALTER TABLE `agendar_hora`
  ADD CONSTRAINT `agendar_hora_ibfk_1` FOREIGN KEY (`id_centro`) REFERENCES `centros_salud` (`id`);

--
-- Filtros para la tabla `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`rut`) REFERENCES `registro` (`rut`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
