-- Administrador de la web
CREATE TABLE `administrador_de_web` (
  `id_administrador` char(20),
  `admin_nombre` char(20),
  `admin_apellido` char(20),
  `admin_password` char(20),
  `correo` char(30),
  `id_municipalidad` int,
  `rut` char(10),
  PRIMARY KEY (`id_administrador`)
);

-- Usuario
CREATE TABLE `usuario` (
  `rut` char(10),
  `nombre` char(20),
  `apellido` char(20),
  `password` char(20),
  `correo` char(30),
  `fecha_nacimiento` date,
  `ubicacion` char(30),
  `estado_salud` char(30),
  PRIMARY KEY (`rut`)
);

-- Situación de salud
CREATE TABLE `situacion_salud` (
  `id_situacion` int,
  `gravedad` int,
  `descripcion` char(300),
  `rut` char(10),
  PRIMARY KEY (`id_situacion`),
  FOREIGN KEY (`rut`) REFERENCES `usuario`(`rut`)
);

-- Centro de salud
CREATE TABLE `centro_salud` (
  `Id_centro_salud` int,
  `nombre` char(20),
  `direccion` char(40),
  `capacidad` int,
  `recursos` int,
  PRIMARY KEY (`Id_centro_salud`)
);

-- Recomendación
CREATE TABLE `recomendacion` (
  `id_recomendacion` int,
  `razon` char(500),
  `id_centro_salud` int,
  `id_situacion` int,
  PRIMARY KEY (`id_recomendacion`),
  FOREIGN KEY (`id_centro_salud`) REFERENCES `centro_salud`(`Id_centro_salud`),
  FOREIGN KEY (`id_situacion`) REFERENCES `situacion_salud`(`id_situacion`)
);

-- Funcionario
CREATE TABLE `funcionario` (
  `id_funcionario` char(10),
  `nombre` char(20),
  `apellido` char(20),
  `trabajo` char(30),
  `id_centro_salud` int,
  PRIMARY KEY (`id_funcionario`),
  FOREIGN KEY (`id_centro_salud`) REFERENCES `centro_salud`(`Id_centro_salud`)
);

-- Consulta
CREATE TABLE `consulta` (
  `id_consulta` int,
  `fecha_consulta` date,
  `rut` char(10),
  `id_centro_salud` int,
  PRIMARY KEY (`id_consulta`),
  FOREIGN KEY (`id_centro_salud`) REFERENCES `centro_salud`(`Id_centro_salud`)
);
