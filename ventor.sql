-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-05-2019 a las 17:12:19
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ventor`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hsl` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `padre_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tipo` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `image`, `color`, `hsl`, `orden`, `padre_id`, `tipo`, `created_at`, `updated_at`) VALUES
(2, 'Motor', 'images/categorias/1557237443.png', '#e4522b', 'invert(37%) sepia(85%) saturate(1107%) hue-rotate(342deg) brightness(92%) contrast(94%);', 'AA', NULL, 0, '2019-05-07 16:33:40', '2019-05-07 16:57:24'),
(3, 'Refrigeración calefacción', 'images/categorias/1557237095.png', '#1973b1', 'invert(37%) sepia(34%) saturate(1558%) hue-rotate(168deg) brightness(93%) contrast(93%);', 'bb', NULL, 0, '2019-05-07 16:51:35', '2019-05-07 16:51:35'),
(4, 'Combustible', 'images/categorias/1557237657.png', '#128833', 'invert(34%) sepia(72%) saturate(6607%) hue-rotate(137deg) brightness(92%) contrast(86%);', 'cc', NULL, 0, '2019-05-07 17:00:57', '2019-05-07 17:00:57'),
(5, 'Electricidad', 'images/categorias/1557239783.png', '#d00d52', 'invert(11%) sepia(87%) saturate(4178%) hue-rotate(328deg) brightness(117%) contrast(99%);', 'dd', NULL, 0, '2019-05-07 17:35:23', '2019-05-07 17:36:23'),
(6, 'Embrague, cables de comando y freno', 'images/categorias/1557239839.png', '#96bd29', 'invert(55%) sepia(5%) saturate(4356%) hue-rotate(35deg) brightness(117%) contrast(110%);', 'ee', NULL, 0, '2019-05-07 17:37:19', '2019-05-07 17:37:19'),
(7, 'Semieje, caja diferencial y cardán', 'images/categorias/1557240406.png', '#06a094', 'invert(44%) sepia(71%) saturate(508%) hue-rotate(126deg) brightness(97%) contrast(100%);', 'FF', NULL, 0, '2019-05-07 17:46:46', '2019-05-07 17:46:46'),
(8, 'Herramientas químicos varios', 'images/categorias/1557240727.png', '#f5b243', 'invert(88%) sepia(9%) saturate(5014%) hue-rotate(327deg) brightness(102%) contrast(92%);', 'GG', NULL, 0, '2019-05-07 17:52:07', '2019-05-07 17:52:07'),
(9, 'Suspensión, dirección y rueda', 'images/categorias/1557240772.png', '#61267f', 'invert(23%) sepia(51%) saturate(1817%) hue-rotate(253deg) brightness(80%) contrast(101%);', 'hh', NULL, 0, '2019-05-07 17:52:52', '2019-05-07 18:42:33'),
(10, 'Mangueras', 'images/categorias/1557240819.png', '#5f7d8c', 'invert(51%) sepia(6%) saturate(1714%) hue-rotate(156deg) brightness(91%) contrast(87%);', 'ii', NULL, 0, '2019-05-07 17:53:39', '2019-05-07 17:53:39'),
(11, 'Correas Agrículas', 'images/categorias/1557240854.png', '#e68100', 'invert(72%) sepia(59%) saturate(6586%) hue-rotate(11deg) brightness(101%) contrast(102%);', 'jj', NULL, 0, '2019-05-07 17:54:14', '2019-05-07 17:54:14'),
(12, 'Correas Automotor', 'images/categorias/1557240913.png', '#ed1d24', 'invert(26%) sepia(82%) saturate(4264%) hue-rotate(343deg) brightness(89%) contrast(112%);', 'kk', NULL, 0, '2019-05-07 17:55:13', '2019-05-07 17:55:13'),
(13, 'Suspensión y dirección', 'images/subcategorias/1557245939-1.jpg', NULL, NULL, 'AA', 9, 1, '2019-05-07 18:55:34', '2019-05-07 19:18:59'),
(14, 'Ruedas', 'images/subcategorias/1557245985-1.jpg', NULL, NULL, 'bb', 9, 1, '2019-05-07 19:00:34', '2019-05-07 19:19:45'),
(15, 'Barras estabilizadoras', 'images/subcategorias/1557246325-2.jpg', NULL, NULL, 'AA', 13, 2, '2019-05-07 19:25:25', '2019-05-07 19:25:25'),
(16, 'Partes de suspensión', 'images/subcategorias/1557246493-2.jpg', NULL, NULL, 'BB', 13, 2, '2019-05-07 19:28:13', '2019-05-07 19:28:13'),
(17, 'Partes de amortiguador y elásticos', 'images/subcategorias/1557246648-2.jpg', NULL, NULL, 'cc', 13, 2, '2019-05-07 19:30:48', '2019-05-07 19:30:48'),
(18, 'Partes de dirección', 'images/subcategorias/1557246894-2.jpg', NULL, NULL, 'DD', 13, 2, '2019-05-07 19:34:54', '2019-05-07 19:34:54'),
(19, 'Fuelles de caja de dirección', 'images/subcategorias/1557247068-2.jpg', NULL, NULL, 'EE', 13, 2, '2019-05-07 19:37:48', '2019-05-07 19:37:48'),
(20, 'Rótulas y extremos', 'images/subcategorias/1557247094-2.jpg', NULL, NULL, 'ff', 13, 2, '2019-05-07 19:38:14', '2019-05-07 19:38:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenidos`
--

CREATE TABLE `contenidos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seccion` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contenidos`
--

INSERT INTO `contenidos` (`id`, `seccion`, `data`, `created_at`, `updated_at`) VALUES
(1, 'empresa', '{\"CONTENIDO\":{\"es\":{\"texto\":\"<p>Somos una empresa dedicada a la distribuci&oacute;n mayorista de autopartes de las m&aacute;s importantes f&aacute;bricas del pa&iacute;s, con m&aacute;s de 16.000 productos, con stock permanente para los autos de mayor circulaci&oacute;n.<\\/p>\\r\\n\\r\\n<p>Nuestro cat&aacute;logo incluye una amplia gama de repuestos MARCA VENTOR, que cubren las necesidades de despiece de distintos modelos.<\\/p>\\r\\n\\r\\n<p>Somos importadores exclusivos de correas agr&iacute;colas e industriales CARLISLE (USA). Tambi&eacute;n importamos correas automotor MITSUBA, crucetas KYM y PRECISION, mangueras PARKER y TOP LEATHER, mangas MEGADYNE, cadenas BORG WARNER, abrazaderas BREEZE.<\\/p>\\r\\n\\r\\n<p>Nuestra fuerza de ventas se localiza en todo el pa&iacute;s, con vendedores exclusivos. Y en nuestra sede, ya que todo el staff est&aacute; dedicado a la atenci&oacute;n y servicio al cliente, en todos los departamentos.<\\/p>\",\"numeros\":[{\"N\":\"16000\",\"T\":\"productos\"},{\"N\":\"61\",\"T\":\"a\\u00f1os en el rubro\"},{\"N\":\"1960\",\"T\":\"nuestra fundaci\\u00f3n\"}],\"fechas\":{\"1960\":\"<p>VENTOR naci&oacute; en 1960, cuando cuatro amigos, todos ex-ejecutivos de una empresa l&iacute;der en el mercado autopartista apostaron a una empresa propia.<\\/p>\\r\\n\\r\\n<p>Era la &eacute;poca en la que comenzaba a desarrollarse la industria automotriz en la Argentina, con el consiguiente incremento del mercado de reposici&oacute;n: crec&iacute;a la demanda de repuestos.<\\/p>\",\"1970\":null,\"1980\":null,\"1990\":null,\"2000\":null,\"2010\":null},\"vision\":{\"TIT\":\"Nuestra visi\\u00f3n\",\"TEX\":\"<p>Ser la primera opci&oacute;n que imagine un repuestero cuando decida iniciar su empresa, expandirla, diversificarla, o reinventarla. Ser el primer proveedor a quien consulte todo el que necesite transmitir potencia.<\\/p>\"},\"mision\":{\"TIT\":\"Nuestra misi\\u00f3n\",\"TEX\":\"<p>Desde su fundaci&oacute;n en 1960, la misi&oacute;n de VENTOR ha sido ofrecer a nuestros clientes la posibilidad de desarrollar sus emprendimientos con nuestro asesoramiento y apoyo, provey&eacute;ndoles los mejores productos y la mejor atenci&oacute;n personal, comercial y t&eacute;cnica.<\\/p>\"}}},\"PAGE\":[\"slider\"]}', '2019-05-06 15:22:20', '2019-05-09 02:40:58'),
(2, 'calidad', '{\"CONTENIDO\":{\"es\":{\"principal\":{\"titulo\":\"CALIDAD VENTOR\",\"subtitulo\":\"Pol\\u00edticas y Normas de Calidad\",\"texto\":\"<p>Desde su creaci&oacute;n, VENTOR S. A. C. e I. ha estado comprometida en ofrecer a sus clientes una atenci&oacute;n con alto nivel de calidad, en la comercializaci&oacute;n de repuestos y correas agr&iacute;colas, industriales y automotor, nacionales e importadas, que satisfagan sus requisitos y expectativas.<\\/p>\\r\\n\\r\\n<p>La Direcci&oacute;n de VENTOR S.A.C quiere manifestar a trav&eacute;s de esta POL&Iacute;TICA a sus empleados, clientes y proveedores, su convencimiento.<\\/p>\",\"slogan\":\"Comprometidos con la seguridad, la salud laboral y la excelencia de productos y servicios\"},\"calidad\":{\"titulo\":\"Pol\\u00edtica de calidad\",\"texto\":\"<p>La calidad es un factor clave en el futuro de VENTOR SACeI y debe ser asumida con responsabilidad por todos sus integrantes, comenzando por la Direcci&oacute;n. La calidad radica en prevenir, m&aacute;s que en corregir errores.<\\/p>\\r\\n\\r\\n<p>La calidad ser&aacute; siempre objeto de mejora continua en VENTOR SACeI. Se aprovechar&aacute;n los errores para mejorar y se pondr&aacute; todo el empe&ntilde;o en detectar las causas que los produjeron, para que no se repitan.<\\/p>\\r\\n\\r\\n<p>VENTOR SAC asume como principales OBJETIVOS:<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>Obtener la m&aacute;xima satisfacci&oacute;n posible del cliente, externo e interno.<\\/li>\\r\\n\\t<li>Proporcionar los productos y servicios requeridos en el tiempo y en la forma convenida.<\\/li>\\r\\n\\t<li>Facilitar la innovaci&oacute;n tecnol&oacute;gica y capacitar al personal y clientes interesados.<\\/li>\\r\\n\\t<li>Incrementar nuestra participaci&oacute;n en el mercado dentro de un marco de rentabilidad para VENTOR SACeI.<\\/li>\\r\\n\\t<li>Mantener y mejorar permanentemente la efectividad de nuestro Sistema de Gesti&oacute;n de la Calidad.<\\/li>\\r\\n<\\/ul>\"},\"garantia\":{\"titulo\":\"Pol\\u00edticas de Garant\\u00edas\",\"texto\":null}}}}', '2019-05-07 20:33:12', '2019-05-07 20:55:57'),
(3, 'terminos', '{\"CONTENIDO\":{\"es\":{\"titulo\":\"T\\u00e9rminos y condiciones\",\"texto\":\"<p><strong>INFORMACI&Oacute;N RELEVANTE<\\/strong><\\/p>\\r\\n\\r\\n<p>Es requisito necesario para la adquisici&oacute;n de los productos que se ofrecen en este sitio, que lea y acepte los siguientes T&eacute;rminos y Condiciones que a continuaci&oacute;n se redactan. El uso de nuestros servicios as&iacute; como la compra de nuestros productos implicar&aacute; que usted ha le&iacute;do y aceptado los T&eacute;rminos y Condiciones de Uso en el presente documento. Todas los productos &nbsp;que son ofrecidos por nuestro sitio web pudieran ser creadas, cobradas, enviadas o presentadas por una p&aacute;gina web tercera y en tal caso estar&iacute;an sujetas a sus propios T&eacute;rminos y Condiciones. En algunos casos, para adquirir un producto, ser&aacute; necesario el registro por parte del usuario, con ingreso de datos personales fidedignos y definici&oacute;n de una contrase&ntilde;a.<\\/p>\\r\\n\\r\\n<p>El usuario puede elegir y cambiar la clave para su acceso de administraci&oacute;n de la cuenta en cualquier momento, en caso de que se haya registrado y que sea necesario para la compra de alguno de nuestros productos. ventor.com.ar no asume la responsabilidad en caso de que entregue dicha clave a terceros.<\\/p>\\r\\n\\r\\n<p>Todas las compras y transacciones que se lleven a cabo por medio de este sitio web, est&aacute;n sujetas a un proceso de confirmaci&oacute;n y verificaci&oacute;n, el cual podr&iacute;a incluir la verificaci&oacute;n del stock y disponibilidad de producto, validaci&oacute;n de la forma de pago, validaci&oacute;n de la factura (en caso de existir) y el cumplimiento de las condiciones requeridas por el medio de pago seleccionado. En algunos casos puede que se requiera una verificaci&oacute;n por medio de correo electr&oacute;nico.<\\/p>\\r\\n\\r\\n<p>Los precios de los productos ofrecidos en esta Tienda Online es v&aacute;lido solamente en las compras realizadas en este sitio web.<\\/p>\\r\\n\\r\\n<p><strong>LICENCIA<\\/strong><\\/p>\\r\\n\\r\\n<p>VENTOR&nbsp; a trav&eacute;s de su sitio web concede una licencia para que los usuarios utilicen&nbsp; los productos que son vendidos en este sitio web de acuerdo a los T&eacute;rminos y Condiciones que se describen en este documento.<\\/p>\\r\\n\\r\\n<p><strong>USO NO AUTORIZADO<\\/strong><\\/p>\\r\\n\\r\\n<p>En caso de que aplique (para venta de software, templetes, u otro producto de dise&ntilde;o y programaci&oacute;n) usted no puede colocar uno de nuestros productos, modificado o sin modificar, en un CD, sitio web o ning&uacute;n otro medio y ofrecerlos para la redistribuci&oacute;n o la reventa de ning&uacute;n tipo.<\\/p>\\r\\n\\r\\n<p><strong>PROPIEDAD<\\/strong><\\/p>\\r\\n\\r\\n<p>Usted no puede declarar propiedad intelectual o exclusiva a ninguno de nuestros productos, modificado o sin modificar. Todos los productos son propiedad &nbsp;de los proveedores del contenido. En caso de que no se especifique lo contrario, nuestros productos se proporcionan&nbsp; sin ning&uacute;n tipo de garant&iacute;a, expresa o impl&iacute;cita. En ning&uacute;n esta compa&ntilde;&iacute;a ser&aacute; &nbsp;responsables de ning&uacute;n da&ntilde;o incluyendo, pero no limitado a, da&ntilde;os directos, indirectos, especiales, fortuitos o consecuentes u otras p&eacute;rdidas resultantes del uso o de la imposibilidad de utilizar nuestros productos.<\\/p>\\r\\n\\r\\n<p><strong>POL&Iacute;TICA DE REEMBOLSO Y GARANT&Iacute;A<\\/strong><\\/p>\\r\\n\\r\\n<p>En el caso de productos que sean&nbsp; mercanc&iacute;as irrevocables no-tangibles, no realizamos reembolsos despu&eacute;s de que se env&iacute;e el producto, usted tiene la responsabilidad de entender antes de comprarlo. &nbsp;Le pedimos que lea cuidadosamente antes de comprarlo. Hacemos solamente excepciones con esta regla cuando la descripci&oacute;n no se ajusta al producto. Hay algunos productos que pudieran tener garant&iacute;a y posibilidad de reembolso pero este ser&aacute; especificado al comprar el producto. En tales casos la garant&iacute;a solo cubrir&aacute; fallas de f&aacute;brica y s&oacute;lo se har&aacute; efectiva cuando el producto se haya usado correctamente. La garant&iacute;a no cubre aver&iacute;as o da&ntilde;os ocasionados por uso indebido. Los t&eacute;rminos de la garant&iacute;a est&aacute;n asociados a fallas de fabricaci&oacute;n y funcionamiento en condiciones normales de los productos y s&oacute;lo se har&aacute;n efectivos estos t&eacute;rminos si el equipo ha sido usado correctamente. Esto incluye:<\\/p>\\r\\n\\r\\n<p>&ndash; De acuerdo a las especificaciones t&eacute;cnicas indicadas para cada producto.<br \\/>\\r\\n&ndash; En condiciones ambientales acorde con las especificaciones indicadas por el fabricante.<br \\/>\\r\\n&ndash; En uso espec&iacute;fico para la funci&oacute;n con que fue dise&ntilde;ado de f&aacute;brica.<br \\/>\\r\\n&ndash; En condiciones de operaci&oacute;n el&eacute;ctricas acorde con las especificaciones y tolerancias indicadas.<\\/p>\\r\\n\\r\\n<p><strong>COMPROBACI&Oacute;N ANTIFRAUDE<\\/strong><\\/p>\\r\\n\\r\\n<p>La compra del cliente puede ser aplazada para la comprobaci&oacute;n antifraude. Tambi&eacute;n puede ser suspendida por m&aacute;s tiempo para una investigaci&oacute;n m&aacute;s rigurosa, para evitar transacciones fraudulentas.<\\/p>\\r\\n\\r\\n<p><strong>PRIVACIDAD<\\/strong><\\/p>\\r\\n\\r\\n<p>Este&nbsp;<a href=\\\"http:\\/\\/www.lasvegas.es\\/\\\" target=\\\"_blank\\\">sitio web<\\/a>&nbsp;ventor.com.ar garantiza que la informaci&oacute;n personal que usted env&iacute;a cuenta con la seguridad necesaria. Los datos ingresados por usuario o en el caso de requerir una validaci&oacute;n de los pedidos no ser&aacute;n entregados a terceros, salvo que deba ser revelada en cumplimiento a una orden judicial o requerimientos legales.<\\/p>\\r\\n\\r\\n<p>La suscripci&oacute;n a boletines de correos electr&oacute;nicos publicitarios es voluntaria y podr&iacute;a ser seleccionada al momento de crear su cuenta.<\\/p>\\r\\n\\r\\n<p>VENTOR reserva los derechos de cambiar o de modificar estos t&eacute;rminos sin previo aviso.<\\/p>\"}}}', '2019-05-07 22:19:00', '2019-05-07 22:22:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descargas`
--

CREATE TABLE `descargas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `orden` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `documento` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `descargas`
--

INSERT INTO `descargas` (`id`, `orden`, `documento`, `nombre`, `image`, `created_at`, `updated_at`) VALUES
(1, 'AA', 'images/descargas/documentacion-tecnica.pdf', 'Documentación Técnica', NULL, '2019-05-09 20:35:55', '2019-05-09 20:35:55'),
(2, 'bb', 'images/descargas/recomendaciones-de-seguridad.pdf', 'Recomendaciones de seguridad', NULL, '2019-05-09 20:44:15', '2019-05-09 20:44:15'),
(3, 'CC', NULL, 'Mantenimiento de piezas Ventor', NULL, '2019-05-09 20:44:47', '2019-05-09 20:44:47'),
(4, 'DD', NULL, 'Controles de calidad Ventro', NULL, '2019-05-09 20:45:08', '2019-05-09 20:45:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id` int(11) NOT NULL,
  `banco` text COLLATE utf8mb4_unicode_ci,
  `pago` text COLLATE utf8mb4_unicode_ci,
  `telefono` text COLLATE utf8mb4_unicode_ci,
  `domicilio` text COLLATE utf8mb4_unicode_ci,
  `email` text COLLATE utf8mb4_unicode_ci,
  `redes` text COLLATE utf8mb4_unicode_ci,
  `metadatos` longtext COLLATE utf8mb4_unicode_ci,
  `images` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id`, `banco`, `pago`, `telefono`, `domicilio`, `email`, `redes`, `metadatos`, `images`, `created_at`, `updated_at`) VALUES
(1, '<p><span style=\"color:#0099d8\">NUEVA CUENTA</span><br />\r\nMACRO, C. C. Nro. 350709417613672, SUC 507<br />\r\nCBU: 2850507730094176136721</p>\r\n\r\n<p>CREDICOOP, C. C. Nro. 21861-3, SUC 043<br />\r\nCBU: 1910043855004302186132</p>\r\n\r\n<p>NACI&Oacute;N, C. C. Nro. 314007-55, SUC 0084<br />\r\nCBU: 0110062420000314007557</p>\r\n\r\n<p>PCIA B. AIRES, C. C. Nro 12645-0, SUC 4007<br />\r\nCBU: 0140007601400701264506</p>', '<h2><span style=\"color:#0099d8\">Condiciones de pago vigentes a marzo 2019</span></h2>\r\n\r\n<p>Pago a 7 d&iacute;as de la fecha de factura: Descuento de 15%</p>\r\n\r\n<p>Pago a 30 d&iacute;as de la fecha de factura: Descuento de 12%</p>\r\n\r\n<p>Pago a 45 d&iacute;as de la fecha de factura: Descuento de 8%</p>\r\n\r\n<p>Pago a 60 d&iacute;as de la fecha de factura: Sin descuento</p>', '{\"tel\":[\"11-4583-1542\"]}', '{\"calle\":\"Av. Gaona\",\"altura\":\"1547 \\/ 53\",\"barrio\":null}', '[\"ventor@ventor.com.ar\"]', NULL, '{\"home\":{\"descripcion\":null,\"metas\":null},\"empresa\":{\"descripcion\":null,\"metas\":null},\"productos\":{\"descripcion\":null,\"metas\":null},\"descargas\":{\"descripcion\":null,\"metas\":null},\"calidad\":{\"descripcion\":null,\"metas\":null},\"contacto\":{\"descripcion\":null,\"metas\":null}}', '{\"logo\":\"images\\/empresa\\/logo.png\",\"logoFooter\":\"images\\/empresa\\/logoFooter.png\",\"favicon\":\"images\\/empresa\\/logoFooter.png\"}', '2019-05-07 22:53:33', '2019-05-09 22:11:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `padre_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre`, `image`, `padre_id`, `created_at`, `updated_at`) VALUES
(5, 'Chery', 'images/marcas/1557267321.gif', NULL, '2019-05-08 01:15:21', '2019-05-08 01:15:21'),
(6, 'TIGGO 2008', NULL, 5, '2019-05-08 01:15:35', '2019-05-08 01:15:35'),
(7, 'Chevrolet', 'images/marcas/1557336158.png', NULL, '2019-05-08 20:22:38', '2019-05-08 20:22:38'),
(8, 'Aveo', NULL, 7, '2019-05-08 20:23:06', '2019-05-08 20:23:06'),
(9, 'Captiva', NULL, 7, '2019-05-08 20:23:30', '2019-05-08 20:23:30'),
(10, 'Corsa', NULL, 7, '2019-05-08 20:23:36', '2019-05-08 20:23:36'),
(11, 'Cruze 11', NULL, 7, '2019-05-08 20:23:52', '2019-05-08 20:23:52'),
(12, 'Cobalt 12', NULL, 7, '2019-05-08 20:24:04', '2019-05-08 20:24:04'),
(13, 'S-10 Blazer', NULL, 7, '2019-05-08 20:24:26', '2019-05-08 20:24:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_05_02_145817_create_slider_table', 1),
(4, '2019_05_02_150123_create_contenido_table', 1),
(6, '2019_05_02_150753_create_empresa_table', 1),
(9, '2019_05_02_150450_create_categoria_table', 2),
(10, '2019_05_07_180202_create_recursos_table', 3),
(12, '2019_05_07_211817_create_marcas_table', 4),
(13, '2019_05_07_223458_create_origenes_table', 5),
(15, '2019_05_08_141629_create_productos_table', 6),
(16, '2019_05_09_171407_create_descargas_table', 7),
(18, '2019_05_10_132327_create_usuarios_table', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `origenes`
--

CREATE TABLE `origenes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `origenes`
--

INSERT INTO `origenes` (`id`, `nombre`, `image`, `created_at`, `updated_at`) VALUES
(4, 'Industria Argentina', 'images/origenes/1557272628.png', '2019-05-08 02:43:48', '2019-05-08 02:43:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `orden` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catalogo` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mercadolibre` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` int(11) NOT NULL DEFAULT '0',
  `precio` double DEFAULT NULL,
  `familia_id` bigint(20) UNSIGNED DEFAULT NULL,
  `categoria_id` bigint(20) UNSIGNED DEFAULT NULL,
  `origen_id` bigint(20) UNSIGNED DEFAULT NULL,
  `marca_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `orden`, `codigo`, `nombre`, `image`, `catalogo`, `link`, `mercadolibre`, `cantidad`, `precio`, `familia_id`, `categoria_id`, `origen_id`, `marca_id`, `created_at`, `updated_at`) VALUES
(1, 'AA', '29016030', '<p>Bieleta de barra estabilizadora<br />Trasera izquierda</p>', 'images/productos/bieleta-de-barra-estabilizadoratrasera-izquierda.jpg', NULL, 'bieleta-de-barra-estabilizadoratrasera-izquierda', NULL, 5, 1200, 9, 15, 4, 6, '2019-05-08 18:36:09', '2019-05-10 15:55:59'),
(2, 'bb', '2906030', '<p>Bieleta de barra estabilizadora<br />delantera para Chery Tiggo</p>', 'images/productos/bieleta-de-barra-estabilizadoradelantera-para-chery-tiggo.jpg', NULL, 'bieleta-de-barra-estabilizadoradelantera-para-chery-tiggo', NULL, 1, NULL, 9, 15, 4, 6, '2019-05-08 20:29:45', '2019-05-08 20:29:45'),
(3, 'cc', '2916040', '<p>Bieleta de barra estabilizadora<br />trasera para Chery Tiggo</p>', 'images/productos/bieleta-de-barra-estabilizadoratrasera-para-chery-tiggo.jpg', NULL, 'bieleta-de-barra-estabilizadoratrasera-para-chery-tiggo', NULL, 1, NULL, 9, 15, 4, 6, '2019-05-08 20:32:04', '2019-05-08 20:32:04'),
(4, 'dd', '96391875', '<p>Bieleta de barra estabilizadora<br />delantera izquierda y derecha</p>', 'images/productos/bieleta-de-barra-estabilizadoradelantera-izquierda-y-derecha.jpg', NULL, 'bieleta-de-barra-estabilizadoradelantera-izquierda-y-derecha', NULL, 1, NULL, 9, 15, 4, 8, '2019-05-08 20:35:33', '2019-05-08 20:35:33'),
(5, 'ee', '96626247', '<p>Bieleta de barra estabilizadora<br />delantera izquierda</p>', 'images/productos/bieleta-de-barra-estabilizadoradelantera-izquierda.jpg', NULL, 'bieleta-de-barra-estabilizadoradelantera-izquierda', NULL, 1, NULL, 9, 15, 4, 9, '2019-05-08 20:42:23', '2019-05-08 20:42:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos`
--

CREATE TABLE `recursos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zona` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `orden` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_zone` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `recursos`
--

INSERT INTO `recursos` (`id`, `titulo`, `zona`, `descripcion`, `orden`, `in_zone`, `created_at`, `updated_at`) VALUES
(1, 'Vendedor', 'Gran Buenos Aires zona sur', NULL, 'AA', 1, '2019-05-07 21:33:37', '2019-05-07 21:45:22'),
(3, 'Vendedor', 'Rosario y Santa Fe norte', NULL, 'BB', 1, '2019-05-07 21:53:43', '2019-05-07 21:53:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seccion` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto` text COLLATE utf8mb4_unicode_ci,
  `link` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sliders`
--

INSERT INTO `sliders` (`id`, `image`, `seccion`, `texto`, `link`, `orden`, `created_at`, `updated_at`) VALUES
(1, 'images/sliders/home/1557144055_home.jpg', 'home', '{\"es\":\"<p>Distribuidor mayorista de<br \\/>\\r\\nrepuestos automotor y correas<\\/p>\\r\\n\\r\\n<p>Amplio cat&aacute;logo de repuestos<\\/p>\"}', 'productos', 'aa', '2019-05-06 15:00:55', '2019-05-06 15:01:52'),
(2, 'images/sliders/empresa/1557144515_empresa.jpg', 'empresa', '{\"es\":\"<p>M&aacute;s de 60 a&ntilde;os<br \\/>\\r\\nde trayectoria<\\/p>\"}', NULL, 'aa', '2019-05-06 15:08:35', '2019-05-06 15:08:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Pablo Cabañuz', 'pablo', '$2y$10$ZbqDQTIEWuKiwgFdWUEdvePdjjLlpdLrP0ew7x0n5bcOSu.V20HPS', 1, NULL, '2019-05-03 17:29:36', '2019-05-03 17:29:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descuento` double(8,2) DEFAULT '0.00',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `name`, `lastname`, `email`, `username`, `password`, `descuento`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Pablo', 'Corzo', 'corzo.pabloariel@gmail.com', 'pCorzo', '$2y$10$G5Xw3n2hpeK6INHNh7dmUO8SoKQPH4cLcSBNyHsknJoIPOLA84cDW', 0.00, NULL, '2019-05-10 16:42:10', '2019-05-10 16:42:10');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorias_padre_id_foreign` (`padre_id`);

--
-- Indices de la tabla `contenidos`
--
ALTER TABLE `contenidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `descargas`
--
ALTER TABLE `descargas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marcas_padre_id_foreign` (`padre_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `origenes`
--
ALTER TABLE `origenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productos_familia_id_foreign` (`familia_id`),
  ADD KEY `productos_categoria_id_foreign` (`categoria_id`),
  ADD KEY `productos_origen_id_foreign` (`origen_id`),
  ADD KEY `productos_marca_id_foreign` (`marca_id`);

--
-- Indices de la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `contenidos`
--
ALTER TABLE `contenidos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `descargas`
--
ALTER TABLE `descargas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `origenes`
--
ALTER TABLE `origenes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `recursos`
--
ALTER TABLE `recursos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_padre_id_foreign` FOREIGN KEY (`padre_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD CONSTRAINT `marcas_padre_id_foreign` FOREIGN KEY (`padre_id`) REFERENCES `marcas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `productos_familia_id_foreign` FOREIGN KEY (`familia_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `productos_marca_id_foreign` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `productos_origen_id_foreign` FOREIGN KEY (`origen_id`) REFERENCES `origenes` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
