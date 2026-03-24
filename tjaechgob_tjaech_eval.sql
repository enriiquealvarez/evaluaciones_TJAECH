-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 02-03-2026 a las 11:06:50
-- Versión del servidor: 8.0.45
-- Versión de PHP: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tjaechgob_tjaech_eval`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password_hash` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `admins`
--

INSERT INTO `admins` (`id`, `nombre`, `email`, `password_hash`, `activo`, `last_login_at`, `created_at`) VALUES
(1, 'Administrador', 'informatica@tjaech.gob.mx', '$2y$10$53.eKmJhvtrKn2BOJcxyteFCp0oY29KBMmPHXazZ9qBpGecDPAWZW', 1, '2026-02-17 10:59:42', '2026-01-30 14:49:30'),
(2, 'Selene Guadalupe Zepeda García', 'selenegzepedagarcia@gmail.com', '$2y$10$tRD96Xwqcmr2HU65qdTCk.2pG0RsQQfH/VTvt0zQIFY6QF7m3yKrK', 1, '2026-03-02 10:05:07', '2026-02-03 11:20:51'),
(3, 'Luis Enrique', 'luenalgo@gmail.com', '$2y$10$Ojwzl6l3gQtlWmhiggyxzeyvjYvCR1cKYruHxNkJf3Sn3foPRz.fO', 1, '2026-02-23 14:51:10', '2026-02-03 12:08:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` int NOT NULL,
  `admin_id` int NOT NULL,
  `token_hash` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `email` varchar(190) NOT NULL,
  `code_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `admin_password_resets`
--

INSERT INTO `admin_password_resets` (`id`, `admin_id`, `token_hash`, `expires_at`, `used_at`, `created_at`, `email`, `code_hash`) VALUES
(1, 3, '$2y$10$y0pfGHD9DxqUXKiyaZaFFOa57oFanWrXAVghfTR0z1mofRlsDkeeC', '2026-02-03 12:23:40', '2026-02-03 12:10:21', '2026-02-03 12:08:40', '', ''),
(2, 3, '$2y$10$0pvxNTJAt2wEqRr5/X.xTOsuQ7QKwOnIwuZK68Him1wG/de9xcneG', '2026-02-03 12:25:21', '2026-02-03 12:10:40', '2026-02-03 12:10:21', '', ''),
(3, 3, '$2y$10$uruWrnpNpwBLZ5RzGPtii.CZJd1VcEmRvngbO8AVYuExtirnQr5O2', '2026-02-03 12:35:22', '2026-02-03 12:22:51', '2026-02-03 12:20:22', '', ''),
(4, 3, '$2y$10$ZwO0bRuGlDi115RIL/AgFefe1t9FMAMTvI7KdnuhMsXxzkmNFGlKy', '2026-02-03 12:37:51', '2026-02-03 12:23:02', '2026-02-03 12:22:51', '', ''),
(5, 3, '$2y$10$lJ5UekaD2QNlqm8/5QaiYeIpaVSjjAB1FW9rgpPSMUSkPO2zhUssS', '2026-02-03 12:38:02', '2026-02-03 12:28:48', '2026-02-03 12:23:02', '', ''),
(6, 3, '$2y$10$lA9DLLi8BhU.T4bP7V5IRuKhg/s5wD6PAYcoBUn5BqH0waF92ArxG', '2026-02-03 12:43:48', '2026-02-03 12:29:57', '2026-02-03 12:28:48', '', ''),
(7, 3, '$2y$10$wWVcjlPvl5qaKVVyUIt/E.jEHdx2kCTHy/tJ4.txVckHfolgiXIei', '2026-02-03 12:44:58', '2026-02-03 12:30:09', '2026-02-03 12:29:58', '', ''),
(8, 3, '$2y$10$mQ3BiYJJ0Wp/kEvngmCqvew5JuT0Qnfawcql/SKJxaJQGqipBtsTa', '2026-02-03 12:45:09', '2026-02-03 12:30:26', '2026-02-03 12:30:09', '', ''),
(9, 3, '$2y$10$/xEpx1W/zTBCxinQkgU9Keck54.kREDubt1RKojsawDEPiKtr1C8K', '2026-02-03 12:46:23', '2026-02-03 12:39:32', '2026-02-03 12:31:23', '', ''),
(10, 3, '$2y$10$Du2NQs/QlYdqXbjkDL4TvOiIBcFzrrvxOpH101mXBptDUMkpuDiTi', '2026-02-03 12:54:32', '2026-02-03 12:44:30', '2026-02-03 12:39:32', '', ''),
(11, 3, '$2y$10$bwjGQMfgRSjjFnryvzo4J.c9II/yrQFDNPO8rZbWkI5ZIrWpa/9BG', '2026-02-03 12:59:30', '2026-02-03 12:45:58', '2026-02-03 12:44:30', '', ''),
(12, 3, '$2y$10$MIuz0X36CcxtLL2.xBYzOuL0jA1zwrwjlWLNRwJv1xnZkkHpP0sZW', '2026-02-03 13:00:59', '2026-02-03 12:51:41', '2026-02-03 12:45:59', '', ''),
(13, 3, '$2y$10$9oEeaIYlCyHvi.THOUYTBeo/RI9YFzOKBJMCNP1vw/ixf2XvwWkTW', '2026-02-03 13:06:41', '2026-02-03 13:02:44', '2026-02-03 12:51:41', '', ''),
(14, 3, '$2y$10$jHlaNBrSdMbBbSYfHldXsearTNtOf3H0x9s6vK93XIFcAaAXRaI3y', '2026-02-03 13:17:44', '2026-02-03 13:03:17', '2026-02-03 13:02:44', '', ''),
(16, 3, '$2y$10$FiSiZUNg0JftbWWF0I16survTIoxZY4AHtgmmneoW10/Pw4njrPdO', '2026-02-06 09:40:11', '2026-02-06 09:25:59', '0000-00-00 00:00:00', 'luenalgo@gmail.com', ''),
(17, 3, '$2y$10$gHCnY8az.5HL9lZgnWrbMuS5DP/eCbtNHEDlZPs8OuWSZw1gsihS6', '2026-02-06 10:03:24', '2026-02-06 09:48:59', '0000-00-00 00:00:00', 'luenalgo@gmail.com', ''),
(18, 3, '$2y$10$Iyri2tsTaBiVChFgNw6HTeactCit7PsmtosRA14RSP4wsy3rz45oW', '2026-02-06 10:11:24', '2026-02-06 09:56:50', '0000-00-00 00:00:00', 'luenalgo@gmail.com', ''),
(19, 3, '$2y$10$jh7u3Y7oHwS9OLNDRkmV3uCHkVj4DqK3h5dwoXAIP5vnC/yxsEFWy', '2026-02-09 12:47:33', '2026-02-09 12:33:28', '0000-00-00 00:00:00', 'luenalgo@gmail.com', ''),
(20, 3, '$2y$10$64syz6NuN2a4wWeqkCPlTuZpiMwxNW2J4LiFyHjfBZIkE7Wg2one2', '2026-02-16 17:04:09', '2026-02-17 12:12:44', '0000-00-00 00:00:00', 'luenalgo@gmail.com', ''),
(21, 1, '$2y$10$FVZtwbie.aLICX.SFK38UOjYgc82tMuFeMiod1UUre6PLsUPwhIMi', '2026-02-17 11:14:02', '2026-02-17 10:59:38', '0000-00-00 00:00:00', 'informatica@tjaech.gob.mx', ''),
(22, 3, '$2y$10$MQHaAWhuNwBAzUr5S3izd.jQe2v7MZSJaXsMNxfWzGztRodVgPIpq', '2026-02-17 12:27:04', '2026-02-17 12:12:44', '0000-00-00 00:00:00', 'luenalgo@gmail.com', ''),
(23, 2, '$2y$10$mH.r5/uJNhQGN5ieWSozsu3uG3uXG.zrSu2hCz7zv2JYqk5bK0EJC', '2026-02-17 13:47:17', '2026-02-17 13:33:37', '0000-00-00 00:00:00', 'selenegzepedagarcia@gmail.com', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_roles`
--

CREATE TABLE `admin_roles` (
  `admin_id` int NOT NULL,
  `role` enum('ADMIN','COURSES','EVALUATIONS','RESULTS','USERS') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `admin_roles`
--

INSERT INTO `admin_roles` (`admin_id`, `role`) VALUES
(1, 'ADMIN'),
(1, 'COURSES'),
(1, 'EVALUATIONS'),
(1, 'RESULTS'),
(1, 'USERS'),
(2, 'COURSES'),
(2, 'EVALUATIONS'),
(2, 'RESULTS'),
(3, 'ADMIN'),
(3, 'COURSES'),
(3, 'EVALUATIONS'),
(3, 'RESULTS'),
(3, 'USERS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `action` varchar(40) NOT NULL,
  `entity` varchar(60) NOT NULL,
  `entity_id` int NOT NULL,
  `ip` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificates`
--

CREATE TABLE `certificates` (
  `id` int NOT NULL,
  `participant_id` int NOT NULL,
  `course_id` int NOT NULL,
  `doc_type` varchar(40) NOT NULL,
  `status` enum('VERIFIED','NOT_VERIFIED') NOT NULL DEFAULT 'NOT_VERIFIED',
  `token` varchar(64) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courses`
--

CREATE TABLE `courses` (
  `id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `edition` varchar(80) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `modality` varchar(80) DEFAULT NULL,
  `area` varchar(120) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` int NOT NULL,
  `nombre` varchar(160) NOT NULL,
  `descripcion` text,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `terminado` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `nombre`, `descripcion`, `fecha_inicio`, `fecha_fin`, `activo`, `terminado`, `created_at`) VALUES
(1, 'Evaluación del “Programa de Capacitación en materia de responsabilidad administrativa y juicio contencioso administrativo”.', 'Evaluación del “Programa de Capacitación en materia de responsabilidad administrativa y juicio contencioso administrativo”.', '2026-01-28', '2026-01-30', 1, 1, '2026-01-30 14:53:33'),
(6, '\"Responsabilidades administrativas\"', 'Objetivo General: Fortalecer los conocimientos de los participantes en el régimen de responsabilidades administrativas, con el fin de prevenir conductas irregulares, promover la ética pública y asegurar el cumplimiento de las obligaciones legales en el ejercicio del servicio público.', '2026-02-24', '2026-02-26', 1, 0, '2026-02-20 10:42:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas_satisfaccion`
--

CREATE TABLE `encuestas_satisfaccion` (
  `id` int NOT NULL,
  `respuesta_id` int NOT NULL,
  `curso_id` int NOT NULL,
  `evaluacion_id` int NOT NULL,
  `folio` varchar(40) NOT NULL,
  `q1_satisfaccion_general` varchar(80) NOT NULL,
  `q2_calidad_contenidos` varchar(80) NOT NULL,
  `q3_organizacion_actividades` varchar(80) NOT NULL,
  `q4_utilidad_funciones` varchar(80) NOT NULL,
  `q5_recomendacion` varchar(80) NOT NULL,
  `comentarios` text,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `encuestas_satisfaccion`
--

INSERT INTO `encuestas_satisfaccion` (`id`, `respuesta_id`, `curso_id`, `evaluacion_id`, `folio`, `q1_satisfaccion_general`, `q2_calidad_contenidos`, `q3_organizacion_actividades`, `q4_utilidad_funciones`, `q5_recomendacion`, `comentarios`, `created_at`) VALUES
(7, 55, 6, 4, '63A24805-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:17:25'),
(8, 56, 6, 4, '66295B87-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:17:29'),
(9, 57, 6, 4, '33BC9AE5-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', 'Excelentes ponentes, y dan ejemplos muy claros a los temas impartidos', '2026-02-26 12:18:23'),
(10, 59, 6, 4, 'E9148FCF-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', 'Deberían tomar este curso todos los servidores públicos y funcionarios .', '2026-02-26 12:18:53'),
(11, 61, 6, 4, '235825FA-260226', 'Satisfecho/a', 'Buena', 'Buena', 'Utiles', 'Si, definitivamente', '', '2026-02-26 12:19:17'),
(12, 58, 6, 4, '787C28FA-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', 'Que estas capacitaciones sean mas constantes para que el desempeño de nuestras labores como servidores sean aun mejores.', '2026-02-26 12:19:24'),
(13, 63, 6, 4, 'B145BC18-260226', 'Satisfecho/a', 'Buena', 'Buena', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:19:37'),
(14, 60, 6, 4, '162DB78E-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', 'Agradecimiento por la capacitación', '2026-02-26 12:19:44'),
(15, 64, 6, 4, 'C6C6C63C-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:19:44'),
(17, 65, 6, 4, 'C45BAFE5-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:20:18'),
(18, 66, 6, 4, '6C063613-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:20:46'),
(19, 67, 6, 4, '78C42CF8-260226', 'Muy satisfecho/a', 'Muy buena', 'Buena', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:20:57'),
(20, 70, 6, 4, '1CCEC316-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:21:37'),
(21, 68, 6, 4, '5C46CA0F-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', 'Fue un curso muy interesante de mucho aprendizaje', '2026-02-26 12:21:39'),
(22, 71, 6, 4, 'F87C90ED-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:22:39'),
(23, 69, 6, 4, '877DDD8B-260226', 'Satisfecho/a', 'Muy buena', 'Buena', 'Muy utiles', 'Si, definitivamente', 'Muchos aprendizajes', '2026-02-26 12:22:50'),
(24, 72, 6, 4, 'EFF65C56-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:24:02'),
(25, 74, 6, 4, 'DC320D7A-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:24:02'),
(26, 73, 6, 4, '726D40F8-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:24:21'),
(27, 75, 6, 4, '8385697F-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:24:31'),
(28, 76, 6, 4, 'ACF013E9-260226', 'Muy satisfecho/a', 'Muy buena', 'Buena', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:24:38'),
(31, 78, 6, 4, '2CBA29CF-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:25:42'),
(32, 80, 6, 4, 'E4EC6CE8-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:26:18'),
(33, 83, 6, 4, '74F81947-260226', 'Satisfecho/a', 'Muy buena', 'Excelente', 'Utiles', 'Si, definitivamente', '', '2026-02-26 12:27:41'),
(35, 84, 6, 4, '7A4707F0-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', 'Gracias por el apoyo', '2026-02-26 12:28:17'),
(36, 85, 6, 4, '56B9B3D7-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:28:21'),
(37, 82, 6, 4, '8A88D217-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', 'Excelente temas impartidos', '2026-02-26 12:28:27'),
(38, 86, 6, 4, '4E8A441C-260226', 'Satisfecho/a', 'Buena', 'Buena', 'Utiles', 'Si, definitivamente', '', '2026-02-26 12:29:27'),
(39, 89, 6, 4, 'F5823DB3-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 12:39:11'),
(40, 88, 6, 4, '8A744CCE-260226', 'Satisfecho/a', 'Buena', 'Excelente', 'Utiles', 'Si, definitivamente', '', '2026-02-26 12:39:17'),
(41, 90, 6, 4, '7B03539C-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', '', '2026-02-26 13:46:07'),
(42, 91, 6, 4, '08EEE45F-260226', 'Satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', 'espero poder llevar otros cursos mas', '2026-02-26 14:32:24'),
(43, 92, 6, 4, '95505832-260226', 'Muy satisfecho/a', 'Muy buena', 'Excelente', 'Muy utiles', 'Si, definitivamente', 'AGRADECIDA POR LOS CONOCIMIENTOS ADQUIRIDOS DE PARTE DE QUIENES  DIERON EL CURSO,  MUY EXPLICITOS EN TODO MOMENTO', '2026-02-26 14:34:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones`
--

CREATE TABLE `evaluaciones` (
  `id` int NOT NULL,
  `curso_id` int NOT NULL,
  `titulo` varchar(160) NOT NULL,
  `descripcion` text,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `evaluaciones`
--

INSERT INTO `evaluaciones` (`id`, `curso_id`, `titulo`, `descripcion`, `activo`, `created_at`) VALUES
(1, 1, 'Impartido por el Tribunal de Justicia Administrativa del Estado de Chiapas, dirigido al personal del Ayuntamiento de Tapachula.', '', 1, '2026-01-30 14:59:40'),
(4, 6, 'Evaluación del programa de capacitación en materia de \"Responsabilidades Administrativas\", dirigido a personal del Ayuntamiento de Berriozabal, Chiapas.', 'Lea cuidadosamente cada pregunta y de las opciones proporcionadas, selecciones la respuesta correcta.', 1, '2026-02-26 10:54:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones_curso`
--

CREATE TABLE `inscripciones_curso` (
  `id` int NOT NULL,
  `curso_id` int NOT NULL,
  `nombre_completo` varchar(160) NOT NULL,
  `edad` tinyint UNSIGNED NOT NULL,
  `genero` varchar(40) NOT NULL,
  `correo` varchar(120) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `institucion` varchar(200) NOT NULL,
  `cargo_puesto` varchar(160) NOT NULL,
  `grado_estudios` varchar(80) NOT NULL,
  `grado_otro` varchar(160) DEFAULT NULL,
  `colectivos_json` text,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `inscripciones_curso`
--

INSERT INTO `inscripciones_curso` (`id`, `curso_id`, `nombre_completo`, `edad`, `genero`, `correo`, `telefono`, `institucion`, `cargo_puesto`, `grado_estudios`, `grado_otro`, `colectivos_json`, `created_at`) VALUES
(5, 6, 'Luis Gerardo Alvarado Álvarez', 29, 'Hombre', 'alvarado.g31@gmail.com', '9635657050', 'Tribunal de Justicia', 'A. Administrativo', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-20 10:45:42'),
(6, 1, 'Luis Gerardo Alvarado Álvarez', 29, 'Hombre', 'alvarado.g31@gmail.com', '9635657050', 'Tribunal de Justicia', 'A. Administrativo', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-20 10:56:12'),
(7, 1, 'iralda luna', 36, 'Mujer', 'lunairalda@gmail.com', '9671616828', 'Tribunal de Justicia Administrativa', 'Particular', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-20 11:16:29'),
(8, 6, 'Ray erick Antonio Gutiérrez Vázquez', 32, 'Hombre', 'erickgtzdiaz26@gmail.com', '9514557737', 'Protección civil', 'Apoyo juridico', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 10:30:09'),
(9, 6, 'Jorge Luis Martínez Montes de Oca', 50, 'Hombre', 'licjorgeluismmo2801@gmail.com', '9616606253', 'Secretaría de Protección Civil Berriozábal', 'Administrativo', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 10:37:29'),
(10, 6, 'JOSE ALFONSO JIMENEZ GOMEZ', 42, 'Hombre', 'jose4jimnez33@gmail.com', '9612006998', 'proteccion civil', 'administrativo', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 10:53:43'),
(11, 6, 'Oscar Reynosa Colmenares', 39, 'Hombre', 'oscarrc500@gmail.com', '9611316249', 'Ayuntamiento de Berriozábal', 'Secretario Ejecutivo del Consejo Municipal de Seguridad Pública', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 11:01:49'),
(12, 6, 'Lorena Guadalupe López Alcantar', 39, 'Mujer', 'sogarased212@gmail.com', '9614512564', 'Secretaria de seguridad publica y transito municipal', 'Inspector general', 'Educación media superior', '', '[\"Ninguno\"]', '2026-02-23 11:02:57'),
(13, 6, 'Luis Gerardo Roblero de los Santos', 37, 'Hombre', 'lroblerodelossantos@gmail.com', '9611749223', 'H. Ayuntamiento de Berriozabal', 'Autoridad Sustanciadora', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 11:03:05'),
(14, 6, 'Asunción Martinez Moreno', 30, 'Mujer', 'angelesmartinez75345@gmail.com', '9614371054', 'Secretaria de seguridad y transito municipal', 'Sub inspector', 'Educación media superior', '', '[\"Ninguno\"]', '2026-02-23 11:03:51'),
(15, 6, 'Elmer de Jesús Velázquez Natarén', 33, 'Hombre', 'elmerjvelazquezn@hotmail.com', '9613603938', 'Ayuntamiento de Berriozábal', 'Director de Diversidad Sexual', 'Licenciatura', '', '[\"Diversidad sexual y de género (LGBTIQ+)\"]', '2026-02-23 11:06:25'),
(16, 6, 'Dulce Belén Cruz Gálvez', 42, 'Mujer', 'dulcebelengalvezcruz@gmail.com', '9612360771', 'Consejo municipal de seguridad pública', 'Operadora de la Junta de Reclutamiento del Servicio Militar', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 11:09:07'),
(17, 6, 'JESSICA CECILIA LÓPEZ DE LOS SANTOS', 31, 'Mujer', 'jessica.cecilialpz.s@hotmail.com', '9614424648', 'H. Ayntamiento Municipal de Berriozábal, Chiapas', 'Auxiliar Administrativo', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 11:10:38'),
(18, 6, 'Mauricio Morales Chanona', 30, 'Hombre', 'mauriciochanona268@gmail.com', '5653110954', 'Secretaría de Seguridad Pública y Tránsito Municipal', 'Oficial Táctico', 'Educación media superior', '', '[\"Ninguno\"]', '2026-02-23 11:10:52'),
(19, 6, 'Humberto moreno pereyra', 43, 'Hombre', 'humbertomoreno2410@gmail.com', '9611394033', 'Secretaria de seguridad pública y transito municipal de berriozabal', 'Sub. Inspector', 'Otro', 'Secundaria', '[\"Prefiero no responder\"]', '2026-02-23 11:17:49'),
(20, 6, 'antonny enrique ochoa lópez', 33, 'Hombre', 'rokanlover05@gmail.com', '9616081939', 'Honorable Ayuntamiento de Berriozábal', 'Asesor Juridico', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 11:25:38'),
(21, 6, 'Abner Jhovanny Álvarez Hernández', 23, 'Hombre', 'sharawyalvarez@gmail.com', '9614617202', 'Sistema de agua potable y alcantarillado municipal', 'Administrativo', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 11:27:36'),
(22, 6, 'Kevin Josué López Ovando', 19, 'Hombre', 'kevinlopezovando283@gmail.com', '9614479989', 'H. Ayuntamiento municipal de Berriozábal, Chiapas', 'Administrativo', 'Educación media superior', '', '[\"Ninguno\"]', '2026-02-23 11:31:32'),
(23, 6, 'Belem Camacho Chávez', 25, 'Mujer', 'belemcamachochavez@gmail.com', '9611856747', 'H. Ayuntamiento de Berriozábal Chiapas', 'Administrativo', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 11:31:33'),
(24, 6, 'Banesa Diaz Espinosa', 35, 'Mujer', 'banesadiazespinosa@gmail.com', '9602408870', 'H. Ayuntamiento Municipal de Berriozabal', 'Juez Calificador', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 11:36:29'),
(25, 6, 'Mauricio Alvarez Jimenez', 30, 'Hombre', 'mauricio7.12@hotmail.com', '9611762064', 'Ayuntamiento de Berriozàbal', 'Auxiliar Juridico', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 11:38:38'),
(26, 6, 'KARLA GUADALUPE CASTAÑON RUIZ', 23, 'Mujer', 'kcastanonruiz@gmail.com', '9613682322', 'H. AYUNTAMIENTO BERRIOZABAL', 'DEFENSORA DE DERECHOS HUMANOS MUNICIPAL', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 11:46:42'),
(27, 6, 'Beatriz Adriana Ovando Cárdenas', 38, 'Mujer', 'anjelkaleb@gmail.com', '9611130414', 'Secretaria de Seguridad Publica y Tránsito Municipal de Berriozábal', 'Administrativo', 'Educación media superior', '', '[\"Ninguno\"]', '2026-02-23 11:46:55'),
(28, 6, 'Maria  Luz Castañon Manga', 55, 'Mujer', 'lucicastanon1970@gmail.com', '9611172237', 'Presidencia Municipal', 'Jueza  Municipal', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 11:55:14'),
(29, 6, 'Sergio Roque Escobar', 51, 'Hombre', 'roquesergio018@gmail.com', '9611295568', 'Secretaria de seguridad pública y tránsito municipal', 'Policía primero', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 11:55:18'),
(30, 6, 'Luis Angel Pérez Pérez', 28, 'Hombre', 'lp3976634@gmail.com', '9612325489', 'Secretaria de seguridad pública y tránsito municipal', 'Policía Táctico', 'Educación media superior', '', '[\"Ninguno\"]', '2026-02-23 12:01:36'),
(31, 6, 'José Alfredo Cisneros Hernández', 39, 'Hombre', 'fredy.hdz0407@gmail.com', '9612875953', 'Ayuntamiento de Berriozábal', 'Autoridad investigadora', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 12:04:49'),
(32, 6, 'Karen Lissette Vazquez Vicente', 28, 'Mujer', 'vazquez_kl@hotmail.com', '9611557040', 'H. Ayuntamiento de Berriozabal', 'Administrativo', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 12:06:13'),
(33, 6, 'DALIA SANCHEZ GOMEZ', 34, 'Mujer', 'sanchezgomezdalia@gmail.com', '9612390552', 'GOBIERNO MUNICIPAL', 'auxiliar administrativo', 'Educación media superior', '', '[\"Ninguno\"]', '2026-02-23 12:20:08'),
(34, 6, 'Eduardo Hernández huerta', 39, 'Hombre', 'eduardohuerta2587@gmail.com', '9611862265', 'secretaria de economía municipal', 'administrativo', 'Educación media superior', '', '[\"Ninguno\"]', '2026-02-23 12:23:16'),
(35, 6, 'Erwin Fidel Gómez Sarmiento', 30, 'Hombre', 'erfigos13@gmail.com', '9612876959', 'Gobierno Municipal de Berriozábal', 'Director General', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 12:26:13'),
(36, 6, 'Jesús Eduardo de la Cruz Perez', 28, 'Hombre', 'yisuslalo2397@icloud.com', '9611549641', 'H. Ayuntamiento de Berriozabal', 'Coordinador de asuntos jurídicos ambientales', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 13:09:32'),
(37, 6, 'Rosario Isabel Rosales de leon', 20, 'Mujer', 'rosalesisabel379@gmail.com', '9612366286', 'SSPYTM', 'Operativo', 'Educación media superior', '', '[\"Ninguno\"]', '2026-02-23 13:55:29'),
(38, 6, 'Ayda Olivia Vazquez Vazquez', 39, 'Mujer', 'aydyvaz86@gmail.com', '9612029670', 'DIF Berriozabal', 'Auxiliar Administrativo', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 14:11:21'),
(39, 6, 'Yesmin marina sanchez', 39, 'Mujer', 'yesmin.marina@hotmail.com', '9613671437', 'H Ayuntamiento de berriozabal', 'Auxiliar administrativo', 'Educación media superior', '', '[\"Ninguno\"]', '2026-02-23 14:40:16'),
(40, 6, 'Yuri Yazmin  de la Cruz de la Cruz', 38, 'Mujer', 'yurin788@hotmail.com', '9613000107', 'Gobierno Municipal de Berriozábal', 'Directora', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 14:46:08'),
(41, 6, 'LIDIA BERENICE DOMINGUEZ MORALES', 37, 'Mujer', 'dominguezbere561@gmail.com', '9611814311', 'GOBIERNO MUNICIPAL DE BERRIOZÁBAL', 'AUXILIAR ADMINISTRATIVO', 'Educación media superior', '', '[\"Ninguno\"]', '2026-02-23 14:59:29'),
(42, 6, 'JUAN PABLO SALAZAR ESTRADA', 47, 'Hombre', 'jpsae78@gmail.com', '9612479384', 'Secretaria Economia Municipio de Berriozábal', 'Enlace SARE', 'Posgrado', '', '[\"Ninguno\"]', '2026-02-23 14:59:47'),
(43, 6, 'Pablo Pérez Aguilar.', 42, 'Hombre', 'jp5712959@gmail.com', '9618105965', 'Seguridad pública', 'Policía Táctico', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 15:03:05'),
(44, 6, 'Otoniel Imanol Pérez Sarmiento', 26, 'Hombre', 'otonielimanolp@gmail.com', '9613861666', 'Ayuntamiento de Berriozábal', 'Asesor Ventanilla Unica', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 15:16:39'),
(45, 6, 'CARLOS CESAR CASTAÑÓN DIAZ', 27, 'Hombre', 'sapamberrio1821@gmail.com', '9611442449', 'Sapam Berriozabal', 'Administrador General', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 15:44:27'),
(46, 6, 'Alexis Vázquez Castillejos', 23, 'Hombre', 'av242887@gmail.com', '9611100847', 'Secretaria de protección civil municipal', 'Brigadista', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 16:06:42'),
(47, 6, 'Ramiro Lira Cristiani', 50, 'Hombre', 'ramirolorca@gmail.com', '6183218903', 'Seguridad pública', 'Secretario', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-23 16:06:45'),
(48, 6, 'Jacob Zoma Gutierrez', 47, 'Hombre', 'zoma0922@hotmail.com', '9611291980', 'Ayuntamiento de Berriozabal, Chiapas', 'auxiliar Juridico', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-24 08:21:51'),
(49, 6, 'Luis Alonso Morales Pérez', 38, 'Hombre', 'luisalonsomoralesperez70@gmail.com', '9611943243', 'SSPYTM', 'Policía', 'Otro', 'Secundaria terminada', '[\"Ninguno\"]', '2026-02-24 08:31:48'),
(50, 6, 'Selene Zepeda Garcia', 36, 'Mujer', 'selenegzepedagarcia@gmail.com', '9612368560', 'Tribunal de Justicia Administrativa', 'Directora', 'Posgrado', '', '[\"Ninguno\"]', '2026-02-26 11:30:34'),
(51, 6, 'Alejandro Vásquez Cuevas', 25, 'Hombre', 'av5351721@gmail.ccom', '9711320356', 'Juzgado Especializado en Responsabilidad Administrativa del Tribunal de Justicia Administrativa del Estado de Chiapas', 'Auxiliar Administrativo B', 'Licenciatura', '', '[\"Ninguno\"]', '2026-02-26 13:07:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones_pregunta`
--

CREATE TABLE `opciones_pregunta` (
  `id` int NOT NULL,
  `pregunta_id` int NOT NULL,
  `texto` varchar(200) NOT NULL,
  `valor` varchar(200) NOT NULL,
  `es_correcta` tinyint(1) NOT NULL DEFAULT '0',
  `orden` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `opciones_pregunta`
--

INSERT INTO `opciones_pregunta` (`id`, `pregunta_id`, `texto`, `valor`, `es_correcta`, `orden`) VALUES
(124, 34, 'a)	Imparcialidad', 'a)	Imparcialidad', 1, 1),
(125, 34, 'b)	Ética', 'b)	Ética', 0, 2),
(126, 34, 'c)	Honestidad', 'c)	Honestidad', 0, 3),
(127, 34, 'd)	Integridad', 'd)	Integridad', 0, 4),
(128, 35, 'a)	Imparcialidad', 'a)	Imparcialidad', 0, 1),
(129, 35, 'b)	Ética', 'b)	Ética', 0, 2),
(130, 35, 'c)	Honestidad', 'c)	Honestidad', 0, 3),
(131, 35, 'd)	Integridad', 'd)	Integridad', 1, 4),
(132, 36, '14', '1', 1, 1),
(133, 36, '16', '1', 0, 2),
(134, 36, '17', '1', 0, 3),
(135, 36, '20', '2', 0, 4),
(136, 37, 'a)	Legalidad', 'a)	Legalidad', 0, 1),
(137, 37, 'b)	Disciplina', 'b)	Disciplina', 1, 2),
(138, 37, 'c)	Profesionalismo', 'c)	Profesionalismo', 0, 3),
(139, 37, 'd)	Eficiencia', 'd)	Eficiencia', 0, 4),
(140, 38, 'a)	un acuerdo elaborado por la autoridad investigadora.', 'a)	un acuerdo elaborado por la autoridad investigadora.', 1, 1),
(141, 38, 'b)	un acuerdo elaborado por la autoridad substanciadora.', 'b)	un acuerdo elaborado por la autoridad substanciadora.', 0, 2),
(142, 38, 'c)	la resolución del procedimiento administrativo.', 'c)	la resolución del procedimiento administrativo.', 0, 3),
(143, 39, 'a)	Siempre son dolosas.', 'a)	Siempre son dolosas.', 0, 1),
(144, 39, 'b)	Generalmente son culposas.', 'b)	Generalmente son culposas.', 1, 2),
(145, 39, 'c)	No ameritan una sanción.', 'c)	No ameritan una sanción.', 0, 3),
(146, 40, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', 1, 1),
(147, 40, 'b)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye el ofrecimiento de pruebas.', 'b)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye el ofrecimiento de pruebas.', 0, 2),
(148, 40, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', 0, 3),
(149, 41, 'a)	 La facultad de la administración para sancionar a los particulares.', 'a)	 La facultad de la administración para sancionar a los particulares.', 0, 1),
(150, 41, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', 1, 2),
(151, 41, 'c)	Un procedimiento interno de las dependencias públicas.', 'c)	Un procedimiento interno de las dependencias públicas.', 0, 3),
(152, 41, 'd)	Un medio de conciliación entre particulares.', 'd)	Un medio de conciliación entre particulares.', 0, 4),
(153, 42, 'a)	Ejecutar de inmediato los actos administrativos.', 'a)	Ejecutar de inmediato los actos administrativos.', 0, 1),
(154, 42, 'b)	Notificar sin necesidad de formalidades.', 'b)	Notificar sin necesidad de formalidades.', 0, 2),
(155, 42, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', 1, 3),
(156, 42, 'd)	Dictar resoluciones discrecionales.', 'd)	Dictar resoluciones discrecionales.', 0, 4),
(157, 43, 'a)	 Recurso de inconformidad y juicio de amparo.', 'a)	 Recurso de inconformidad y juicio de amparo.', 0, 1),
(158, 43, 'b)	 Recurso de apelación y revisión.', 'b)	 Recurso de apelación y revisión.', 0, 2),
(159, 43, 'c)	 Recurso de revocación y recurso de revisión.', 'c)	 Recurso de revocación y recurso de revisión.', 1, 3),
(160, 43, 'd)	 Juicio contencioso y revisión administrativa.', 'd)	 Juicio contencioso y revisión administrativa.', 0, 4),
(161, 44, 'a)	 Emisión de sentencia.', 'a)	 Emisión de sentencia.', 0, 1),
(162, 44, 'b)	Ejecución de la resolución.', 'b)	Ejecución de la resolución.', 0, 2),
(163, 44, 'c)	Etapa probatoria.', 'c)	Etapa probatoria.', 1, 3),
(164, 44, 'd)	Cumplimiento del fallo.', 'd)	Cumplimiento del fallo.', 0, 4),
(294, 80, 'a) Artículo 16', 'a) Artículo 16', 0, 1),
(295, 80, 'b) Artículo 14', 'b) Artículo 14', 0, 2),
(296, 80, 'c) Artículo 89', 'c) Artículo 89', 0, 3),
(297, 80, 'd) Artículo 108', 'd) Artículo 108', 1, 4),
(298, 81, 'a) Legalidad', 'a) Legalidad', 0, 1),
(299, 81, 'b) Progresividad', 'b) Progresividad', 0, 2),
(300, 81, 'c) Objetividad', 'c) Objetividad', 0, 3),
(301, 81, 'd) Subordinación al superior jerárquico', 'd) Subordinación al superior jerárquico', 1, 4),
(302, 82, 'a) Por medio de oficio', 'a) Por medio de oficio', 1, 1),
(303, 82, 'b) Verbalmente', 'b) Verbalmente', 0, 2),
(304, 82, 'c) Por medio de recursos humanos', 'c) Por medio de recursos humanos', 0, 3),
(305, 83, 'a) Únicamente por servidor publico identificable', 'a) Únicamente por servidor publico identificable', 0, 1),
(306, 83, 'b) Únicamente por particulares', 'b) Únicamente por particulares', 0, 2),
(307, 83, 'c) Por servidores públicos y particulares identificables', 'c) Por servidores públicos y particulares identificables', 0, 3),
(308, 83, 'd) Por particulares y servidores públicos sean identificables o no', 'd) Por particulares y servidores públicos sean identificables o no', 1, 4),
(309, 84, 'a) Imparcialidad', 'a) Imparcialidad', 1, 1),
(310, 84, 'b) Ética', 'b) Ética', 0, 2),
(311, 84, 'c) Integridad', 'c) Integridad', 0, 3),
(312, 84, 'd) Honestidad', 'd) Honestidad', 0, 4),
(313, 85, 'a) Dolosas', 'a) Dolosas', 0, 1),
(314, 85, 'b) Que fueron subsanadas espontáneamente', 'b) Que fueron subsanadas espontáneamente', 1, 2),
(315, 85, 'c) Errores intencionales', 'c) Errores intencionales', 0, 3),
(316, 85, 'd) Ninguna de las anteriores', 'd) Ninguna de las anteriores', 0, 4),
(317, 86, 'a) Sí', 'a) Sí', 1, 1),
(318, 86, 'b) No', 'b) No', 0, 2),
(319, 86, 'c) No siempre', 'c) No siempre', 0, 3),
(320, 86, 'd) Ninguna de las anteriores', 'd) Ninguna de las anteriores', 0, 4),
(321, 87, 'a) Sí', 'a) Sí', 1, 1),
(322, 87, 'b) No', 'b) No', 0, 2),
(323, 87, 'c) No siempre', 'c) No siempre', 0, 3),
(324, 87, 'd) Ninguna de las anteriores', 'd) Ninguna de las anteriores', 0, 4),
(325, 88, 'a) Siete años', 'a) Siete años', 1, 1),
(326, 88, 'b) Tres años', 'b) Tres años', 0, 2),
(327, 88, 'c) Dos años', 'c) Dos años', 0, 3),
(328, 88, 'd) No prescriben', 'd) No prescriben', 0, 4),
(329, 89, 'a) Grave', 'a) Grave', 0, 1),
(330, 89, 'b) No grave', 'b) No grave', 1, 2),
(331, 89, 'c) Es grave y no grave', 'c) Es grave y no grave', 0, 3),
(332, 89, 'd) No es una falta administrativa', 'd) No es una falta administrativa', 0, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participants`
--

CREATE TABLE `participants` (
  `id` int NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(120) DEFAULT NULL,
  `type` enum('INTERNAL','EXTERNAL') NOT NULL DEFAULT 'INTERNAL',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `token_hash` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` int NOT NULL,
  `evaluacion_id` int NOT NULL,
  `texto` varchar(500) NOT NULL,
  `tipo` enum('opcion','likert','si_no','abierta') NOT NULL,
  `requerido` tinyint(1) NOT NULL DEFAULT '0',
  `orden` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `evaluacion_id`, `texto`, `tipo`, `requerido`, `orden`) VALUES
(34, 1, '1.	La persona servidora pública debe actuar sin favoritismos, prejuicios o preferencia alguna.', 'opcion', 1, 1),
(35, 1, '2.	Implica ser coherente en la honestidad, entre lo que dice y lo que hace:', 'opcion', 1, 2),
(36, 1, '3.	El principio de legalidad tiene su base constitucional en el artículo:', 'opcion', 1, 3),
(37, 1, '4.	Implica actuar con  orden,  puntualidad,  y apego estricto a las normas internas de la institución; así como cumplir instrucciones legítimas, procedimientos oficiales, responsabilidades establecidas.', 'opcion', 1, 4),
(38, 1, '5.	La calificación de la falta es:', 'opcion', 1, 5),
(39, 1, '6.	Las faltas administrativas no graves:', 'opcion', 1, 6),
(40, 1, '7.	 El acuerdo de calificación de la falta:', 'opcion', 1, 7),
(41, 1, '8.	¿Qué es el control jurisdiccional?', 'opcion', 1, 8),
(42, 1, '9.	La garantía de audiencia prevista en el artículo 14 constitucional obliga a la autoridad a:', 'opcion', 1, 9),
(43, 1, '10.	¿Cuáles son los dos medios de impugnación en sede administrativa en el Estado de Chiapas?', 'opcion', 1, 10),
(44, 1, '11.	¿Cuál de las siguientes opciones forma parte de la fase instructiva del Juicio Contencioso Administrativo?', 'opcion', 1, 11),
(80, 4, '¿En qué artículo de la Constitución Política Mexicana encontramos la definición Constitucional de Servidor Público?', 'opcion', 1, 1),
(81, 4, 'Atender las instrucciones de los superiores jerárquicos es una obligación de los servidores públicos, mismo que le da certeza al principio de ______.', 'opcion', 0, 2),
(82, 4, '¿Cuál es la forma correcta de determinar funciones a los servidores públicos que carecen de atribuciones determinadas en norma?', 'opcion', 1, 3),
(83, 4, 'Las denuncias por presuntas faltas administrativas pueden ser:', 'opcion', 1, 4),
(84, 4, '¿A qué principio corresponde cuando la persona servidora pública debe actuar sin favoritismos, prejuicios o preferencia alguna?', 'opcion', 1, 5),
(85, 4, 'Las faltas administrativas no graves son omisiones:', 'opcion', 0, 6),
(86, 4, 'Las faltas administrativas no graves son conductas culposas:', 'opcion', 1, 7),
(87, 4, 'Las faltas administrativas graves son conductas dolosas:', 'opcion', 1, 8),
(88, 4, 'La facultad para sancionar faltas administrativas graves prescribe en:', 'opcion', 1, 9),
(89, 4, 'Abstenerse de integrar correctamente la documentación bajo su responsabilidad, es una falta administrativa:', 'opcion', 1, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` int NOT NULL,
  `curso_id` int NOT NULL,
  `evaluacion_id` int NOT NULL,
  `folio` varchar(40) NOT NULL,
  `nombre_completo` varchar(160) NOT NULL,
  `correo` varchar(120) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `municipio` varchar(120) NOT NULL,
  `cargo_puesto` varchar(160) NOT NULL,
  `comentarios` text,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` varchar(180) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id`, `curso_id`, `evaluacion_id`, `folio`, `nombre_completo`, `correo`, `telefono`, `municipio`, `cargo_puesto`, `comentarios`, `ip`, `user_agent`, `created_at`) VALUES
(2, 1, 1, '7DB34735-260203', 'Veronica eunice robledo villatoro', 'verovilla1975@gmail.com', '9613121999', 'Tapachula', 'Secretaria', 'Feliz dia', '189.148.4.42', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_6_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.6 Mobile/15E148 Safari/604.1', '2026-02-03 08:40:06'),
(3, 1, 1, '38FEB42A-260203', 'Caren Fabiola Barrios Garcia', 'carenbarriosg@gmail.com', '9621298375', 'Tapachula', 'Directora Financiera y de Comprobación del gasto', 'Excelente curso, Gracias por tomarnos en cuenta, para fortalecer nuestros conocimientos. Saludos.', '189.148.19.53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 08:53:16'),
(4, 1, 1, '59684C06-260203', 'Guillermo Garay Monzón', 'guillermogaray40@gmail.com', '9621300364', 'Tapachula', 'Director de ordenamiento territorial y tenencia de la tierra', '', '189.148.4.42', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_2_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/144.0.7559.95 Mobile/15E148 Safari/604.1', '2026-02-03 09:22:24'),
(5, 1, 1, '739E67C6-260203', 'JORGE RAMÓN ESTEBAN TOVILLA', 'togr.15@hotmail.com', '2229147700', 'Tapachula', 'Juez Administrativo Municipal', 'Gracias.', '189.148.4.42', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_6_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.6 Mobile/15E148 Safari/604.1', '2026-02-03 09:22:29'),
(6, 1, 1, '60B527AF-260203', 'alexander cutiño gonzalez', 'lic.alexander.coutino.gonzalez@gmail.com', '9621436591', 'Suchiate', 'asesor juridico', 'excelente capacitacion y material.', '189.148.52.196', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-02-03 09:29:03'),
(7, 1, 1, '169C91CE-260203', 'Jorge Mejia Rodriguez', 'jmr88810@gmail.com', '9622420311', 'Tapachula', 'Asesor Juridico', 'muy buena información y temas', '189.148.52.196', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', '2026-02-03 09:29:43'),
(8, 1, 1, 'B8B5B324-260203', 'KEVIN FIGUEROA MORENO', 'kevinfigueroa2504@outlook.com', '9621388596', 'Tapachula', 'JEFE DE DEPARTAMENTO', 'EXCELENTE CAPACITACIÓN QUE NOS FORTALECE COMO SERVIDORES PÚBLICOS Y NOS DA HERRAMIENTAS PARA MEJORAR LA ATENCIÓN, LA CALIDAD DEL SERVICIO Y SOBRE TODO LA INTEGRIDAD DE CADA SERVIDOR', '2806:10ae:6:1299:f0e7:d2b3:6e7d:4cc', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_2_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/144.0.7559.95 Mobile/15E148 Safari/604.1', '2026-02-03 09:30:20'),
(9, 1, 1, 'C726040A-260203', 'CARLOS CALDERÓN ORDÓÑEZ', 'ddeptojuridico@coapatap.gob.mx', '9626063017', 'Tapachula', 'JEFE DEL DEPARTAMENTO JIRÍDICO', '', '189.148.52.196', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 09:37:03'),
(10, 1, 1, 'C4162F18-260203', 'RAMON SANCHEZ ZAVALA', 'rsanchezz1@hotmail.com', '9621521597', 'Tapachula', 'ASESOR JURIDICO COAPATAP', '', '189.148.52.196', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 09:37:43'),
(11, 1, 1, 'F9E548D9-260203', 'Juan Córdova Tolentino', 'lic_tolentino26@hotmail.com', '9621013906', 'Tapachula', 'Jefe de la Unidad de Asuntos Internos de la SSPPCM, Tapachula, Chis.', '', '189.148.20.174', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 09:51:29'),
(12, 1, 1, '3D30F54A-260203', 'Yoseli de la Cruz Gallardo', 'yoseli_gallardo12@hotmail.com', '9622117402', 'Tapachula', 'Auxiliar Administrativo de la Unidad de Asuntos internos de la SSPPCM', 'excelente capacitacion', '189.148.20.174', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 09:55:30'),
(13, 1, 1, 'FE0D902B-260203', 'DAVID VELAZQUEZ PALACIOS', 'davidvelazquez1959@gmail.com', '9621650469', 'Tapachula', 'JEFE DE DEPARTAMENTO DE DERECHOS HUMANOS', 'FUE UN CURSO, DE RETROALIMENTACION MUY AGRADABLE Y PRODUCTIVO EXCELNTES PONENTES, GRACIAS  POR TRANSMITIR SU CONOCIMIENTO Y POR LAS ENSEÑANZAS. .', '189.148.43.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 11:07:15'),
(14, 1, 1, 'E43CC8E4-260203', 'Sergio Cabrera Allende', 'cabrera180@hotmail.com', '96269598909', 'Tapachula', 'Jefe Departamento', 'Muchas gracias por estas capacitaciones. información ampliamente util', '136.226.112.184', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-02-03 11:17:11'),
(15, 1, 1, '380743D4-260203', 'Ricardo Mejía Zepeda', 'mejiazepedarichi@gmail.com', '9621222484', 'Tapachula', 'Auxiliar jurídico DIF Tapachula', 'Muchas gracias por la adquisición de nuevos conocimientos. Es oportuna dicha información. Felicidades!!', '2806:10ae:6:34fb:3173:a773:e623:7665', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-02-03 12:35:16'),
(16, 1, 1, '5806E8F3-260203', 'Juana Molina Velazquez', 'molinajuana1201@gmail.com', '9622166655', 'Tapachula', 'Auxiliar administrativo', '', '189.148.20.174', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '2026-02-03 12:35:55'),
(17, 1, 1, '1AF44527-260203', 'CRISTEL DANIELA LOPEZ HERNANDEZ', 'crisdanielalopez510@gmail.com', '9612330476', 'Tapachula', 'Coordinación General de Transparencia, Acceso a la Información y Protección de Datos Personales', '', '2806:10ae:6:1e38:9888:b66d:7341:3228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 12:38:34'),
(18, 1, 1, 'A4A77DA2-260203', 'Alejandro Palacios Mendoza', 'consorcio.juridico.palacios@gmail.com', '9621214965', 'Tapachula', 'Director de Asuntos Juridicos de la Secretaria General', '', '202.5.110.184', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/29.0 Chrome/136.0.0.0 Mobile Safari/537.36', '2026-02-03 13:23:56'),
(19, 1, 1, '0FC8B3FF-260203', 'Laura González Trejo', 'lauren.juridicos.tapachula@gmail.com', '9621860470', 'Tapachula', 'Coordinadora de oficialias conciliadoras', 'Excelente curso!', '2806:370:827b:afa0:1:0:e23d:6813', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-02-03 13:24:13'),
(20, 1, 1, 'FBFE965A-260203', 'Victor Manuel Lopez Orozco', 'vive9108@gmail.com', '9621385921', 'Tapachula', 'Administrativo', 'Muy bien', '189.148.20.174', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-02-03 13:26:20'),
(22, 1, 1, '8483BC31-260203', 'Leonel Enrique Vazquez Martinez', 'leonelenriquevazquezmartinez@gmail.com', '9641370153', 'Tapachula', 'Director de Gobierno Municipal', 'Excelentes ponentes gracias por la invitación', '136.226.112.101', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-02-03 13:59:47'),
(24, 1, 1, '7B807BE3-260203', 'Adolfo López Escobar', 'alopez242009@hotmail.com', '9621323441', 'Tapachula', 'abogado consejería jurídica', 'un excelente curso que promueve la aplicación de la ley de forma congruente con el actuar de nosotros servidores públicos, felicidades', '189.148.20.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 14:17:25'),
(26, 1, 1, 'CA343AC5-260203', 'Jesús Alberto Escobar García', 'lic.jesus.aeg@gmail.com', '9621069836', 'Tapachula', 'Coordinador Jurídico (Consejería Jurídica)', 'Gracias por la Capacitación', '189.148.20.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 14:25:26'),
(27, 1, 1, '9008FE96-260203', 'Amós José Olivera Sánchez', 'amosjoseolivera@rocketmail.com', '9621525080', 'Tapachula', 'Delegado Jurídico de la SSPPCM', 'son de gran importancia para todos y cada uno de los servidores públicos, recibir este tipo de capacitación, por lo que solicito sean continuos. Gracias.', '189.148.20.174', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 14:41:59'),
(28, 1, 1, '6D28B639-260203', 'Víctor Samuel Domínguez López', 'cp.victordominguez@hotmail.com', '9621002220', 'Tapachula', 'Titular del Órgano Interno de Control', '', '189.148.52.196', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-02-03 14:50:57'),
(29, 1, 1, '180EA68B-260203', 'ingrid denned lopez vazquez', 'inlodenned@gmail.com', '9625940347', 'Tapachula', 'jefe de departamento de investigación', '', '189.148.52.196', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/29.0 Chrome/136.0.0.0 Mobile Safari/537.36', '2026-02-03 14:51:12'),
(30, 1, 1, 'E1FB783D-260203', 'David Victorio Domínguez', 'david_660907@hotmail.com', '9621110318', 'Tapachula', 'Coordinador de Auditorías', '', '189.148.52.196', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 14:51:43'),
(31, 1, 1, '4A0D8195-260203', 'RICARDO LUIS SOTO GARCIA', 'risoga8603@gmail.com', '9621498474', 'Tapachula', 'auxiliar administrativo', '', '189.148.4.42', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-02-03 16:03:48'),
(32, 1, 1, '76329649-260203', 'Alejandro Santos González', 'alexsago@hotmail.com', '7471050327', 'Tapachula', 'Consejero Jurídico', 'Buena Capacitación', '2806:10ae:6:bd37:f55c:b2a0:720c:1282', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 16:06:20'),
(33, 1, 1, '9522C66F-260203', 'MIGUEL ANGEL RIVAS HERNANDEZ', 'granrivas22@hotmail.com', '9621473787', 'Tapachula', 'PROFESIONISTA \"A\"', '', '189.148.4.42', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', '2026-02-03 16:07:35'),
(34, 1, 1, 'F3AC5D13-260203', 'Marco Antonio Moreno De León', 'marco_mleon@hotmail.com', '9627070225', 'Tapachula', 'Director Jurídico', 'Acertadas las interrogantes', '2806:10ae:1f:5561:5add:3197:5aaf:2b1c', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-02-03 17:25:03'),
(35, 1, 1, '6E44D3A1-260203', 'Luis Gerardo Abarca Roque', 'labarcaroque@gmail.com', '9621670717', 'Tapachula', 'Abogado Adscrito a Consejería Jurídica', 'felicitaciones por los cursos impartidos a los servidores públicos, el cual será de ayuda para el mejor funcionamiento de las instituciones', '2806:10ae:6:bd37:78e4:f6e0:72dd:7fff', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-02-03 18:09:57'),
(36, 1, 1, '5DED0E19-260203', 'Ovidio Reyes Escobar', 'ovidioreyesescobar1983@gmail.com', '9625276337', 'Tapachula', 'Director', 'Muchas gracias', '2806:10ae:6:6e13:47a1:49e7:8f80:51c9', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-02-03 18:45:10'),
(37, 1, 1, '1D276269-260203', 'Jesus Antonio Gamboa Recinos', 'jesusagr99@gmail.com', '9625641243', 'Tapachula', 'Profesionista C', 'Muchas gracias', '2806:10ae:6:6e13:5c51:c3a8:8a5b:c7ea', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '2026-02-03 18:45:35'),
(38, 1, 1, '670E0BAF-260203', 'Regina Quitzé López Gálvez', 'quitze77@icloud.com', '6241684754', 'Tapachula', 'Profesionista “C”', '', '200.68.172.173', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '2026-02-03 18:47:48'),
(39, 1, 1, '2673CC36-260203', 'HECTOR REYES CIGARROA', 'reyescigarroahector@gmail.com', '9622548587', 'Tapachula', 'Auxiliar Administrativo', '', '189.148.4.42', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-02-03 18:48:05'),
(40, 1, 1, 'F78EF8F7-260203', 'ISAÍAS GARZÓN RUÍZ', 'isaiasruiz48@hotmail.com', '9622191761', 'Tapachula', 'abogado', 'Excelente curso-capacitación, muchas felicidades por tan hermosa capacitación, solicitando que se siguán dando más capacitaciones.', '2806:10ae:1f:45e5:9907:f5e5:32af:ba73', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-02-03 19:37:04'),
(41, 1, 1, '09A32F7C-260203', 'Tomasa Guadalupe Martínez Salvador', 'lupix_martinez@hotmail.com', '9615909332', 'Tapachula', 'Auxiliar jurídico de la ssppcm', 'Muy buen curso.', '201.167.134.178', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-02-03 21:18:24'),
(42, 1, 1, 'ADEF6AAF-260203', 'María de Lourdes Ramos Hilerio', 'mariaramoshilerio@gmail.com', '9621883865', 'Tapachula', 'Apoderada legal Y jefa de oficina de la Coordinación Jurídica de Sindicatura', '', '189.148.45.138', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-02-03 21:54:14'),
(43, 1, 1, '7550EBD6-260204', 'Alexis Rafael Gonzalez Rodas', 'alex.rafael10@hotmail.com', '9611544697', 'Tapachula', 'Jefe de Departamento', '', '2806:10ae:6:bd37:7d11:6483:5e46:7d4e', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.6 Safari/605.1.15', '2026-02-04 10:31:50'),
(46, 1, 1, 'A8C7395F-260205', 'jesus antonio lazos cota', 'contraloriasdiftapachula@gmail.com', '9623366025', 'Tapachula', 'contralor interno sdif', 'excelente curso, para profundizar mas en materia del control interno.', '2806:10ae:6:31d9:b815:bf4c:d0a3:61d5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-05 11:48:26'),
(47, 1, 1, 'DB80F7EF-260205', 'Berenice Álvarez Méndez', 'alvarezmendezberenice@gmail.com', '9621382789', 'Tapachula', 'Jefe de departamento D', '', '2806:10ae:6:6e13:d959:7749:3c84:7c95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-02-05 12:13:35'),
(48, 1, 1, '3A707854-260205', 'Josue Rafael Mendez Estrada', 'jhosua_k@hotmail.com', '9627074601', 'Tapachula', 'Coordinador Jurídico de Obras Publicas', '', '189.148.4.42', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-02-05 12:29:00'),
(55, 6, 4, '63A24805-260226', 'Rosario Isabel Rosales de leon', 'rosalesisabel379@gmail.com', '9612366286', 'SSPYTM', 'Operativo', '', '200.68.191.111', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', '2026-02-26 12:17:11'),
(56, 6, 4, '66295B87-260226', 'Erwin Fidel Gómez Sarmiento', 'erfigos13@gmail.com', '9612876959', 'Gobierno Municipal de Berriozábal', 'Director General', '', '2806:288:43b:d37b:ac6b:2eab:e84d:387', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_6_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/145.0.7632.108 Mobile/15E148 Safari/604.1', '2026-02-26 12:17:14'),
(57, 6, 4, '33BC9AE5-260226', 'Jesús Eduardo de la Cruz Perez', 'yisuslalo2397@icloud.com', '9611549641', 'H. Ayuntamiento de Berriozabal', 'Coordinador de asuntos jurídicos ambientales', '', '189.201.25.255', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', '2026-02-26 12:17:25'),
(58, 6, 4, '787C28FA-260226', 'Eduardo Hernández huerta', 'eduardohuerta2587@gmail.com', '9611862265', 'secretaria de economía municipal', 'administrativo', 'Agradecer y solicitar mas capacitaciones como estas,que hacen que el desempeño de nuestras labores como servidores públicos sean aun mejores.', '2806:370:8265:3e99:1:0:145c:b031', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', '2026-02-26 12:17:48'),
(59, 6, 4, 'E9148FCF-260226', 'Yuri Yazmin  de la Cruz de la Cruz', 'yurin788@hotmail.com', '9613000107', 'Gobierno Municipal de Berriozábal', 'Directora', 'Gracias por la capacitación, es de mucha importancia para nosotros como servidores públicos , que nos ayuda a conocer y actuar de manera correcta .', '2806:370:8266:e0ea:ac4c:deff:fe61:f24a', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', '2026-02-26 12:17:58'),
(60, 6, 4, '162DB78E-260226', 'Oscar Reynosa Colmenares', 'oscarrc500@gmail.com', '9611316249', 'Ayuntamiento de Berriozábal', 'Secretario Ejecutivo del Consejo Municipal de Seguridad Pública', '', '2806:370:8f12:e69d:245d:45ff:fed0:eae5', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', '2026-02-26 12:18:38'),
(61, 6, 4, '235825FA-260226', 'JUAN PABLO SALAZAR ESTRADA', 'jpsae78@gmail.com', '9612479384', 'Secretaria Economia Municipio de Berriozábal', 'Enlace SARE', 'Gracias', '2806:370:8420:851e:1897:d8fd:5fd2:df60', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', '2026-02-26 12:18:45'),
(63, 6, 4, 'B145BC18-260226', 'Elmer de Jesús Velázquez Natarén', 'elmerjvelazquezn@hotmail.com', '9613603938', 'Ayuntamiento de Berriozábal', 'Director de Diversidad Sexual', '', '2806:288:53e:e1d6:a901:c90d:6322:9bf2', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', '2026-02-26 12:18:59'),
(64, 6, 4, 'C6C6C63C-260226', 'Luis Gerardo Roblero de los Santos', 'lroblerodelossantos@gmail.com', '9611749223', 'H. Ayuntamiento de Berriozabal', 'Autoridad Sustanciadora', 'Muy buena capacitación, esperando contar con muchas más para poder seguirnos preparando cada día más', '200.68.161.157', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', '2026-02-26 12:19:00'),
(65, 6, 4, 'C45BAFE5-260226', 'Yesmin marina sanchez', 'yesmin.marina@hotmail.com', '9613671437', 'H Ayuntamiento de berriozabal', 'Auxiliar administrativo', '', '200.68.180.102', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', '2026-02-26 12:19:44'),
(66, 6, 4, '6C063613-260226', 'KARLA GUADALUPE CASTAÑON RUIZ', 'kcastanonruiz@gmail.com', '9613682322', 'H. AYUNTAMIENTO BERRIOZABAL', 'DEFENSORA DE DERECHOS HUMANOS MUNICIPAL', '', '200.68.172.56', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.0 Mobile/15E148 Safari/604.1', '2026-02-26 12:20:33'),
(67, 6, 4, '78C42CF8-260226', 'antonny enrique ochoa lópez', 'rokanlover05@gmail.com', '9616081939', 'Honorable Ayuntamiento de Berriozábal', 'Asesor Juridico', '', '2806:370:83c4:bd55:2c42:81ff:fe1e:c4e5', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', '2026-02-26 12:20:38'),
(68, 6, 4, '5C46CA0F-260226', 'Kevin Josué López Ovando', 'kevinlopezovando283@gmail.com', '9614479989', 'H. Ayuntamiento municipal de Berriozábal, Chiapas', 'Administrativo', 'Excelente curso de aprendizaje', '200.68.180.107', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Safari/605.1.15', '2026-02-26 12:20:47'),
(69, 6, 4, '877DDD8B-260226', 'Belem Camacho Chávez', 'belemcamachochavez@gmail.com', '9611856747', 'H. Ayuntamiento de Berriozábal Chiapas', 'Administrativo', 'Muy buen curso y de provecho para servidores públicos', '2806:288:448:3bbb:8cdb:7901:30c9:20e4', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '2026-02-26 12:20:57'),
(70, 6, 4, '1CCEC316-260226', 'Dulce Belén Cruz Gálvez', 'dulcebelengalvezcruz@gmail.com', '9612360771', 'Consejo municipal de seguridad pública', 'Operadora de la Junta de Reclutamiento del Servicio Militar', '', '2806:370:8901:f78c:9dfa:c47a:3cad:9ac4', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', '2026-02-26 12:21:00'),
(71, 6, 4, 'F87C90ED-260226', 'Mauricio Alvarez Jimenez', 'mauricio7.12@hotmail.com', '9611762064', 'Ayuntamiento de Berriozàbal', 'Auxiliar Juridico', '', '189.201.38.113', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '2026-02-26 12:21:54'),
(72, 6, 4, 'EFF65C56-260226', 'Ayda Olivia Vazquez Vazquez', 'aydyvaz86@gmail.com', '9612029670', 'DIF Berriozabal', 'Auxiliar Administrativo', 'Fue de mucho provecho la información proporcionada, para evitar faltas administrativas, y conocer nuestro marco jurídico.', '2806:370:826a:a45d:1cb3:4fce:e106:8749', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/29.0 Chrome/136.0.0.0 Mobile Safari/537.36', '2026-02-26 12:23:33'),
(73, 6, 4, '726D40F8-260226', 'Luis Angel Pérez Pérez', 'lp3976634@gmail.com', '9612325489', 'Secretaria de seguridad pública y tránsito municipal', 'Policía Táctico', '', '2806:370:8f13:b6d2:924f:3621:9a8a:d34d', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', '2026-02-26 12:23:35'),
(74, 6, 4, 'DC320D7A-260226', 'CARLOS CESAR CASTAÑÓN DIAZ', 'sapamberrio1821@gmail.com', '9611442449', 'Sapam Berriozabal', 'Administrador General', '', '200.68.191.37', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_3_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/145.0.7632.108 Mobile/15E148 Safari/604.1', '2026-02-26 12:23:49'),
(75, 6, 4, '8385697F-260226', 'Abner Jhovanny Álvarez Hernández', 'sharawyalvarez@gmail.com', '9614617202', 'Sistema de agua potable y alcantarillado municipal', 'Administrativo', '', '200.68.161.63', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '2026-02-26 12:23:54'),
(76, 6, 4, 'ACF013E9-260226', 'Otoniel Imanol Pérez Sarmiento', 'otonielimanolp@gmail.com', '9613861666', 'Ayuntamiento de Berriozábal', 'Asesor Ventanilla Unica', '', '200.68.172.190', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_3_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/145.0.7632.108 Mobile/15E148 Safari/604.1', '2026-02-26 12:24:10'),
(78, 6, 4, '2CBA29CF-260226', 'Asunción Martinez Moreno', 'angelesmartinez75345@gmail.com', '9614371054', 'Secretaria de seguridad y transito municipal', 'Sub inspector', '', '202.5.111.193', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', '2026-02-26 12:24:55'),
(80, 6, 4, 'E4EC6CE8-260226', 'Banesa Diaz Espinosa', 'banesadiazespinosa@gmail.com', '9602408870', 'H. Ayuntamiento Municipal de Berriozabal', 'Juez Calificador', '', '202.5.111.34', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', '2026-02-26 12:25:58'),
(82, 6, 4, '8A88D217-260226', 'Sergio Roque Escobar', 'roquesergio018@gmail.com', '9611295568', 'Secretaria de seguridad pública y tránsito municipal', 'Policía primero', 'Muy profesionales los ponentes  en los temas q nos impartieron  aclarando toda duda sobre los temas inpartidos', '2806:370:8904:60c5:383f:aeff:fec6:d650', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', '2026-02-26 12:26:39'),
(83, 6, 4, '74F81947-260226', 'Lorena Guadalupe López Alcantar', 'sogarased212@gmail.com', '9614512564', 'Secretaria de seguridad publica y transito municipal', 'Inspector general', '', '200.68.191.193', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_2_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/145.0.7632.108 Mobile/15E148 Safari/604.1', '2026-02-26 12:26:40'),
(84, 6, 4, '7A4707F0-260226', 'Beatriz Adriana Ovando Cárdenas', 'anjelkaleb@gmail.com', '9611130414', 'Secretaria de Seguridad Publica y Tránsito Municipal de Berriozábal', 'Administrativo', '', '2806:370:8647:c9e8:1897:d371:ee8:8b04', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', '2026-02-26 12:27:35'),
(85, 6, 4, '56B9B3D7-260226', 'Ray erick Antonio Gutiérrez Vázquez', 'erickgtzdiaz26@gmail.com', '9514557737', 'Protección civil', 'Apoyo juridico', '', '200.68.172.192', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', '2026-02-26 12:27:53'),
(86, 6, 4, '4E8A441C-260226', 'Ramiro Lira Cristiani', 'ramirolorca@gmail.com', '6183218903', 'Seguridad pública', 'Secretario', '', '2806:370:8450:7958:1897:d0be:9437:c0fd', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', '2026-02-26 12:28:59'),
(88, 6, 4, '8A744CCE-260226', 'LIDIA BERENICE DOMINGUEZ MORALES', 'dominguezbere561@gmail.com', '9611814311', 'GOBIERNO MUNICIPAL DE BERRIOZÁBAL', 'AUXILIAR ADMINISTRATIVO', '', '187.251.145.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-26 12:38:42'),
(89, 6, 4, 'F5823DB3-260226', 'José Alfredo Cisneros Hernández', 'fredy.hdz0407@gmail.com', '9612875953', 'Ayuntamiento de Berriozábal', 'Autoridad investigadora', '', '187.251.145.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-26 12:38:49'),
(90, 6, 4, '7B03539C-260226', 'Karen Lissette Vazquez Vicente', 'vazquez_kl@hotmail.com', '9611557040', 'H. Ayuntamiento de Berriozabal', 'Administrativo', '', '2a09:bac3:4c26:e78::171:216', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', '2026-02-26 13:45:49'),
(91, 6, 4, '08EEE45F-260226', 'Jacob Zoma Gutierrez', 'zoma0922@hotmail.com', '9611291980', 'Ayuntamiento de Berriozabal, Chiapas', 'auxiliar Juridico', '', '187.251.145.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-26 14:31:25'),
(92, 6, 4, '95505832-260226', 'Maria  Luz Castañon Manga', 'lucicastanon1970@gmail.com', '9611172237', 'Presidencia Municipal', 'Jueza  Municipal', '', '187.251.145.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-26 14:33:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas_detalle`
--

CREATE TABLE `respuestas_detalle` (
  `id` int NOT NULL,
  `respuesta_id` int NOT NULL,
  `pregunta_id` int NOT NULL,
  `valor_texto` text,
  `valor_opcion` varchar(200) DEFAULT NULL,
  `valor_num` int DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `respuestas_detalle`
--

INSERT INTO `respuestas_detalle` (`id`, `respuesta_id`, `pregunta_id`, `valor_texto`, `valor_opcion`, `valor_num`, `created_at`) VALUES
(12, 2, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 08:40:06'),
(13, 2, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 08:40:06'),
(14, 2, 36, NULL, '1', NULL, '2026-02-03 08:40:06'),
(15, 2, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 08:40:06'),
(16, 2, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 08:40:06'),
(17, 2, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 08:40:06'),
(18, 2, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 08:40:06'),
(19, 2, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 08:40:06'),
(20, 2, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 08:40:06'),
(21, 2, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 08:40:06'),
(22, 2, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 08:40:06'),
(23, 3, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 08:53:16'),
(24, 3, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 08:53:16'),
(25, 3, 36, NULL, '1', NULL, '2026-02-03 08:53:16'),
(26, 3, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 08:53:16'),
(27, 3, 38, NULL, 'c)	la resolución del procedimiento administrativo.', NULL, '2026-02-03 08:53:16'),
(28, 3, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 08:53:16'),
(29, 3, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 08:53:16'),
(30, 3, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 08:53:16'),
(31, 3, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 08:53:16'),
(32, 3, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 08:53:16'),
(33, 3, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 08:53:16'),
(34, 4, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 09:22:24'),
(35, 4, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 09:22:24'),
(36, 4, 36, NULL, '1', NULL, '2026-02-03 09:22:24'),
(37, 4, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 09:22:24'),
(38, 4, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 09:22:24'),
(39, 4, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 09:22:24'),
(40, 4, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 09:22:24'),
(41, 4, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 09:22:24'),
(42, 4, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 09:22:24'),
(43, 4, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 09:22:24'),
(44, 4, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 09:22:24'),
(45, 5, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 09:22:29'),
(46, 5, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 09:22:29'),
(47, 5, 36, NULL, '1', NULL, '2026-02-03 09:22:29'),
(48, 5, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 09:22:29'),
(49, 5, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 09:22:29'),
(50, 5, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 09:22:29'),
(51, 5, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 09:22:29'),
(52, 5, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 09:22:29'),
(53, 5, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 09:22:29'),
(54, 5, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 09:22:29'),
(55, 5, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 09:22:29'),
(56, 6, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 09:29:03'),
(57, 6, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 09:29:03'),
(58, 6, 36, NULL, '1', NULL, '2026-02-03 09:29:03'),
(59, 6, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 09:29:03'),
(60, 6, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 09:29:03'),
(61, 6, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 09:29:03'),
(62, 6, 40, NULL, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', NULL, '2026-02-03 09:29:03'),
(63, 6, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 09:29:03'),
(64, 6, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 09:29:03'),
(65, 6, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 09:29:03'),
(66, 6, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 09:29:03'),
(67, 7, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 09:29:43'),
(68, 7, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 09:29:43'),
(69, 7, 36, NULL, '1', NULL, '2026-02-03 09:29:43'),
(70, 7, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 09:29:43'),
(71, 7, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 09:29:43'),
(72, 7, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 09:29:43'),
(73, 7, 40, NULL, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', NULL, '2026-02-03 09:29:43'),
(74, 7, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 09:29:43'),
(75, 7, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 09:29:43'),
(76, 7, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 09:29:43'),
(77, 7, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 09:29:43'),
(78, 8, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 09:30:20'),
(79, 8, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 09:30:20'),
(80, 8, 36, NULL, '1', NULL, '2026-02-03 09:30:20'),
(81, 8, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 09:30:20'),
(82, 8, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 09:30:20'),
(83, 8, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 09:30:20'),
(84, 8, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 09:30:20'),
(85, 8, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 09:30:20'),
(86, 8, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 09:30:20'),
(87, 8, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 09:30:20'),
(88, 8, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 09:30:20'),
(89, 9, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 09:37:03'),
(90, 9, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 09:37:03'),
(91, 9, 36, NULL, '1', NULL, '2026-02-03 09:37:03'),
(92, 9, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 09:37:03'),
(93, 9, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 09:37:03'),
(94, 9, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 09:37:03'),
(95, 9, 40, NULL, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', NULL, '2026-02-03 09:37:03'),
(96, 9, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 09:37:03'),
(97, 9, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 09:37:03'),
(98, 9, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 09:37:03'),
(99, 9, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 09:37:03'),
(100, 10, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 09:37:43'),
(101, 10, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 09:37:43'),
(102, 10, 36, NULL, '1', NULL, '2026-02-03 09:37:43'),
(103, 10, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 09:37:43'),
(104, 10, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 09:37:43'),
(105, 10, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 09:37:43'),
(106, 10, 40, NULL, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', NULL, '2026-02-03 09:37:43'),
(107, 10, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 09:37:43'),
(108, 10, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 09:37:43'),
(109, 10, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 09:37:43'),
(110, 10, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 09:37:43'),
(111, 11, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 09:51:29'),
(112, 11, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 09:51:29'),
(113, 11, 36, NULL, '1', NULL, '2026-02-03 09:51:29'),
(114, 11, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 09:51:29'),
(115, 11, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 09:51:29'),
(116, 11, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 09:51:29'),
(117, 11, 40, NULL, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', NULL, '2026-02-03 09:51:29'),
(118, 11, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 09:51:29'),
(119, 11, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 09:51:29'),
(120, 11, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 09:51:29'),
(121, 11, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 09:51:29'),
(122, 12, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 09:55:30'),
(123, 12, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 09:55:30'),
(124, 12, 36, NULL, '1', NULL, '2026-02-03 09:55:30'),
(125, 12, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 09:55:30'),
(126, 12, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 09:55:30'),
(127, 12, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 09:55:30'),
(128, 12, 40, NULL, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', NULL, '2026-02-03 09:55:30'),
(129, 12, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 09:55:30'),
(130, 12, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 09:55:30'),
(131, 12, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 09:55:30'),
(132, 12, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 09:55:30'),
(133, 13, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 11:07:15'),
(134, 13, 35, NULL, 'b)	Ética', NULL, '2026-02-03 11:07:15'),
(135, 13, 36, NULL, '1', NULL, '2026-02-03 11:07:15'),
(136, 13, 37, NULL, 'a)	Legalidad', NULL, '2026-02-03 11:07:15'),
(137, 13, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 11:07:15'),
(138, 13, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 11:07:15'),
(139, 13, 40, NULL, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', NULL, '2026-02-03 11:07:15'),
(140, 13, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 11:07:15'),
(141, 13, 42, NULL, 'a)	Ejecutar de inmediato los actos administrativos.', NULL, '2026-02-03 11:07:15'),
(142, 13, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 11:07:15'),
(143, 13, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 11:07:15'),
(144, 14, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 11:17:11'),
(145, 14, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 11:17:11'),
(146, 14, 36, NULL, '1', NULL, '2026-02-03 11:17:11'),
(147, 14, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 11:17:11'),
(148, 14, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 11:17:11'),
(149, 14, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 11:17:11'),
(150, 14, 40, NULL, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', NULL, '2026-02-03 11:17:11'),
(151, 14, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 11:17:11'),
(152, 14, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 11:17:11'),
(153, 14, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 11:17:11'),
(154, 14, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 11:17:11'),
(155, 15, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 12:35:16'),
(156, 15, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 12:35:16'),
(157, 15, 36, NULL, '1', NULL, '2026-02-03 12:35:16'),
(158, 15, 37, NULL, 'a)	Legalidad', NULL, '2026-02-03 12:35:16'),
(159, 15, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 12:35:16'),
(160, 15, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 12:35:16'),
(161, 15, 40, NULL, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', NULL, '2026-02-03 12:35:16'),
(162, 15, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 12:35:16'),
(163, 15, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 12:35:16'),
(164, 15, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 12:35:16'),
(165, 15, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 12:35:16'),
(166, 16, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 12:35:55'),
(167, 16, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 12:35:55'),
(168, 16, 36, NULL, '1', NULL, '2026-02-03 12:35:55'),
(169, 16, 37, NULL, 'a)	Legalidad', NULL, '2026-02-03 12:35:55'),
(170, 16, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 12:35:55'),
(171, 16, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 12:35:55'),
(172, 16, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 12:35:55'),
(173, 16, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 12:35:55'),
(174, 16, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 12:35:55'),
(175, 16, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 12:35:55'),
(176, 16, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 12:35:55'),
(177, 17, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 12:38:34'),
(178, 17, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 12:38:34'),
(179, 17, 36, NULL, '1', NULL, '2026-02-03 12:38:34'),
(180, 17, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 12:38:34'),
(181, 17, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 12:38:34'),
(182, 17, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 12:38:34'),
(183, 17, 40, NULL, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', NULL, '2026-02-03 12:38:34'),
(184, 17, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 12:38:34'),
(185, 17, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 12:38:34'),
(186, 17, 43, NULL, 'd)	 Juicio contencioso y revisión administrativa.', NULL, '2026-02-03 12:38:34'),
(187, 17, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 12:38:34'),
(188, 18, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 13:23:56'),
(189, 18, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 13:23:56'),
(190, 18, 36, NULL, '1', NULL, '2026-02-03 13:23:56'),
(191, 18, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 13:23:56'),
(192, 18, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 13:23:56'),
(193, 18, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 13:23:56'),
(194, 18, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 13:23:56'),
(195, 18, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 13:23:56'),
(196, 18, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 13:23:56'),
(197, 18, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 13:23:56'),
(198, 18, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 13:23:56'),
(199, 19, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 13:24:13'),
(200, 19, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 13:24:13'),
(201, 19, 36, NULL, '1', NULL, '2026-02-03 13:24:13'),
(202, 19, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 13:24:13'),
(203, 19, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 13:24:13'),
(204, 19, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 13:24:13'),
(205, 19, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 13:24:13'),
(206, 19, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 13:24:13'),
(207, 19, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 13:24:13'),
(208, 19, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 13:24:13'),
(209, 19, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 13:24:13'),
(210, 20, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 13:26:20'),
(211, 20, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 13:26:20'),
(212, 20, 36, NULL, '1', NULL, '2026-02-03 13:26:20'),
(213, 20, 37, NULL, 'a)	Legalidad', NULL, '2026-02-03 13:26:20'),
(214, 20, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 13:26:20'),
(215, 20, 39, NULL, 'a)	Siempre son dolosas.', NULL, '2026-02-03 13:26:20'),
(216, 20, 40, NULL, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', NULL, '2026-02-03 13:26:20'),
(217, 20, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 13:26:20'),
(218, 20, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 13:26:20'),
(219, 20, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 13:26:20'),
(220, 20, 44, NULL, 'b)	Ejecución de la resolución.', NULL, '2026-02-03 13:26:20'),
(232, 22, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 13:59:47'),
(233, 22, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 13:59:47'),
(234, 22, 36, NULL, '1', NULL, '2026-02-03 13:59:47'),
(235, 22, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 13:59:47'),
(236, 22, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 13:59:47'),
(237, 22, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 13:59:47'),
(238, 22, 40, NULL, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', NULL, '2026-02-03 13:59:47'),
(239, 22, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 13:59:47'),
(240, 22, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 13:59:47'),
(241, 22, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 13:59:47'),
(242, 22, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 13:59:47'),
(254, 24, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 14:17:25'),
(255, 24, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 14:17:25'),
(256, 24, 36, NULL, '1', NULL, '2026-02-03 14:17:25'),
(257, 24, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 14:17:25'),
(258, 24, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 14:17:25'),
(259, 24, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 14:17:25'),
(260, 24, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 14:17:25'),
(261, 24, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 14:17:25'),
(262, 24, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 14:17:25'),
(263, 24, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 14:17:25'),
(264, 24, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 14:17:25'),
(276, 26, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 14:25:26'),
(277, 26, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 14:25:26'),
(278, 26, 36, NULL, '1', NULL, '2026-02-03 14:25:26'),
(279, 26, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 14:25:26'),
(280, 26, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 14:25:26'),
(281, 26, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 14:25:26'),
(282, 26, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 14:25:26'),
(283, 26, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 14:25:26'),
(284, 26, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 14:25:26'),
(285, 26, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 14:25:26'),
(286, 26, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 14:25:26'),
(287, 27, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 14:41:59'),
(288, 27, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 14:41:59'),
(289, 27, 36, NULL, '1', NULL, '2026-02-03 14:41:59'),
(290, 27, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 14:41:59'),
(291, 27, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 14:41:59'),
(292, 27, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 14:41:59'),
(293, 27, 40, NULL, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', NULL, '2026-02-03 14:41:59'),
(294, 27, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 14:41:59'),
(295, 27, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 14:41:59'),
(296, 27, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 14:41:59'),
(297, 27, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 14:41:59'),
(298, 28, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 14:50:57'),
(299, 28, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 14:50:57'),
(300, 28, 36, NULL, '1', NULL, '2026-02-03 14:50:57'),
(301, 28, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 14:50:57'),
(302, 28, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 14:50:57'),
(303, 28, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 14:50:57'),
(304, 28, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 14:50:57'),
(305, 28, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 14:50:57'),
(306, 28, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 14:50:57'),
(307, 28, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 14:50:57'),
(308, 28, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 14:50:57'),
(309, 29, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 14:51:12'),
(310, 29, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 14:51:12'),
(311, 29, 36, NULL, '1', NULL, '2026-02-03 14:51:12'),
(312, 29, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 14:51:12'),
(313, 29, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 14:51:12'),
(314, 29, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 14:51:12'),
(315, 29, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 14:51:12'),
(316, 29, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 14:51:12'),
(317, 29, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 14:51:12'),
(318, 29, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 14:51:12'),
(319, 29, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 14:51:12'),
(320, 30, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 14:51:43'),
(321, 30, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 14:51:43'),
(322, 30, 36, NULL, '1', NULL, '2026-02-03 14:51:43'),
(323, 30, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 14:51:43'),
(324, 30, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 14:51:43'),
(325, 30, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 14:51:43'),
(326, 30, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 14:51:43'),
(327, 30, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 14:51:43'),
(328, 30, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 14:51:43'),
(329, 30, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 14:51:43'),
(330, 30, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 14:51:43'),
(331, 31, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 16:03:48'),
(332, 31, 35, NULL, 'c)	Honestidad', NULL, '2026-02-03 16:03:48'),
(333, 31, 36, NULL, '1', NULL, '2026-02-03 16:03:48'),
(334, 31, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 16:03:48'),
(335, 31, 38, NULL, 'c)	la resolución del procedimiento administrativo.', NULL, '2026-02-03 16:03:48'),
(336, 31, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 16:03:48'),
(337, 31, 40, NULL, 'b)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye el ofrecimiento de pruebas.', NULL, '2026-02-03 16:03:48'),
(338, 31, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 16:03:48'),
(339, 31, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 16:03:48'),
(340, 31, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 16:03:48'),
(341, 31, 44, NULL, 'b)	Ejecución de la resolución.', NULL, '2026-02-03 16:03:48'),
(342, 32, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 16:06:20'),
(343, 32, 35, NULL, 'b)	Ética', NULL, '2026-02-03 16:06:20'),
(344, 32, 36, NULL, '1', NULL, '2026-02-03 16:06:20'),
(345, 32, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 16:06:20'),
(346, 32, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 16:06:20'),
(347, 32, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 16:06:20'),
(348, 32, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 16:06:20'),
(349, 32, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 16:06:20'),
(350, 32, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 16:06:20'),
(351, 32, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 16:06:20'),
(352, 32, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 16:06:20'),
(353, 33, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 16:07:35'),
(354, 33, 35, NULL, 'c)	Honestidad', NULL, '2026-02-03 16:07:35'),
(355, 33, 36, NULL, '1', NULL, '2026-02-03 16:07:35'),
(356, 33, 37, NULL, 'c)	Profesionalismo', NULL, '2026-02-03 16:07:35'),
(357, 33, 38, NULL, 'c)	la resolución del procedimiento administrativo.', NULL, '2026-02-03 16:07:35'),
(358, 33, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 16:07:35'),
(359, 33, 40, NULL, 'b)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye el ofrecimiento de pruebas.', NULL, '2026-02-03 16:07:35'),
(360, 33, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 16:07:35'),
(361, 33, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 16:07:35'),
(362, 33, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 16:07:35'),
(363, 33, 44, NULL, 'b)	Ejecución de la resolución.', NULL, '2026-02-03 16:07:35'),
(364, 34, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 17:25:03'),
(365, 34, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 17:25:03'),
(366, 34, 36, NULL, '1', NULL, '2026-02-03 17:25:03'),
(367, 34, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 17:25:03'),
(368, 34, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 17:25:03'),
(369, 34, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 17:25:03'),
(370, 34, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 17:25:03'),
(371, 34, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 17:25:03'),
(372, 34, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 17:25:03'),
(373, 34, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 17:25:03'),
(374, 34, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 17:25:03'),
(375, 35, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 18:09:57'),
(376, 35, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 18:09:57'),
(377, 35, 36, NULL, '1', NULL, '2026-02-03 18:09:57'),
(378, 35, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 18:09:57'),
(379, 35, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 18:09:57'),
(380, 35, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 18:09:57'),
(381, 35, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 18:09:57'),
(382, 35, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 18:09:57'),
(383, 35, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 18:09:57'),
(384, 35, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 18:09:57'),
(385, 35, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 18:09:57'),
(386, 36, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 18:45:10'),
(387, 36, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 18:45:10'),
(388, 36, 36, NULL, '1', NULL, '2026-02-03 18:45:10'),
(389, 36, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 18:45:10'),
(390, 36, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 18:45:10'),
(391, 36, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 18:45:10'),
(392, 36, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 18:45:10'),
(393, 36, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 18:45:10'),
(394, 36, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 18:45:10'),
(395, 36, 43, NULL, 'b)	 Recurso de apelación y revisión.', NULL, '2026-02-03 18:45:10'),
(396, 36, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 18:45:10'),
(397, 37, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 18:45:35'),
(398, 37, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 18:45:35'),
(399, 37, 36, NULL, '1', NULL, '2026-02-03 18:45:35'),
(400, 37, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 18:45:35'),
(401, 37, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 18:45:35'),
(402, 37, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 18:45:35'),
(403, 37, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 18:45:35'),
(404, 37, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 18:45:35'),
(405, 37, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 18:45:35'),
(406, 37, 43, NULL, 'b)	 Recurso de apelación y revisión.', NULL, '2026-02-03 18:45:35'),
(407, 37, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 18:45:35'),
(408, 38, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 18:47:48'),
(409, 38, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 18:47:48'),
(410, 38, 36, NULL, '1', NULL, '2026-02-03 18:47:48'),
(411, 38, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 18:47:48'),
(412, 38, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 18:47:48'),
(413, 38, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 18:47:48'),
(414, 38, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 18:47:48'),
(415, 38, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 18:47:48'),
(416, 38, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 18:47:48'),
(417, 38, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 18:47:48'),
(418, 38, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 18:47:48'),
(419, 39, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 18:48:05'),
(420, 39, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 18:48:05'),
(421, 39, 36, NULL, '1', NULL, '2026-02-03 18:48:05'),
(422, 39, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 18:48:05'),
(423, 39, 38, NULL, 'b)	un acuerdo elaborado por la autoridad substanciadora.', NULL, '2026-02-03 18:48:05'),
(424, 39, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 18:48:05'),
(425, 39, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-03 18:48:05'),
(426, 39, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 18:48:05'),
(427, 39, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 18:48:05'),
(428, 39, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 18:48:05'),
(429, 39, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 18:48:05'),
(430, 40, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 19:37:04'),
(431, 40, 35, NULL, 'c)	Honestidad', NULL, '2026-02-03 19:37:04'),
(432, 40, 36, NULL, '1', NULL, '2026-02-03 19:37:04'),
(433, 40, 37, NULL, 'c)	Profesionalismo', NULL, '2026-02-03 19:37:04'),
(434, 40, 38, NULL, 'c)	la resolución del procedimiento administrativo.', NULL, '2026-02-03 19:37:04'),
(435, 40, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 19:37:04'),
(436, 40, 40, NULL, 'b)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye el ofrecimiento de pruebas.', NULL, '2026-02-03 19:37:04'),
(437, 40, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 19:37:04'),
(438, 40, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 19:37:04'),
(439, 40, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 19:37:04'),
(440, 40, 44, NULL, 'b)	Ejecución de la resolución.', NULL, '2026-02-03 19:37:04'),
(441, 41, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 21:18:24'),
(442, 41, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 21:18:24'),
(443, 41, 36, NULL, '1', NULL, '2026-02-03 21:18:24'),
(444, 41, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 21:18:24'),
(445, 41, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 21:18:24'),
(446, 41, 39, NULL, 'a)	Siempre son dolosas.', NULL, '2026-02-03 21:18:24'),
(447, 41, 40, NULL, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', NULL, '2026-02-03 21:18:24'),
(448, 41, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 21:18:24'),
(449, 41, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 21:18:24'),
(450, 41, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 21:18:24'),
(451, 41, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 21:18:24'),
(452, 42, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-03 21:54:14'),
(453, 42, 35, NULL, 'd)	Integridad', NULL, '2026-02-03 21:54:14'),
(454, 42, 36, NULL, '1', NULL, '2026-02-03 21:54:14'),
(455, 42, 37, NULL, 'b)	Disciplina', NULL, '2026-02-03 21:54:14'),
(456, 42, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-03 21:54:14'),
(457, 42, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-03 21:54:14'),
(458, 42, 40, NULL, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', NULL, '2026-02-03 21:54:14'),
(459, 42, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-03 21:54:14'),
(460, 42, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-03 21:54:14'),
(461, 42, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-03 21:54:14'),
(462, 42, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-03 21:54:14'),
(463, 43, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-04 10:31:50'),
(464, 43, 35, NULL, 'd)	Integridad', NULL, '2026-02-04 10:31:50'),
(465, 43, 36, NULL, '1', NULL, '2026-02-04 10:31:50'),
(466, 43, 37, NULL, 'b)	Disciplina', NULL, '2026-02-04 10:31:50'),
(467, 43, 38, NULL, 'c)	la resolución del procedimiento administrativo.', NULL, '2026-02-04 10:31:50'),
(468, 43, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-04 10:31:50'),
(469, 43, 40, NULL, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', NULL, '2026-02-04 10:31:50'),
(470, 43, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-04 10:31:50'),
(471, 43, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-04 10:31:50'),
(472, 43, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-04 10:31:50'),
(473, 43, 44, NULL, 'a)	 Emisión de sentencia.', NULL, '2026-02-04 10:31:50'),
(496, 46, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-05 11:48:26'),
(497, 46, 35, NULL, 'd)	Integridad', NULL, '2026-02-05 11:48:26'),
(498, 46, 36, NULL, '1', NULL, '2026-02-05 11:48:26'),
(499, 46, 37, NULL, 'b)	Disciplina', NULL, '2026-02-05 11:48:26'),
(500, 46, 38, NULL, 'c)	la resolución del procedimiento administrativo.', NULL, '2026-02-05 11:48:26'),
(501, 46, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-05 11:48:26'),
(502, 46, 40, NULL, 'b)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye el ofrecimiento de pruebas.', NULL, '2026-02-05 11:48:26'),
(503, 46, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-05 11:48:26'),
(504, 46, 42, NULL, 'b)	Notificar sin necesidad de formalidades.', NULL, '2026-02-05 11:48:26'),
(505, 46, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-05 11:48:26'),
(506, 46, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-05 11:48:26'),
(507, 47, 34, NULL, 'a)	Imparcialidad', NULL, '2026-02-05 12:13:35'),
(508, 47, 35, NULL, 'd)	Integridad', NULL, '2026-02-05 12:13:35'),
(509, 47, 36, NULL, '1', NULL, '2026-02-05 12:13:35'),
(510, 47, 37, NULL, 'b)	Disciplina', NULL, '2026-02-05 12:13:35'),
(511, 47, 38, NULL, 'a)	un acuerdo elaborado por la autoridad investigadora.', NULL, '2026-02-05 12:13:35'),
(512, 47, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-05 12:13:35'),
(513, 47, 40, NULL, 'a)	Tiene su fundamento en el artículo 100 de la Ley de Responsabilidades Administrativas para el Estado de Chiapas e incluye la descripción de la conducta imputada.', NULL, '2026-02-05 12:13:35'),
(514, 47, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-05 12:13:35'),
(515, 47, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-05 12:13:35'),
(516, 47, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-05 12:13:35'),
(517, 47, 44, NULL, 'a)	 Emisión de sentencia.', NULL, '2026-02-05 12:13:35'),
(518, 48, 34, NULL, 'b)	Ética', NULL, '2026-02-05 12:29:00'),
(519, 48, 35, NULL, 'c)	Honestidad', NULL, '2026-02-05 12:29:00'),
(520, 48, 36, NULL, '1', NULL, '2026-02-05 12:29:00'),
(521, 48, 37, NULL, 'b)	Disciplina', NULL, '2026-02-05 12:29:00'),
(522, 48, 38, NULL, 'c)	la resolución del procedimiento administrativo.', NULL, '2026-02-05 12:29:00'),
(523, 48, 39, NULL, 'b)	Generalmente son culposas.', NULL, '2026-02-05 12:29:00'),
(524, 48, 40, NULL, 'c)	Se realiza posterior al acuerdo de conclusión de la investigación.', NULL, '2026-02-05 12:29:00'),
(525, 48, 41, NULL, 'b)	La revisión de la legalidad y constitucionalidad de los actos administrativos y de los particulares, ejercida por el Órgano Jurisdiccional.', NULL, '2026-02-05 12:29:00'),
(526, 48, 42, NULL, 'c)	Respetar las formalidades esenciales para que el gobernado pueda defenderse antes de afectar su esfera jurídica.', NULL, '2026-02-05 12:29:00'),
(527, 48, 43, NULL, 'c)	 Recurso de revocación y recurso de revisión.', NULL, '2026-02-05 12:29:00'),
(528, 48, 44, NULL, 'c)	Etapa probatoria.', NULL, '2026-02-05 12:29:00'),
(566, 55, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:17:11'),
(567, 55, 81, NULL, 'd) Subordinación al superior jerárquico', NULL, '2026-02-26 12:17:11'),
(568, 55, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:17:11'),
(569, 55, 83, NULL, 'c) Por servidores públicos y particulares identificables', NULL, '2026-02-26 12:17:11'),
(570, 55, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:17:11'),
(571, 55, 85, NULL, 'b) Que fueron subsanadas espontáneamente', NULL, '2026-02-26 12:17:11'),
(572, 55, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:17:11'),
(573, 55, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:17:11'),
(574, 55, 88, NULL, 'a) Siete años', NULL, '2026-02-26 12:17:11'),
(575, 55, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:17:11'),
(576, 56, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:17:14'),
(577, 56, 81, NULL, 'a) Legalidad', NULL, '2026-02-26 12:17:14'),
(578, 56, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:17:14'),
(579, 56, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:17:14'),
(580, 56, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:17:14'),
(581, 56, 85, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 12:17:14'),
(582, 56, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:17:14'),
(583, 56, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:17:14'),
(584, 56, 88, NULL, 'a) Siete años', NULL, '2026-02-26 12:17:14'),
(585, 56, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:17:14'),
(586, 57, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:17:25'),
(587, 57, 81, NULL, 'a) Legalidad', NULL, '2026-02-26 12:17:25'),
(588, 57, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:17:25'),
(589, 57, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:17:25'),
(590, 57, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:17:25'),
(591, 57, 85, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 12:17:25');
INSERT INTO `respuestas_detalle` (`id`, `respuesta_id`, `pregunta_id`, `valor_texto`, `valor_opcion`, `valor_num`, `created_at`) VALUES
(592, 57, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:17:25'),
(593, 57, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:17:25'),
(594, 57, 88, NULL, 'd) No prescriben', NULL, '2026-02-26 12:17:25'),
(595, 57, 89, NULL, 'a) Grave', NULL, '2026-02-26 12:17:25'),
(596, 58, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:17:48'),
(597, 58, 81, NULL, 'd) Subordinación al superior jerárquico', NULL, '2026-02-26 12:17:48'),
(598, 58, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:17:48'),
(599, 58, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:17:48'),
(600, 58, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:17:48'),
(601, 58, 85, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 12:17:48'),
(602, 58, 86, NULL, 'c) No siempre', NULL, '2026-02-26 12:17:48'),
(603, 58, 87, NULL, 'c) No siempre', NULL, '2026-02-26 12:17:48'),
(604, 58, 88, NULL, 'a) Siete años', NULL, '2026-02-26 12:17:48'),
(605, 58, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:17:48'),
(606, 59, 80, NULL, 'a) Artículo 16', NULL, '2026-02-26 12:17:58'),
(607, 59, 81, NULL, 'c) Objetividad', NULL, '2026-02-26 12:17:58'),
(608, 59, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:17:58'),
(609, 59, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:17:58'),
(610, 59, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:17:58'),
(611, 59, 85, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 12:17:58'),
(612, 59, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:17:58'),
(613, 59, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:17:58'),
(614, 59, 88, NULL, 'b) Tres años', NULL, '2026-02-26 12:17:58'),
(615, 59, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:17:58'),
(616, 60, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:18:38'),
(617, 60, 81, NULL, 'd) Subordinación al superior jerárquico', NULL, '2026-02-26 12:18:38'),
(618, 60, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:18:38'),
(619, 60, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:18:38'),
(620, 60, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:18:38'),
(621, 60, 85, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 12:18:38'),
(622, 60, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:18:38'),
(623, 60, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:18:38'),
(624, 60, 88, NULL, 'a) Siete años', NULL, '2026-02-26 12:18:38'),
(625, 60, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:18:38'),
(626, 61, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:18:45'),
(627, 61, 81, NULL, 'd) Subordinación al superior jerárquico', NULL, '2026-02-26 12:18:45'),
(628, 61, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:18:45'),
(629, 61, 83, NULL, 'c) Por servidores públicos y particulares identificables', NULL, '2026-02-26 12:18:45'),
(630, 61, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:18:45'),
(631, 61, 85, NULL, 'a) Dolosas', NULL, '2026-02-26 12:18:45'),
(632, 61, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:18:45'),
(633, 61, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:18:45'),
(634, 61, 88, NULL, 'a) Siete años', NULL, '2026-02-26 12:18:45'),
(635, 61, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:18:45'),
(646, 63, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:18:59'),
(647, 63, 81, NULL, 'a) Legalidad', NULL, '2026-02-26 12:18:59'),
(648, 63, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:18:59'),
(649, 63, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:18:59'),
(650, 63, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:18:59'),
(651, 63, 85, NULL, 'b) Que fueron subsanadas espontáneamente', NULL, '2026-02-26 12:18:59'),
(652, 63, 86, NULL, 'c) No siempre', NULL, '2026-02-26 12:18:59'),
(653, 63, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:18:59'),
(654, 63, 88, NULL, 'b) Tres años', NULL, '2026-02-26 12:18:59'),
(655, 63, 89, NULL, 'a) Grave', NULL, '2026-02-26 12:18:59'),
(656, 64, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:19:00'),
(657, 64, 81, NULL, 'a) Legalidad', NULL, '2026-02-26 12:19:00'),
(658, 64, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:19:00'),
(659, 64, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:19:00'),
(660, 64, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:19:00'),
(661, 64, 85, NULL, 'b) Que fueron subsanadas espontáneamente', NULL, '2026-02-26 12:19:00'),
(662, 64, 86, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 12:19:00'),
(663, 64, 87, NULL, 'c) No siempre', NULL, '2026-02-26 12:19:00'),
(664, 64, 88, NULL, 'b) Tres años', NULL, '2026-02-26 12:19:00'),
(665, 64, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:19:00'),
(666, 65, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:19:44'),
(667, 65, 81, NULL, 'a) Legalidad', NULL, '2026-02-26 12:19:44'),
(668, 65, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:19:44'),
(669, 65, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:19:44'),
(670, 65, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:19:44'),
(671, 65, 85, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 12:19:44'),
(672, 65, 86, NULL, 'b) No', NULL, '2026-02-26 12:19:44'),
(673, 65, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:19:44'),
(674, 65, 88, NULL, 'b) Tres años', NULL, '2026-02-26 12:19:44'),
(675, 65, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:19:44'),
(676, 66, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:20:33'),
(677, 66, 81, NULL, 'c) Objetividad', NULL, '2026-02-26 12:20:33'),
(678, 66, 82, NULL, 'c) Por medio de recursos humanos', NULL, '2026-02-26 12:20:33'),
(679, 66, 83, NULL, 'c) Por servidores públicos y particulares identificables', NULL, '2026-02-26 12:20:33'),
(680, 66, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:20:33'),
(681, 66, 85, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 12:20:33'),
(682, 66, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:20:33'),
(683, 66, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:20:33'),
(684, 66, 88, NULL, 'a) Siete años', NULL, '2026-02-26 12:20:33'),
(685, 66, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:20:33'),
(686, 67, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:20:38'),
(687, 67, 81, NULL, 'a) Legalidad', NULL, '2026-02-26 12:20:38'),
(688, 67, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:20:38'),
(689, 67, 83, NULL, 'b) Únicamente por particulares', NULL, '2026-02-26 12:20:38'),
(690, 67, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:20:38'),
(691, 67, 85, NULL, 'c) Errores intencionales', NULL, '2026-02-26 12:20:38'),
(692, 67, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:20:38'),
(693, 67, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:20:38'),
(694, 67, 88, NULL, 'a) Siete años', NULL, '2026-02-26 12:20:38'),
(695, 67, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:20:38'),
(696, 68, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:20:47'),
(697, 68, 81, NULL, 'a) Legalidad', NULL, '2026-02-26 12:20:47'),
(698, 68, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:20:47'),
(699, 68, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:20:47'),
(700, 68, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:20:47'),
(701, 68, 85, NULL, 'b) Que fueron subsanadas espontáneamente', NULL, '2026-02-26 12:20:47'),
(702, 68, 86, NULL, 'c) No siempre', NULL, '2026-02-26 12:20:47'),
(703, 68, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:20:47'),
(704, 68, 88, NULL, 'b) Tres años', NULL, '2026-02-26 12:20:47'),
(705, 68, 89, NULL, 'a) Grave', NULL, '2026-02-26 12:20:47'),
(706, 69, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:20:57'),
(707, 69, 81, NULL, 'a) Legalidad', NULL, '2026-02-26 12:20:57'),
(708, 69, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:20:57'),
(709, 69, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:20:57'),
(710, 69, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:20:57'),
(711, 69, 85, NULL, 'b) Que fueron subsanadas espontáneamente', NULL, '2026-02-26 12:20:57'),
(712, 69, 86, NULL, 'c) No siempre', NULL, '2026-02-26 12:20:57'),
(713, 69, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:20:57'),
(714, 69, 88, NULL, 'b) Tres años', NULL, '2026-02-26 12:20:57'),
(715, 69, 89, NULL, 'a) Grave', NULL, '2026-02-26 12:20:57'),
(716, 70, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:21:00'),
(717, 70, 81, NULL, 'd) Subordinación al superior jerárquico', NULL, '2026-02-26 12:21:00'),
(718, 70, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:21:00'),
(719, 70, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:21:00'),
(720, 70, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:21:00'),
(721, 70, 85, NULL, 'b) Que fueron subsanadas espontáneamente', NULL, '2026-02-26 12:21:00'),
(722, 70, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:21:00'),
(723, 70, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:21:00'),
(724, 70, 88, NULL, 'a) Siete años', NULL, '2026-02-26 12:21:00'),
(725, 70, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:21:00'),
(726, 71, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:21:54'),
(727, 71, 81, NULL, 'a) Legalidad', NULL, '2026-02-26 12:21:54'),
(728, 71, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:21:54'),
(729, 71, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:21:54'),
(730, 71, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:21:54'),
(731, 71, 85, NULL, 'b) Que fueron subsanadas espontáneamente', NULL, '2026-02-26 12:21:54'),
(732, 71, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:21:54'),
(733, 71, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:21:54'),
(734, 71, 88, NULL, 'a) Siete años', NULL, '2026-02-26 12:21:54'),
(735, 71, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:21:54'),
(736, 72, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:23:33'),
(737, 72, 81, NULL, 'c) Objetividad', NULL, '2026-02-26 12:23:33'),
(738, 72, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:23:33'),
(739, 72, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:23:33'),
(740, 72, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:23:33'),
(741, 72, 85, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 12:23:33'),
(742, 72, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:23:33'),
(743, 72, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:23:33'),
(744, 72, 88, NULL, 'b) Tres años', NULL, '2026-02-26 12:23:33'),
(745, 72, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:23:33'),
(746, 73, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:23:35'),
(747, 73, 81, NULL, 'd) Subordinación al superior jerárquico', NULL, '2026-02-26 12:23:35'),
(748, 73, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:23:35'),
(749, 73, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:23:35'),
(750, 73, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:23:35'),
(751, 73, 85, NULL, 'b) Que fueron subsanadas espontáneamente', NULL, '2026-02-26 12:23:35'),
(752, 73, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:23:35'),
(753, 73, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:23:35'),
(754, 73, 88, NULL, 'a) Siete años', NULL, '2026-02-26 12:23:35'),
(755, 73, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:23:35'),
(756, 74, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:23:49'),
(757, 74, 81, NULL, 'd) Subordinación al superior jerárquico', NULL, '2026-02-26 12:23:49'),
(758, 74, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:23:49'),
(759, 74, 83, NULL, 'c) Por servidores públicos y particulares identificables', NULL, '2026-02-26 12:23:49'),
(760, 74, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:23:49'),
(761, 74, 85, NULL, 'b) Que fueron subsanadas espontáneamente', NULL, '2026-02-26 12:23:49'),
(762, 74, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:23:49'),
(763, 74, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:23:49'),
(764, 74, 88, NULL, 'a) Siete años', NULL, '2026-02-26 12:23:49'),
(765, 74, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:23:49'),
(766, 75, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:23:54'),
(767, 75, 81, NULL, 'd) Subordinación al superior jerárquico', NULL, '2026-02-26 12:23:54'),
(768, 75, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:23:54'),
(769, 75, 83, NULL, 'c) Por servidores públicos y particulares identificables', NULL, '2026-02-26 12:23:54'),
(770, 75, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:23:54'),
(771, 75, 85, NULL, 'b) Que fueron subsanadas espontáneamente', NULL, '2026-02-26 12:23:54'),
(772, 75, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:23:54'),
(773, 75, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:23:54'),
(774, 75, 88, NULL, 'a) Siete años', NULL, '2026-02-26 12:23:54'),
(775, 75, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:23:54'),
(776, 76, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:24:10'),
(777, 76, 81, NULL, 'a) Legalidad', NULL, '2026-02-26 12:24:10'),
(778, 76, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:24:10'),
(779, 76, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:24:10'),
(780, 76, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:24:10'),
(781, 76, 85, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 12:24:10'),
(782, 76, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:24:10'),
(783, 76, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:24:10'),
(784, 76, 88, NULL, 'b) Tres años', NULL, '2026-02-26 12:24:10'),
(785, 76, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:24:10'),
(796, 78, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:24:55'),
(797, 78, 81, NULL, 'd) Subordinación al superior jerárquico', NULL, '2026-02-26 12:24:55'),
(798, 78, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:24:55'),
(799, 78, 83, NULL, 'a) Únicamente por servidor publico identificable', NULL, '2026-02-26 12:24:55'),
(800, 78, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:24:55'),
(801, 78, 85, NULL, 'b) Que fueron subsanadas espontáneamente', NULL, '2026-02-26 12:24:55'),
(802, 78, 86, NULL, 'b) No', NULL, '2026-02-26 12:24:55'),
(803, 78, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:24:55'),
(804, 78, 88, NULL, 'a) Siete años', NULL, '2026-02-26 12:24:55'),
(805, 78, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:24:55'),
(816, 80, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:25:58'),
(817, 80, 81, NULL, 'a) Legalidad', NULL, '2026-02-26 12:25:58'),
(818, 80, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:25:58'),
(819, 80, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:25:58'),
(820, 80, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:25:58'),
(821, 80, 85, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 12:25:58'),
(822, 80, 86, NULL, 'c) No siempre', NULL, '2026-02-26 12:25:58'),
(823, 80, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:25:58'),
(824, 80, 88, NULL, 'a) Siete años', NULL, '2026-02-26 12:25:58'),
(825, 80, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:25:58'),
(836, 82, 80, NULL, 'a) Artículo 16', NULL, '2026-02-26 12:26:39'),
(837, 82, 81, NULL, 'a) Legalidad', NULL, '2026-02-26 12:26:39'),
(838, 82, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:26:39'),
(839, 82, 83, NULL, 'c) Por servidores públicos y particulares identificables', NULL, '2026-02-26 12:26:39'),
(840, 82, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:26:39'),
(841, 82, 85, NULL, 'b) Que fueron subsanadas espontáneamente', NULL, '2026-02-26 12:26:39'),
(842, 82, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:26:39'),
(843, 82, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:26:39'),
(844, 82, 88, NULL, 'b) Tres años', NULL, '2026-02-26 12:26:39'),
(845, 82, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:26:39'),
(846, 83, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:26:40'),
(847, 83, 81, NULL, 'a) Legalidad', NULL, '2026-02-26 12:26:40'),
(848, 83, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:26:40'),
(849, 83, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:26:40'),
(850, 83, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:26:40'),
(851, 83, 85, NULL, 'c) Errores intencionales', NULL, '2026-02-26 12:26:40'),
(852, 83, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:26:40'),
(853, 83, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:26:40'),
(854, 83, 88, NULL, 'b) Tres años', NULL, '2026-02-26 12:26:40'),
(855, 83, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:26:40'),
(856, 84, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:27:35'),
(857, 84, 81, NULL, 'a) Legalidad', NULL, '2026-02-26 12:27:35'),
(858, 84, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:27:35'),
(859, 84, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:27:35'),
(860, 84, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:27:35'),
(861, 84, 85, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 12:27:35'),
(862, 84, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:27:35'),
(863, 84, 87, NULL, 'c) No siempre', NULL, '2026-02-26 12:27:35'),
(864, 84, 88, NULL, 'b) Tres años', NULL, '2026-02-26 12:27:35'),
(865, 84, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:27:35'),
(866, 85, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:27:53'),
(867, 85, 81, NULL, 'a) Legalidad', NULL, '2026-02-26 12:27:53'),
(868, 85, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:27:53'),
(869, 85, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:27:53'),
(870, 85, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:27:53'),
(871, 85, 85, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 12:27:53'),
(872, 85, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:27:53'),
(873, 85, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:27:53'),
(874, 85, 88, NULL, 'a) Siete años', NULL, '2026-02-26 12:27:53'),
(875, 85, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:27:53'),
(876, 86, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:28:59'),
(877, 86, 81, NULL, 'a) Legalidad', NULL, '2026-02-26 12:28:59'),
(878, 86, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:28:59'),
(879, 86, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 12:28:59'),
(880, 86, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:28:59'),
(881, 86, 85, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 12:28:59'),
(882, 86, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:28:59'),
(883, 86, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:28:59'),
(884, 86, 88, NULL, 'b) Tres años', NULL, '2026-02-26 12:28:59'),
(885, 86, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:28:59'),
(896, 88, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:38:42'),
(897, 88, 81, NULL, 'd) Subordinación al superior jerárquico', NULL, '2026-02-26 12:38:42'),
(898, 88, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:38:42'),
(899, 88, 83, NULL, 'c) Por servidores públicos y particulares identificables', NULL, '2026-02-26 12:38:42'),
(900, 88, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:38:42'),
(901, 88, 85, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 12:38:42'),
(902, 88, 86, NULL, 'a) Sí', NULL, '2026-02-26 12:38:42'),
(903, 88, 87, NULL, 'b) No', NULL, '2026-02-26 12:38:42'),
(904, 88, 88, NULL, 'a) Siete años', NULL, '2026-02-26 12:38:42'),
(905, 88, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:38:42'),
(906, 89, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 12:38:49'),
(907, 89, 81, NULL, 'd) Subordinación al superior jerárquico', NULL, '2026-02-26 12:38:49'),
(908, 89, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 12:38:49'),
(909, 89, 83, NULL, 'c) Por servidores públicos y particulares identificables', NULL, '2026-02-26 12:38:49'),
(910, 89, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 12:38:49'),
(911, 89, 85, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 12:38:49'),
(912, 89, 86, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 12:38:49'),
(913, 89, 87, NULL, 'a) Sí', NULL, '2026-02-26 12:38:49'),
(914, 89, 88, NULL, 'a) Siete años', NULL, '2026-02-26 12:38:49'),
(915, 89, 89, NULL, 'b) No grave', NULL, '2026-02-26 12:38:49'),
(916, 90, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 13:45:49'),
(917, 90, 81, NULL, 'd) Subordinación al superior jerárquico', NULL, '2026-02-26 13:45:49'),
(918, 90, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 13:45:49'),
(919, 90, 83, NULL, 'c) Por servidores públicos y particulares identificables', NULL, '2026-02-26 13:45:49'),
(920, 90, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 13:45:49'),
(921, 90, 85, NULL, 'c) Errores intencionales', NULL, '2026-02-26 13:45:49'),
(922, 90, 86, NULL, 'c) No siempre', NULL, '2026-02-26 13:45:49'),
(923, 90, 87, NULL, 'a) Sí', NULL, '2026-02-26 13:45:49'),
(924, 90, 88, NULL, 'b) Tres años', NULL, '2026-02-26 13:45:49'),
(925, 90, 89, NULL, 'b) No grave', NULL, '2026-02-26 13:45:49'),
(926, 91, 80, NULL, 'a) Artículo 16', NULL, '2026-02-26 14:31:25'),
(927, 91, 81, NULL, 'd) Subordinación al superior jerárquico', NULL, '2026-02-26 14:31:25'),
(928, 91, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 14:31:25'),
(929, 91, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 14:31:25'),
(930, 91, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 14:31:25'),
(931, 91, 85, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 14:31:25'),
(932, 91, 86, NULL, 'a) Sí', NULL, '2026-02-26 14:31:25'),
(933, 91, 87, NULL, 'a) Sí', NULL, '2026-02-26 14:31:25'),
(934, 91, 88, NULL, 'a) Siete años', NULL, '2026-02-26 14:31:25'),
(935, 91, 89, NULL, 'b) No grave', NULL, '2026-02-26 14:31:25'),
(936, 92, 80, NULL, 'd) Artículo 108', NULL, '2026-02-26 14:33:00'),
(937, 92, 81, NULL, 'a) Legalidad', NULL, '2026-02-26 14:33:00'),
(938, 92, 82, NULL, 'a) Por medio de oficio', NULL, '2026-02-26 14:33:00'),
(939, 92, 83, NULL, 'd) Por particulares y servidores públicos sean identificables o no', NULL, '2026-02-26 14:33:00'),
(940, 92, 84, NULL, 'a) Imparcialidad', NULL, '2026-02-26 14:33:00'),
(941, 92, 85, NULL, 'd) Ninguna de las anteriores', NULL, '2026-02-26 14:33:00'),
(942, 92, 86, NULL, 'a) Sí', NULL, '2026-02-26 14:33:00'),
(943, 92, 87, NULL, 'a) Sí', NULL, '2026-02-26 14:33:00'),
(944, 92, 88, NULL, 'b) Tres años', NULL, '2026-02-26 14:33:00'),
(945, 92, 89, NULL, 'b) No grave', NULL, '2026-02-26 14:33:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(120) NOT NULL,
  `role` enum('ADMIN','COURSES','PARTICIPANTS','CERTIFICATES','READONLY') NOT NULL DEFAULT 'ADMIN',
  `status` enum('ACTIVE','DISABLED') NOT NULL DEFAULT 'ACTIVE',
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` int NOT NULL,
  `role` enum('ADMIN','COURSES','PARTICIPANTS','CERTIFICATES','READONLY') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_admin_resets_admin` (`admin_id`),
  ADD KEY `idx_admin_resets_expires` (`expires_at`),
  ADD KEY `idx_admin_password_resets_email` (`email`),
  ADD KEY `idx_admin_password_resets_expires_at` (`expires_at`);

--
-- Indices de la tabla `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`admin_id`,`role`);

--
-- Indices de la tabla `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `participant_id` (`participant_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indices de la tabla `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `encuestas_satisfaccion`
--
ALTER TABLE `encuestas_satisfaccion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_encuesta_respuesta` (`respuesta_id`),
  ADD UNIQUE KEY `uk_encuesta_folio` (`folio`),
  ADD KEY `idx_encuesta_curso` (`curso_id`),
  ADD KEY `idx_encuesta_evaluacion` (`evaluacion_id`);

--
-- Indices de la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_id` (`curso_id`);

--
-- Indices de la tabla `inscripciones_curso`
--
ALTER TABLE `inscripciones_curso`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_inscripcion_curso_correo` (`curso_id`,`correo`),
  ADD UNIQUE KEY `uk_inscripcion_curso_telefono` (`curso_id`,`telefono`),
  ADD KEY `idx_inscripciones_curso` (`curso_id`);

--
-- Indices de la tabla `opciones_pregunta`
--
ALTER TABLE `opciones_pregunta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_opciones_pregunta` (`pregunta_id`);

--
-- Indices de la tabla `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_preguntas_eval` (`evaluacion_id`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `folio` (`folio`),
  ADD KEY `evaluacion_id` (`evaluacion_id`),
  ADD KEY `idx_respuestas_curso` (`curso_id`);

--
-- Indices de la tabla `respuestas_detalle`
--
ALTER TABLE `respuestas_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pregunta_id` (`pregunta_id`),
  ADD KEY `idx_detalle_respuesta` (`respuesta_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `encuestas_satisfaccion`
--
ALTER TABLE `encuestas_satisfaccion`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `inscripciones_curso`
--
ALTER TABLE `inscripciones_curso`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `opciones_pregunta`
--
ALTER TABLE `opciones_pregunta`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=333;

--
-- AUTO_INCREMENT de la tabla `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT de la tabla `respuestas_detalle`
--
ALTER TABLE `respuestas_detalle`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=946;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD CONSTRAINT `admin_password_resets_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD CONSTRAINT `admin_roles_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `encuestas_satisfaccion`
--
ALTER TABLE `encuestas_satisfaccion`
  ADD CONSTRAINT `encuestas_satisfaccion_ibfk_1` FOREIGN KEY (`respuesta_id`) REFERENCES `respuestas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `encuestas_satisfaccion_ibfk_2` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `encuestas_satisfaccion_ibfk_3` FOREIGN KEY (`evaluacion_id`) REFERENCES `evaluaciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
  ADD CONSTRAINT `evaluaciones_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inscripciones_curso`
--
ALTER TABLE `inscripciones_curso`
  ADD CONSTRAINT `inscripciones_curso_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `opciones_pregunta`
--
ALTER TABLE `opciones_pregunta`
  ADD CONSTRAINT `opciones_pregunta_ibfk_1` FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `preguntas_ibfk_1` FOREIGN KEY (`evaluacion_id`) REFERENCES `evaluaciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `respuestas_ibfk_2` FOREIGN KEY (`evaluacion_id`) REFERENCES `evaluaciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `respuestas_detalle`
--
ALTER TABLE `respuestas_detalle`
  ADD CONSTRAINT `respuestas_detalle_ibfk_1` FOREIGN KEY (`respuesta_id`) REFERENCES `respuestas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `respuestas_detalle_ibfk_2` FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
