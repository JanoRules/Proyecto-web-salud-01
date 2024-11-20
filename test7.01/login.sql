-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2024 a las 03:49:24
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
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `rut` varchar(12) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `intentos_fallidos` int(11) DEFAULT 0,
  `tiempo_bloqueo` datetime DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`id`, `rut`, `correo`, `username`, `password`, `intentos_fallidos`, `tiempo_bloqueo`, `role`) VALUES
(1, '22.016.050-5', 'nicola@gmail.com', 'nicolas.fuentes2024', '$2y$10$kW9OsyZwf3jssb142i3GVeUlHFGcl/RYsmKtTFKIRMxMfuCUevIXu', 0, NULL, 'user'),
(2, '132006005', 'vegetta777@gmail.com', 'vegetta777', '$2y$10$9g4Q7rNly.gF00OTKEin6OCfDwjXH5qtABzK.Sow/YNF4H4Vn1y1e', 0, NULL, 'user'),
(5, '125135405', 'kylianmbappe7@gmail.com', 'kylianmbappe7', '$2y$10$uWPsUhBajAsXwa0JIdywxO4lhDMRrcG66VRgxibDG9yny06aSDnsm', 0, NULL, 'user'),
(6, '214445552', 'max@gmail.com', 'Maxpayne', '$2y$10$RCgZ8m56yaSV1.skvvYDmugfSrQ212beCfVplYNuLv0JKnoveHTWO', 0, NULL, 'user'),
(7, '19.800.695-1', 'olaola@gmail.com', 'nfuentes', '$2y$10$GBFHkJCGd5.fKJJ2AaOQleVdPJw3BhrBJgAd.wE/mUrk7g9o6H5Ou', 0, NULL, 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
