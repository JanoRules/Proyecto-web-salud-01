-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2024 a las 04:35:58
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
(0, 2, '2024-10-09', '23:01:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `busquedas_servicios`
--

CREATE TABLE `busquedas_servicios` (
  `id` int(11) NOT NULL,
  `servicio_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Hospital Dr. Hernán Henríquez Aravena', -38.7375000, -72.5982000, 'publico', 'hospital', '24/7', NULL, 100, 20, 40, 30, NULL, NULL, NULL),
(2, 'Clínica Alemana Temuco', -38.7485000, -72.6198000, 'privado', 'clinica', 'Lunes a Viernes 08:00 - 20:00', NULL, 80, 10, 25, 5, NULL, NULL, NULL),
(3, 'Centro de Salud Familiar Amanecer', -38.7414000, -72.6236000, 'publico', 'cesfam', 'Lunes a Viernes 08:00 - 20:00', NULL, 50, 5, 30, 15, NULL, NULL, NULL),
(4, 'Centro de Salud Familiar Pedro de Valdivia', -38.7244000, -72.6096000, 'publico', 'cesfam', 'Lunes a Viernes 08:00 - 18:00', NULL, 40, 3, 20, 7, NULL, NULL, NULL),
(5, 'Centro de Salud Familiar Santa Rosa', -38.7262000, -72.6342000, 'publico', 'cesfam', 'Lunes a Viernes 08:00 - 20:00', NULL, 60, 8, 20, 12, NULL, NULL, NULL),
(6, 'Clínica Mayor', -38.7396000, -72.6014000, 'privado', 'clinica', 'Lunes a Viernes 08:00 - 18:00', NULL, 70, 5, 30, 10, NULL, NULL, NULL),
(7, 'Consultorio Miraflores', -38.7265000, -72.5957000, 'publico', 'consultorio', 'Lunes a Viernes 08:00 - 18:00', NULL, 45, 4, 18, 6, NULL, NULL, NULL),
(8, 'Centro Médico RedSalud Temuco', -38.7421000, -72.6214000, 'privado', 'clinica', 'Lunes a Viernes 08:00 - 20:00', NULL, 75, 12, 35, 8, NULL, NULL, NULL),
(9, 'Centro de Salud Familiar Labranza', -38.7659000, -72.7161000, 'publico', 'cesfam', 'Lunes a Viernes 08:00 - 18:00', NULL, 55, 6, 20, 9, NULL, NULL, NULL),
(10, 'Centro Médico Medisur', -38.7344866, -72.6001603, 'privado', 'clinica', 'Lunes a Sábado 08:00 - 21:00', NULL, 60, 5, 20, 8, NULL, NULL, NULL),
(12, 'CESFAM Padre Las Casas', -38.7612411, -72.5932699, 'publico', 'cesfam', '24/7', NULL, 70, 8, 30, 12, NULL, NULL, NULL),
(13, 'Centro de Salud Familiar Barroso', -38.7611199, -72.5936805, 'publico', 'cesfam', '24/7', NULL, 65, 7, 28, 10, NULL, NULL, NULL),
(14, 'Centro de Salud Familiar Las Colinas', -38.7658601, -72.6074222, 'publico', 'cesfam', '24/7', NULL, 60, 6, 25, 9, NULL, NULL, NULL),
(15, 'Centro de Salud Familiar Conunhuenu', -38.7740293, -72.5974020, 'publico', 'cesfam', 'Lunes a Viernes 08:00 - 17:00', NULL, 55, 4, 16, 3, NULL, NULL, NULL),
(16, 'Centro de Salud Familiar Pulmahue', -38.7726958, -72.5889426, 'publico', 'cesfam', 'Lunes a Viernes 08:00 - 17:00', NULL, 50, 4, 20, 7, NULL, NULL, NULL),
(17, 'Centro de Salud Familiar Metodista', -38.7370788, -72.6214864, 'publico', 'cesfam', 'Lunes a Viernes 08:00 - 17:00', NULL, 45, 4, 18, 6, NULL, NULL, NULL),
(18, 'Centro de Salud Familiar Pueblo Nuevo', -38.7179347, -72.5619179, 'publico', 'cesfam', 'Lunes a Viernes 09:00 - 18:00', NULL, 40, 3, 15, 5, NULL, NULL, NULL),
(19, 'Cesfam El Carmen', -38.7128959, -72.6549301, 'publico', 'cesfam', 'Lunes a Viernes 08:00 - 20:00, Sábado 09:00 - 12:30', NULL, 55, 5, 22, 8, NULL, NULL, NULL),
(20, 'Centro de Salud Familiar Monseñor Valech', -38.6473229, -72.6804685, 'publico', 'cesfam', 'Lunes a Viernes 08:00 - 20:00', NULL, 60, 6, 25, 9, NULL, NULL, NULL),
(21, 'CESFAM Quepe', -38.8679521, -72.6150438, 'publico', 'cesfam', 'Lunes a Sábado 09:00 - 13:30, 24/7', NULL, 50, 5, 16, 7, NULL, NULL, NULL),
(31, 'Centro de Salud Familiar CESFAM Cajón', -38.6799994, -72.5028053, 'publico', 'cesfam', 'Lunes a Sábado 08:00 - 17:00', NULL, 52, 9, 20, 11, NULL, NULL, NULL),
(32, 'Clínica Alemana de Temuco', -38.7359000, -72.5985000, '', 'clinica', 'Lunes a Domingo 24 horas', '24 horas', 500, 300, 150, 50, 'Urgencias, Consultas Médicas, Hospitalización, Cirugías', 'Excelente atención, médicos especializados', 4.8),
(33, 'Clínica Mayor', -38.7350000, -72.6037000, '', 'clinica', 'Lunes a Domingo 24 horas', '24 horas', 400, 250, 120, 30, 'Urgencias, Consultas Médicas, Hospitalización, Diagnóstico por imágenes', 'Atención rápida, equipo profesional', 4.7),
(34, 'Clínica RedSalud', -38.7381000, -72.5963000, '', 'clinica', 'Lunes a Domingo 24 horas', '24 horas', 350, 200, 100, 30, 'Urgencias, Consultas Médicas, Laboratorio, Imágenes', 'Buena atención y rapidez en urgencias', 4.5),
(35, 'Clínica Las Condes Temuco', -38.7394000, -72.5908000, '', 'clinica', 'Lunes a Viernes 8:00 a 20:00, Sábado 9:00 a 13:00', '8:00 - 20:00', 250, 150, 70, 30, 'Consultas Médicas, Laboratorio, Cirugías Menores', 'Excelente servicio y atención médica especializada', 4.6),
(36, 'Consultorio Miraflores', -38.7370000, -72.6051000, '', 'consultorio', 'Lunes a Viernes de 8:00 a 17:00', '8:00 - 17:00', 200, 150, 40, 10, 'Consultas Médicas, Control de Niños Sano, Programas de Salud Preventiva', 'Buena atención en horario', 4.5),
(37, 'Consultorio Pedro de Valdivia', -38.7402000, -72.6158000, '', 'consultorio', 'Lunes a Viernes de 8:00 a 17:00', '8:00 - 17:00', 250, 180, 50, 15, 'Consultas Médicas, Vacunación, Programas de Salud', 'Un poco de espera, pero buena atención', 4.3),
(38, 'Consultorio Amanecer', -38.7367000, -72.5862000, '', 'consultorio', 'Lunes a Viernes de 8:00 a 17:00', '8:00 - 17:00', 300, 200, 70, 20, 'Consultas Médicas, Atención Primaria, Vacunación', 'Atención rápida y personal amable', 4.4),
(39, 'Consultorio Santa Rosa', -38.7332000, -72.6015000, '', 'consultorio', 'Lunes a Viernes de 8:00 a 17:00', '8:00 - 17:00', 220, 160, 40, 12, 'Consultas Médicas, Salud Preventiva, Programas Infantiles', 'Buena atención pero demora en urgencias', 4.2),
(40, 'Consultorio Pueblo Nuevo', -38.7453000, -72.5952000, '', 'consultorio', 'Lunes a Viernes de 8:00 a 17:00', '8:00 - 17:00', 280, 190, 60, 15, 'Consultas Médicas, Salud de la Mujer, Vacunación', 'Atención médica de calidad, pero con algo de espera', 4.1),
(41, 'Consultorio Villa Alegre', -38.7415000, -72.5891000, '', 'consultorio', 'Lunes a Viernes de 8:00 a 17:00', '8:00 - 17:00', 250, 170, 50, 10, 'Consultas Médicas, Programas Infantiles, Vacunación', 'Atención amable y personal capacitado', 4.3);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `centro_salud_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `rut` varchar(12) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `intentos_fallidos` int(11) DEFAULT 0,
  `tiempo_bloqueo` datetime DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`id`, `rut`, `username`, `password`, `intentos_fallidos`, `tiempo_bloqueo`, `role`) VALUES
(1, '22.016.050-5', 'nicolas.fuentes2024', '$2y$10$kW9OsyZwf3jssb142i3GVeUlHFGcl/RYsmKtTFKIRMxMfuCUevIXu', 0, NULL, 'user'),
(2, '132006005', 'vegetta777', '$2y$10$9g4Q7rNly.gF00OTKEin6OCfDwjXH5qtABzK.Sow/YNF4H4Vn1y1e', 0, NULL, 'user'),
(5, '125135405', 'kylianmbappe7', '$2y$10$uWPsUhBajAsXwa0JIdywxO4lhDMRrcG66VRgxibDG9yny06aSDnsm', 0, NULL, 'user'),
(6, '214445552', 'Maxpayne', '$2y$10$RCgZ8m56yaSV1.skvvYDmugfSrQ212beCfVplYNuLv0JKnoveHTWO', 0, NULL, 'user'),
(7, '19.800.695-1', 'nfuentes', '$2y$10$GBFHkJCGd5.fKJJ2AaOQleVdPJw3BhrBJgAd.wE/mUrk7g9o6H5Ou', 0, NULL, 'user'),
(16, '98765432-1', 'Admin2', '$2y$10$EpsePuOowBJ3fyqgeEoJp.vhUzhsqFdB.w4/F.Qnj.ux.w/x0SiVG', 0, NULL, 'admin');

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
-- Estructura de tabla para la tabla `reseñas`
--

CREATE TABLE `reseñas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `centro_salud` text DEFAULT NULL,
  `calificacion` int(11) NOT NULL CHECK (`calificacion` >= 1 and `calificacion` <= 5),
  `reseña` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `centro_salud_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reseñas`
--

INSERT INTO `reseñas` (`id`, `nombre`, `centro_salud`, `calificacion`, `reseña`, `fecha`, `centro_salud_id`) VALUES
(1, 'Nicolas', '0', 5, 'Hospital excelente, buena atencion, recomendado.', '2024-10-15 19:33:53', NULL),
(2, 'Slayer', '0', 3, 'dfgfgdfgfgd', '2024-10-22 03:50:59', NULL),
(3, 'Slayer', '0', 3, 'dsfdsfdsfsdf', '2024-10-22 03:56:54', NULL),
(4, 'Slayer', 'undefined', 3, 'dsfdsfdsf', '2024-10-22 04:02:46', NULL),
(5, 'Slayer', 'undefined', 4, 'fgdfsgsdgds', '2024-10-22 04:03:38', NULL),
(6, 'dsfdsfdsf', NULL, 3, 'dsfdsfsdf', '2024-10-22 18:59:58', 0),
(7, 'dsfdsfdsf', NULL, 3, 'dsfdsfsdf', '2024-10-22 19:00:12', 0),
(8, 'dfdsf', NULL, 3, 'sdfdsfds', '2024-10-22 19:07:44', 0),
(9, 'Ariel', NULL, 3, 'sdfdsfdsf', '2024-10-22 19:11:55', 0),
(10, 'edfsdfsdf', NULL, 3, 'sdfsdfdsf', '2024-10-22 19:23:19', 0),
(11, 'dfdsf', 'sdfdsf', 2, 'dsfdsfds', '2024-10-22 19:31:10', 0),
(12, 'dsfdfssdf', NULL, 3, 'dsfdsfdsf', '2024-10-22 19:33:45', 2),
(13, 'dsfdfssdf', NULL, 3, 'dsfdsfdsf', '2024-10-22 19:35:35', 2),
(14, 'dsfdsfdsf', NULL, 4, 'dsfdsfdsfsdfdsf', '2024-10-22 19:35:49', 2),
(15, 'dsfsdfsdf', NULL, 3, 'dsfdsfsdf', '2024-10-22 19:36:58', 0),
(16, 'dsfdsf', NULL, 3, 'dsfdsfsdf', '2024-10-22 19:39:15', 0),
(17, 'dsfdsf', NULL, 3, 'dsfdsfsdf', '2024-10-22 19:40:00', 0),
(18, 'sdfsdfsdf', NULL, 3, 'sdfdsfsdf', '2024-10-22 19:40:53', 0),
(19, 'dsfdsfdsf', NULL, 3, 'sdfsdf', '2024-10-23 01:48:42', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseñas2`
--

CREATE TABLE `reseñas2` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `reseña` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`) VALUES
(1, 'Traumatologia'),
(2, 'Urgencias'),
(3, 'Pediatria'),
(4, 'Oftalmologia');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `busquedas_servicios`
--
ALTER TABLE `busquedas_servicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `servicio_id` (`servicio_id`),
  ADD KEY `usuario_id` (`usuario_id`);

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
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`centro_salud_id`),
  ADD KEY `centro_salud_id` (`centro_salud_id`);

--
-- Indices de la tabla `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rut` (`rut`);

--
-- Indices de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reseñas2`
--
ALTER TABLE `reseñas2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `busquedas_servicios`
--
ALTER TABLE `busquedas_servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `centros_salud`
--
ALTER TABLE `centros_salud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `reseñas2`
--
ALTER TABLE `reseñas2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reseñas2`
--
ALTER TABLE `reseñas2`
  ADD CONSTRAINT `reseñas2_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `login` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;