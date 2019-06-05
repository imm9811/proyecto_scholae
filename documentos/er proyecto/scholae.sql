-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-06-2019 a las 19:06:20
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
(1, 'admin', 'correo@admin.com', '$2y$10$d.67570Cv/mhlMsr04CREeMbeXK0C9A01pdqWpYfA2JQfcWPMlAyu', 'imma', 'moreno moreno');

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
(2, 'Lateral'),
(3, 'Horario');

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
  `noticia_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `multimedia`
--

INSERT INTO `multimedia` (`id`, `url`, `noticia_id`) VALUES
(1, NULL, 1),
(2, 'archivprueba', 1),
(3, '590.jpg', 1),
(4, 'cms3.png', 4),
(5, 'cms3.svg', 4),
(6, 'Diseño sin título-2.pdf', 4),
(7, 'lang-ente01c-1024x733.png', 5);

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
(1, 'RobyCad - 2019\r\n\r\nPremio Ciclo Formativos ', 'Los alumnos del Ciclo Medio de Instalaciones Eléctricas y Automáticas han conseguido el primer premio en el certame RobyCad - 2019 celebrado en la U.C.A.\r\n\r\nEste certamen se viene celebrando todos durante varios años en el mes de mayo en la Facultad de Ingeniería en Puerto Real, el alumnado de muchos institutos de la comarca muestran su trabajos realizados con Arduino. ¡Esperamos volver a participar el próximo curso!\r\n<a href=\"www.google.com\">Robicad</a>', 1, 1),
(2, 'prueba2', 'asdasdasdasd', 2, 1),
(3, 'prueba video', '<p>asdasdasd</p>\r\n', 1, 3),
(4, 'prueba final ahora lo sabremos', '<p>adasdasdasdasasdasd</p>\r\n', 1, 4),
(5, 'Sube el precio del langostino de Sanlúcar', '<p>Desde hoy debido al Roc&iacute;o el kilo de langostino ha sufrido un<strong> gran incremento </strong>superando los 100 euros el kilo</p>\r\n', 1, 5);

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
-- Volcado de datos para la tabla `plataforma`
--

INSERT INTO `plataforma` (`id`, `titulo`, `foto`, `enlace`) VALUES
(3, 'pasen', 'pasen.png', 'https://www.juntadeandalucia.es/educacion/portalseneca/web/pasen/inicio');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `multimedia`
--
ALTER TABLE `multimedia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `plataforma`
--
ALTER TABLE `plataforma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
