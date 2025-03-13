-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 13-03-2025 a las 20:36:39
-- Versión del servidor: 8.0.36
-- Versión de PHP: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aquadocs2`
--
CREATE DATABASE IF NOT EXISTS `aquadocs2` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci;
USE `aquadocs2`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `area_id` int NOT NULL,
  `area_nombre` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `area_descripcion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci,
  `area_jerarquia` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`area_id`, `area_nombre`, `area_descripcion`, `area_jerarquia`) VALUES
(1, 'Administración', NULL, NULL),
(2, 'Ventas', NULL, NULL),
(3, 'Soporte Técnico', NULL, NULL),
(4, 'Recursos Humanos', NULL, NULL),
(5, 'Marketing', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cambios_expedientes`
--

CREATE TABLE `cambios_expedientes` (
  `cambio_id` int NOT NULL,
  `expediente_id` int NOT NULL,
  `cambio_fecha` datetime NOT NULL,
  `cambio_estado` enum('pendiente','en_proceso','completado') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `cambio_descripcion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `empleado_nroLegajo` int NOT NULL,
  `empleado_nombre` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `empleado_apellido` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `empleado_dni` char(8) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `empleado_telefono` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `empleado_genero` enum('Femenino','Masculino','Otro') COLLATE utf8mb3_spanish2_ci NOT NULL,
  `area_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`empleado_nroLegajo`, `empleado_nombre`, `empleado_apellido`, `empleado_dni`, `empleado_telefono`, `empleado_genero`, `area_id`) VALUES
(57, 'José María', 'Carrizo', '42358125', '3804596502', 'Masculino', 3),
(63, 'Alicia Jazmín', 'Carrizo', '45934532', '3804857143', 'Femenino', 5),
(66, 'Andrea Beatriz', 'Basualdo', '16435789', '3804325625', 'Femenino', 4),
(80, 'Jorge', 'Guillermo', '45234233', '3804343467', 'Otro', 2),
(81, 'Agustin', 'Paredes', '45987776', '3804484566', 'Otro', 2),
(83, 'Lucas Miguel', 'Rodriguez', '43875699', '3804587462', 'Masculino', 3),
(84, 'Eduardo', 'Montivero', '35346636', '3804363463', 'Masculino', 1),
(86, 'Manuel Ulises', 'Bustamante', '43657341', '3804634654', 'Masculino', 2),
(90, 'Silvio Manuel', 'Nuñez', '45756345', '3804536754', 'Masculino', 4),
(91, 'Alejandro', 'Nuñez', '35908766', '3804859467', 'Otro', 2),
(92, 'Jorge', 'Castro', '42342343', '4634646463', 'Masculino', 2),
(93, 'Nicolas', 'Bustamante', '35346463', '4363463463', 'Masculino', 2),
(94, 'Martín Jorge', 'Gomez', '42675488', '3804987654', 'Otro', 5),
(95, 'Jonas', 'Edwing', '86675636', '8556547865', 'Masculino', 4),
(96, 'Jonathan', 'Euliarte', '69304523', '0729563623', 'Masculino', 5),
(98, 'Alberto', 'Sanchez', '34987678', '3804986545', 'Otro', 2),
(99, 'Jose Manuel', 'Fernandez', '42365423', '3804987359', 'Masculino', 4),
(101, 'Martin Andrés', 'Oliva', '36854634', '3804989896', 'Masculino', 1),
(102, 'Alexis Ramon', 'Cativa', '42987647', '3804213976', 'Masculino', 1),
(104, 'Rodrigo', 'Bueno', '47583653', '3804975943', 'Otro', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expedientes`
--

CREATE TABLE `expedientes` (
  `expediente_numero` int NOT NULL,
  `expediente_titulo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `expediente_descripcion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci,
  `expediente_fechaCreacion` datetime NOT NULL,
  `expediente_fechaModificacion` datetime DEFAULT NULL,
  `expediente_estado` enum('pendiente','en_proceso','completado') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT 'pendiente',
  `expediente_responsable` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `rol_id` int NOT NULL,
  `rol_nombre` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `rol_descripcion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`rol_id`, `rol_nombre`, `rol_descripcion`) VALUES
(1, 'Administrador', NULL),
(2, 'Usuario', NULL),
(3, 'Auditor', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int NOT NULL,
  `usuario_usuario` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `usuario_clave` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `usuario_email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `empleado_id` int NOT NULL,
  `rol_id` int NOT NULL,
  `fecha_alta` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `usuario_usuario`, `usuario_clave`, `usuario_email`, `empleado_id`, `rol_id`, `fecha_alta`, `estado`) VALUES
(27, 'JoseCarrizo25', '$2y$10$7FqkrXoBfE/q73owQDk9kuJQzoruNUTyq9Q6HGb0iUzDESABrgRNW', 'josecarrizo25@gmail.com', 57, 1, '2025-01-17 20:21:01', 1),
(29, 'AliciaCarrizo100', '$2y$10$kSenGYDFFFo4.OmudnCueuDkGO3yO.zYe0kL/LgKksMLEkFQmydDi', 'aliciacarrizo100@gmail.com', 63, 3, '2025-01-17 20:21:01', 1),
(31, 'AndreaBas17', '$2y$10$COG4Dm2aO60Hz28UvqeeI.Eg9tFjsB2MfNGx0ElIXqjCWX8/UO2.q', 'andreabasualdo@gmail.com', 66, 2, '2025-01-17 20:21:01', 1),
(36, 'JorgeGuille', '$2y$10$msCkprU09fL5G.Zr.6nAcO.q73XCGz51RzLdJOZEBIvrL/MsnG54S', 'JorgeGuille54@gmail.com', 80, 2, '2025-01-17 20:21:01', 1),
(37, 'AgusParedes', '$2y$10$5xyj2lDkvVuOtu3du9FM4O9.QEnPYqWDvvdk9eofUaAKYxGfY/dgC', 'AgusPAredes1@gmail.com', 81, 2, '2025-01-17 20:21:01', 1),
(39, 'LucasRodri63', '$2y$10$Q7ExCwKiIFCsL7lUQC19L.NnDwDh0EgqUCQkqCdgh4m7VxbDW8Cr6', 'LucasRodri63@gmail.com', 83, 2, '2025-01-17 20:21:01', 1),
(40, 'EduardoM', '$2y$10$j90T2Y3MwOW5w.O1USFKpuxgDjdRAMK7o.cGLi2IqMgpBousJMunS', 'gdhrh44@gmail.com', 84, 2, '2025-01-17 20:21:01', 1),
(42, 'ManuelU', '$2y$10$p69SHqmaN6OaZMpKZlcBgOSqWY462VW7jIJzl/JJRY2xt3DWj2riO', 'ManuBUS@gmail.com', 86, 2, '2025-01-17 20:21:01', 1),
(46, 'Silvio356', '$2y$10$qBgnGDhMnvS.T72KJ5HP8eMLrPKzw2McbGG4tJW2p4O.CkKVDafSO', 'SilvioMAnuel35@gmail.com', 90, 2, '2025-01-17 20:21:01', 0),
(47, 'AlejoNunez1', '$2y$10$dB4G4r.3sOfrX6Nx/mtXVe8ip3urfMhcUPNdCsLdCv8WCd4wkK2Qe', 'Alejandronunez@gmail.com', 91, 3, '2025-01-17 20:27:21', 1),
(48, 'JorgeC', '$2y$10$v5dXDrrmj1oGoewdwpQoSOBrjOeQV/p7.CzsqQgG0qDpMvRZVlQLa', 'JorgeC@gmail.com', 92, 2, '2025-01-17 21:16:04', 1),
(49, 'NicoB', '$2y$10$/MVA91rMl2JJl7yrj8pT7.FN7Ri5va56gDr7QKtCYI3w3ksgblBNu', 'NicolasB@gmail.com', 93, 2, '2025-01-17 21:16:27', 1),
(50, 'MArtinJ54', '$2y$10$BTlgSREGWifEzoy5o5gxNOBWHXn7ARhQ5qllH8t/tL6VgXlrdT9DS', 'MArtinJ54@gmail.com', 94, 3, '2025-01-17 21:16:49', 1),
(51, 'JonasE', '$2y$10$9CQ6lvAp67JxJtFE8XoWQON0mBnhoXDRu/MjIyh.RTPIvfiyxrDsi', 'JonasE@gmail.com', 95, 2, '2025-01-17 21:17:30', 1),
(52, 'JonatE', '$2y$10$qNjR.Klf3e7OtPNHOT7CyOtfvJV8/imhhM1ihBIbnMi7UHafzbNne', 'JonatE@gmail.com', 96, 2, '2025-01-17 21:19:37', 1),
(54, 'AlbertS', '$2y$10$4S8fGCUImJQ4ih.OiBc7VuzbnZH27NRg50poHv0E1AT4fNOx93zNa', 'AlbertS@gmail.com', 98, 2, '2025-01-21 13:51:56', 1),
(55, 'JoseFer23', '$2y$10$FCmJYW6fxVYRYO9UBSze3eUXhFE6jaiK/kTQWUvlgIvjLhIh2mo.O', 'JoseFer@gmail.com', 99, 3, '2025-01-21 14:12:50', 1),
(57, 'MartinOliva1', '$2y$10$RVf6JJueWGSFAW/jasQkzuR27ZLxwfyhMpfQZBJO7XfEH7/25zfF2', 'martinOliva12@gmail.com', 101, 1, '2025-01-27 09:46:04', 1),
(58, 'AlexisRC', '$2y$10$bm/VZVWS77Ia/mP4sV0yIO.k58a.TOwu8JAEj4duKts.756xwwEQK', 'AlexisRamon76@gmail.com', 102, 3, '2025-01-29 10:41:50', 1),
(59, 'RodriB', '$2y$10$vGQyBmxt.TGnkuhC/U1Lh.pgnaaGCSmYFsjYtNBBOI2J3X7j6VHYi', 'Rofrigobueno21@gmail.com', 104, 2, '2025-03-07 17:16:14', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`area_id`);

--
-- Indices de la tabla `cambios_expedientes`
--
ALTER TABLE `cambios_expedientes`
  ADD PRIMARY KEY (`cambio_id`),
  ADD KEY `expediente_id` (`expediente_id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`empleado_nroLegajo`),
  ADD UNIQUE KEY `empleado_dni` (`empleado_dni`),
  ADD KEY `area_id` (`area_id`),
  ADD KEY `idx_empleado_dni` (`empleado_dni`);

--
-- Indices de la tabla `expedientes`
--
ALTER TABLE `expedientes`
  ADD PRIMARY KEY (`expediente_numero`),
  ADD KEY `expediente_responsable` (`expediente_responsable`),
  ADD KEY `idx_expediente_estado` (`expediente_estado`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`rol_id`),
  ADD UNIQUE KEY `rol_nombre` (`rol_nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `usuario_alias` (`usuario_usuario`),
  ADD KEY `rol_id` (`rol_id`),
  ADD KEY `FK_usuario_empleado` (`empleado_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `area_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cambios_expedientes`
--
ALTER TABLE `cambios_expedientes`
  MODIFY `cambio_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `empleado_nroLegajo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT de la tabla `expedientes`
--
ALTER TABLE `expedientes`
  MODIFY `expediente_numero` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `rol_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cambios_expedientes`
--
ALTER TABLE `cambios_expedientes`
  ADD CONSTRAINT `cambios_expedientes_ibfk_1` FOREIGN KEY (`expediente_id`) REFERENCES `expedientes` (`expediente_numero`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`);

--
-- Filtros para la tabla `expedientes`
--
ALTER TABLE `expedientes`
  ADD CONSTRAINT `expedientes_ibfk_1` FOREIGN KEY (`expediente_responsable`) REFERENCES `usuarios` (`usuario_id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_usuario_empleado` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`empleado_nroLegajo`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`empleado_nroLegajo`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`rol_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
