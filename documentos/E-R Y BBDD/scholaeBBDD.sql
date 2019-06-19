-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-06-2019 a las 01:54:15
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `scholae`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `contrasena` varchar(300) DEFAULT NULL,
  `alias` varchar(150) DEFAULT NULL,
  `apellidos` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id`, `nombre`, `correo`, `contrasena`, `alias`, `apellidos`) VALUES
(1, 'admin', 'correo@admin.com', '$2y$10$d.67570Cv/mhlMsr04CREeMbeXK0C9A01pdqWpYfA2JQfcWPMlAyu', 'imma', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`) VALUES
(1, 'Principal'),
(2, 'Lateral');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configs`
--

CREATE TABLE `configs` (
  `param` varchar(100) NOT NULL,
  `type` varchar(45) NOT NULL,
  `value` text,
  `value_en` text,
  `title` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `configs`
--

INSERT INTO `configs` (`param`, `type`, `value`, `value_en`, `title`, `title_en`) VALUES
('about_us', 'textarea', NULL, '<p>About us</p>', 'Sobre Nosotros (ES)', 'Sobre Nosotros (EN)'),
('activeModules', 'text', ';content;news;category;configs;user;headers;', NULL, '', NULL),
('address_page', 'textarea', NULL, 'nombre<div>Dirección</div><div>11403 · Jerez · Cádiz · España </div><div></div>', 'Dirección (ES)', 'Dirección (EN)'),
('base_url', 'text', 'http://proyectocholae.tk', NULL, 'Url Base Relativa', NULL),
('email', 'text', NULL, 'info@werwer.es', 'Emails (puede indicar más de 1 separado por , (ES)', 'Emails (puede indicar más de 1 separado por , (EN)'),
('facebook', 'text', 'https://www.facebook.com', NULL, 'Facebook', NULL),
('flickr', 'text', '', NULL, 'Flickr', NULL),
('map_location', 'map', '', '', 'Mapa de Google (ES)', 'Mapa de Google (EN)'),
('phone', 'text', '', '000 000 000', 'Teléfono (ES)', 'Teléfono (EN)'),
('title_page', 'text', NULL, NULL, 'Título Página', NULL),
('twitter', 'text', '', NULL, 'Twitter', NULL),
('vimeo', 'text', '', NULL, 'Vimeo', NULL),
('website', 'text', NULL, NULL, 'Web General', NULL),
('websitemm', 'text', NULL, NULL, 'Path Multimedia', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `multimedia`
--

CREATE TABLE `multimedia` (
  `id` int(11) NOT NULL,
  `url` text,
  `eliminado` tinyint(4) NOT NULL DEFAULT '0',
  `noticia_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `descripcion` text,
  `categoria_id` int(11) DEFAULT NULL,
  `multimedia_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`id`, `titulo`, `descripcion`, `categoria_id`, `multimedia_id`) VALUES
(1, 'RobyCad - 2019Premio Ciclo Formativos ', '<p>Los alumnos del Ciclo Medio de Instalaciones El&eacute;ctricas y Autom&aacute;ticas han conseguido el primer premio en el certame RobyCad - 2019 celebrado en la U.C.A. Este certamen se viene celebrando todos durante varios a&ntilde;os en el mes de mayo en la Facultad de Ingenier&iacute;a en Puerto Real, el alumnado de muchos institutos de la comarca muestran su trabajos realizados con Arduino. &iexcl;Esperamos volver a participar el pr&oacute;ximo curso! <a href=\"www.google.com\">Robicad</a></p>\r\n', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plataforma`
--

CREATE TABLE `plataforma` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `enlace` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`param`);

--
-- Indices de la tabla `multimedia`
--
ALTER TABLE `multimedia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `plataforma`
--
ALTER TABLE `plataforma`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `multimedia`
--
ALTER TABLE `multimedia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `plataforma`
--
ALTER TABLE `plataforma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
