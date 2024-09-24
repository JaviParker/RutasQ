-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 23-09-2024 a las 23:09:24
-- Versión del servidor: 8.2.0
-- Versión de PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `rutas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `clienteid` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `clientenombre` varchar(100) DEFAULT NULL,
  `clientenumero` int DEFAULT NULL,
  `clientefecha` date DEFAULT NULL,
  `clienteestatus` int DEFAULT NULL,
  `sucursalid` int DEFAULT NULL,
  `usuarioid` int DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`clienteid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`clienteid`, `clientenombre`, `clientenumero`, `clientefecha`, `clienteestatus`, `sucursalid`, `usuarioid`, `updated_at`, `created_at`) VALUES
(1, 'JUAN PABLO MARTINEZ PEREZ', 1001, '2024-09-06', 1, 2, NULL, '2024-09-08', '2024-09-06'),
(2, 'PEDRO', 200, '2024-09-06', 1, 1, NULL, '2024-09-06', '2024-09-06'),
(3, 'PEDRO', 1234, '2024-09-08', 1, 1, NULL, '2024-09-08', '2024-09-08'),
(4, 'maria', 1, '2024-09-08', 1, 2, NULL, '2024-09-08', '2024-09-08'),
(5, 'maria', 1, '2024-09-08', 1, 3, NULL, '2024-09-08', '2024-09-08'),
(6, 'qwqwqw', 1, '2024-09-08', 1, 1, NULL, '2024-09-08', '2024-09-08'),
(7, 'JUAN PABLO MORENO REYES', 144, '2024-09-08', 1, 1, NULL, '2024-09-08', '2024-09-08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

DROP TABLE IF EXISTS `inventario`;
CREATE TABLE IF NOT EXISTS `inventario` (
  `inventario_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `producto_id` int UNSIGNED NOT NULL,
  `cantidad_disponible` int UNSIGNED NOT NULL,
  `tienda_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`inventario_id`),
  KEY `producto_id` (`producto_id`),
  KEY `tienda_id` (`tienda_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
CREATE TABLE IF NOT EXISTS `notificaciones` (
  `notificacion_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `mensaje` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL,
  `remitente_id` int UNSIGNED NOT NULL,
  `destinatario_id` int UNSIGNED NOT NULL,
  `tipo_notificacion` enum('Productos acabados','Oferta especial','Otros') NOT NULL,
  PRIMARY KEY (`notificacion_id`),
  KEY `remitente_id` (`remitente_id`),
  KEY `destinatario_id` (`destinatario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion_repartidor`
--

DROP TABLE IF EXISTS `notificacion_repartidor`;
CREATE TABLE IF NOT EXISTS `notificacion_repartidor` (
  `notificacion_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `mensaje` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL,
  `remitente_id` int UNSIGNED NOT NULL,
  `destinatario_id` int UNSIGNED NOT NULL,
  `tipo_notificacion` enum('Bloqueo de ruta','Cambios en la ruta','Otros') NOT NULL,
  PRIMARY KEY (`notificacion_id`),
  KEY `remitente_id` (`remitente_id`),
  KEY `destinatario_id` (`destinatario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametro`
--

DROP TABLE IF EXISTS `parametro`;
CREATE TABLE IF NOT EXISTS `parametro` (
  `parametroid` int NOT NULL AUTO_INCREMENT,
  `parametronombre` varchar(200) DEFAULT NULL,
  `parametrodescripcion` varchar(200) DEFAULT NULL,
  `parametrovalor` decimal(10,2) DEFAULT NULL,
  `parametrofecha` date DEFAULT NULL,
  `parametroestatus` int DEFAULT NULL,
  `usuarioid` int DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`parametroid`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `parametro`
--

INSERT INTO `parametro` (`parametroid`, `parametronombre`, `parametrodescripcion`, `parametrovalor`, `parametrofecha`, `parametroestatus`, `usuarioid`, `updated_at`, `created_at`) VALUES
(1, 'qwqwqw', 'qwqwqw', 45.00, '2024-09-02', 1, 1, '2024-09-09', '2023-08-31'),
(2, 'DOLARES', NULL, 17.10, '2024-06-16', 2, 1, '2024-09-09', '2024-04-18'),
(3, 'casa', NULL, NULL, '2024-01-12', 1, 1, '2024-08-06', '2024-08-06'),
(4, 'NOMBRE', 'NOMBRE', 0.00, '2024-07-20', 1, NULL, '2024-09-01', '2024-09-01'),
(5, 'weweqw', 'qweqwe', 0.00, '2024-07-20', 1, NULL, '2024-09-01', '2024-09-01'),
(6, 'hhhh', 'hhhhh', 1.00, '2024-07-20', 1, 4, '2024-09-01', '2024-09-01'),
(7, '1111', '111', 0.00, '2024-07-20', 1, 4, '2024-09-01', '2024-09-01'),
(8, 'asdasasasas', 'asasasas', 1.00, '2024-07-20', 1, 4, '2024-09-01', '2024-09-01'),
(9, 'FECHA', 'FECHA DEL SISTEMA', 1.00, '2024-09-02', 1, 4, '2024-09-01', '2024-09-01'),
(10, 'qwqw', 'qwqw', 1.00, '2024-07-20', 1, 4, '2024-09-01', '2024-09-01'),
(11, 'wqwe', 'wewe', 1.00, '2024-07-20', 1, 4, '2024-09-02', '2024-09-01'),
(12, 'tttt', 'ttttt', 3.00, '2024-07-20', 1, 4, '2024-09-02', '2024-09-01'),
(13, 'CALLE', 'CALLE', 1.00, '2024-09-06', 1, 4, '2024-09-02', '2024-09-02'),
(14, 'DOLARES', 'TOTAL DE DOLARES', 18.20, '2024-09-02', 1, 4, '2024-09-03', '2024-09-02'),
(15, 'EDITAR', 'EDITA', 4.00, '2024-10-01', 1, 4, '2024-09-02', '2024-09-02'),
(16, 'OTRO', 'OTRO', 0.00, '2024-09-02', 1, 27, '2024-09-08', '2024-09-08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE IF NOT EXISTS `pedido` (
  `pedidoid` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `clienteid` int UNSIGNED NOT NULL,
  `pedido_fecha` date NOT NULL,
  `pedido_total` decimal(10,2) NOT NULL,
  `pedido_faltantes_confirmados` tinyint(1) DEFAULT '0',
  `pedido_por_confirmar` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`pedidoid`),
  KEY `clienteid` (`clienteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_productos`
--

DROP TABLE IF EXISTS `pedido_productos`;
CREATE TABLE IF NOT EXISTS `pedido_productos` (
  `pedidoid` int UNSIGNED NOT NULL,
  `productoid` int UNSIGNED NOT NULL,
  `cantidad` int NOT NULL,
  KEY `pedidoid` (`pedidoid`),
  KEY `productoid` (`productoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `productoid` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `productonombre` varchar(100) NOT NULL,
  `productoprecio` decimal(10,2) NOT NULL,
  `productostock` int NOT NULL,
  `producto_minimo_stock` int NOT NULL DEFAULT '10' COMMENT 'Nivel mínimo de stock antes de notificar',
  `cantidad_minima` int UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`productoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `rolid` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `rolnombre` varchar(100) DEFAULT NULL,
  `rolfecha` date DEFAULT NULL,
  `rolestatus` int DEFAULT NULL,
  `usuarioid` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`rolid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`rolid`, `rolnombre`, `rolfecha`, `rolestatus`, `usuarioid`, `created_at`, `updated_at`) VALUES
(1, 'ADMINISTRADOR', '2024-09-03', 1, 4, '2024-09-03', '2024-09-03'),
(2, 'LIQUIDACION', '2024-09-03', 1, 4, '2024-09-03', '2024-09-03'),
(3, 'SUPERVISOR', '2024-09-03', 1, 4, '2024-09-03', '2024-09-03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ruta`
--

DROP TABLE IF EXISTS `ruta`;
CREATE TABLE IF NOT EXISTS `ruta` (
  `ruta_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ruta_nombre` varchar(100) NOT NULL,
  `ruta_descripcion` text,
  `ruta_producto_id` int UNSIGNED NOT NULL,
  `ruta_cantidad_vendida` int UNSIGNED NOT NULL,
  `ruta_cantidad_disponible` int UNSIGNED NOT NULL,
  PRIMARY KEY (`ruta_id`),
  KEY `ruta_producto_id` (`ruta_producto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

DROP TABLE IF EXISTS `sucursal`;
CREATE TABLE IF NOT EXISTS `sucursal` (
  `sucursalid` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `sucursalnombre` varchar(100) DEFAULT NULL,
  `sucursalfecha` date DEFAULT NULL,
  `sucursalestatus` int DEFAULT NULL,
  `usuarioid` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`sucursalid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`sucursalid`, `sucursalnombre`, `sucursalfecha`, `sucursalestatus`, `usuarioid`, `created_at`, `updated_at`) VALUES
(1, 'SERVICIO BENITO S.A. DE C.V.', '2024-09-04', 1, 4, '2024-09-04', '2024-09-04'),
(2, 'GASOLINERIA Y SERVICIOS LA VILLA S.A. DE C.V.', '2024-09-04', 1, 4, '2024-09-04', '2024-09-04'),
(3, 'AUTOTRANSPORTES DE COMBUSTIBLES BENITO S.A. DE C.V.', '2024-09-04', 1, 4, '2024-09-04', '2024-09-04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `usuarioid` int NOT NULL AUTO_INCREMENT,
  `usuarionombre` varchar(100) DEFAULT NULL,
  `usuariomail` varchar(100) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `usuariopassword` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `usuarioestatus` int DEFAULT NULL,
  `rolid` int DEFAULT NULL,
  `sucursalid` int DEFAULT NULL,
  `tipo_usuario` enum('admin','repartidor','cliente') NOT NULL COMMENT 'Tipo de usuario para determinar permisos y notificaciones',
  PRIMARY KEY (`usuarioid`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`usuarioid`, `usuarionombre`, `usuariomail`, `usuario`, `usuariopassword`, `created_at`, `updated_at`, `remember_token`, `usuarioestatus`, `rolid`, `sucursalid`, `tipo_usuario`) VALUES
(4, 'aaaa', 'aaa', 'aaa', '9834876dcfb05cb167a5c24953eba58c4ac89b1adf57f28f2f9d09af107ee8f0', '2021-09-13 01:17:00', '2024-09-05 21:10:53', NULL, 1, 1, 1, 'admin'),
(13, '5', 'aaa5', 'aaa5', '25b34c9a695e80827663ed3659e99df5c0b160e3ba3456643602b04e44d28fc9', '2022-11-27 17:49:10', '2024-09-05 21:13:41', NULL, 1, 15, 15, 'admin'),
(14, 'ANTONIO', 'CARLOS@HOTMAIL.COM', 'ANTONIO', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2022-11-27 17:49:44', '2024-05-25 12:33:40', NULL, 1, 1, 1, 'admin'),
(15, 'ENRIQUE', 'KIKE@hotmail.com', 'KIKE', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2023-08-11 15:04:19', '2023-08-11 15:07:26', NULL, 1, 1, 1, 'admin'),
(16, 'ALEJANDRO', 'alex@hotmail.com', 'ALEX', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2023-08-11 15:05:00', '2023-08-11 15:07:42', NULL, 1, 1, 1, 'admin'),
(17, 'MANUEL', 'antonio@hotmail.com', 'MANUEL', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2023-08-11 15:07:06', '2024-03-21 14:19:14', NULL, 1, 1, 1, 'admin'),
(18, 'JAVIER', 'JAVIS@HOTMAIL.COM', 'JAVIER', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2023-09-05 15:54:49', '2023-09-05 15:54:49', NULL, 1, 1, 1, 'admin'),
(19, 'ERICK', 'ERICK@HOTMAIL.COM', 'ERICK', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2023-09-05 15:55:11', '2023-09-05 15:55:11', NULL, 1, 1, 1, 'admin'),
(20, 'CHAVO', 'CHAVO@HOTMAIL.COM', 'CHAVO', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2023-09-05 15:55:33', '2023-09-05 15:55:33', NULL, 1, 1, 1, 'admin'),
(21, 'GERARDO', 'refugio@hotmail.com', 'GERARDO', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2023-09-06 11:49:10', '2023-10-15 16:17:20', NULL, 1, 1, 1, 'admin'),
(22, 'MARCELINO', 'marcelino@hotmail.com', 'MARCELINO', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2023-09-06 11:56:48', '2023-09-06 11:56:48', NULL, 1, 1, 1, 'admin'),
(23, 'REYNALDO', 'reynaldo@hotmail.com', 'REYNALDO', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2023-09-07 16:33:55', '2023-09-07 16:33:55', NULL, 1, 1, 1, 'admin'),
(24, 'POLLITO', 'pollito@hotmail.com', 'POLLITO', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2023-09-07 16:38:06', '2023-09-07 16:38:06', NULL, 1, 1, 1, 'admin'),
(25, 'CESAR MALDONADO', 'maldonado@hotmail.com', 'maldonado', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2024-03-25 20:29:45', '2024-05-01 13:01:37', NULL, 1, 1, 1, 'admin'),
(26, 'ALBERTO MAGALLANES', 'magallanes@hotmail.com', 'magallanes', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2024-03-25 20:30:48', '2024-06-02 18:34:26', NULL, 1, 1, 1, 'admin'),
(27, '1111', 'paez@hotmail.com', '1111', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2024-05-29 16:13:50', '2024-05-29 16:13:50', NULL, 1, 3, 1, 'admin'),
(28, 'pedro', 'pedro@hotmail.com', 'pedro', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2024-08-06 00:16:22', '2024-08-06 00:16:22', NULL, 1, 1, NULL, 'admin'),
(29, 'pedro', 'pedro@hotmail.com', 'pedro', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2024-08-06 00:19:58', '2024-08-06 00:19:58', NULL, 1, 1, NULL, 'admin'),
(30, 'pedro', 'pedro@hotmail.com', 'pedro', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2024-08-06 00:20:49', '2024-08-06 00:20:49', NULL, 1, 1, NULL, 'admin'),
(31, 'juan', 'pedro@hotmail.com', 'pedro', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2024-08-06 00:21:23', '2024-08-06 00:21:23', NULL, 1, 1, NULL, 'admin'),
(32, 'JUAN PEREZ', 'juanperez@hotmail.com', 'JUAN', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2024-09-04 04:18:12', '2024-09-05 21:19:43', NULL, 1, 2, 2, 'admin'),
(33, 'JORGE ANTONIO PAEZ', 'PAEZ@HOTMAIL.COM', 'PAEZ', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2024-09-05 17:03:29', '2024-09-05 21:18:21', NULL, 1, 2, 2, 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
