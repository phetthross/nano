-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-03-2018 a las 12:44:07
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `amarte`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `m_bodegas`
--

CREATE TABLE `m_bodegas` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `correo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `m_bodegas`
--

INSERT INTO `m_bodegas` (`id`, `descripcion`, `direccion`, `telefono`, `correo`) VALUES
(1, 'Casa Matriz', 'casita en la pradera 123', '7420410', 'amarte@owo.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `m_categoriainsumos`
--

CREATE TABLE `m_categoriainsumos` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `m_categoriainsumos`
--

INSERT INTO `m_categoriainsumos` (`id`, `descripcion`) VALUES
(1, 'Ingredientes'),
(2, 'Otros'),
(3, 'Accesorios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `m_estado`
--

CREATE TABLE `m_estado` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `m_estado`
--

INSERT INTO `m_estado` (`id`, `descripcion`) VALUES
(1, 'ACTIVO'),
(2, 'INACTIVO'),
(3, 'ANULADO POR DEVOLUCION'),
(4, 'MERMA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `m_evento`
--

CREATE TABLE `m_evento` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `m_evento`
--

INSERT INTO `m_evento` (`id`, `descripcion`) VALUES
(1, 'Ingreso de Nueva Bodega'),
(2, 'Actualización de Bodega');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `m_insumos`
--

CREATE TABLE `m_insumos` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `idCategoriaInsumo` int(11) NOT NULL,
  `idBodega` int(11) NOT NULL,
  `idMarca` int(11) NOT NULL,
  `idUnidadMedida` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `m_insumos`
--

INSERT INTO `m_insumos` (`id`, `descripcion`, `idCategoriaInsumo`, `idBodega`, `idMarca`, `idUnidadMedida`) VALUES
(12, 'Durazno Deshidratado', 1, 1, 1, 3),
(13, 'Tetera con Infusor', 3, 1, 1, 1),
(14, 'Té Verde', 1, 1, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `m_marcas`
--

CREATE TABLE `m_marcas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `m_marcas`
--

INSERT INTO `m_marcas` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Generica', 'Generica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `m_movimientos`
--

CREATE TABLE `m_movimientos` (
  `id` int(11) NOT NULL,
  `nombre` int(200) NOT NULL,
  `idTipoMovimiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `m_recetacabecera`
--

CREATE TABLE `m_recetacabecera` (
  `id` int(11) NOT NULL,
  `fechaTransaccion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `descripcion` varchar(200) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `m_recetacabecera`
--

INSERT INTO `m_recetacabecera` (`id`, `fechaTransaccion`, `descripcion`, `activo`) VALUES
(9, '2018-02-01 09:07:27', 'Promoción Tetera + Durazno', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `m_recetadetalle`
--

CREATE TABLE `m_recetadetalle` (
  `id` int(11) NOT NULL,
  `fechaTransaccion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idInsumo` int(11) NOT NULL,
  `idRecetaCabecera` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `m_recetadetalle`
--

INSERT INTO `m_recetadetalle` (`id`, `fechaTransaccion`, `idInsumo`, `idRecetaCabecera`, `cantidad`) VALUES
(16, '2018-02-01 09:07:27', 9, 9, 1),
(17, '2018-02-01 09:07:27', 8, 9, 3),
(18, '2018-02-28 11:46:42', 12, 9, 100),
(19, '2018-02-28 11:53:29', 13, 9, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `m_tipomovimiento`
--

CREATE TABLE `m_tipomovimiento` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `m_tipomovimiento`
--

INSERT INTO `m_tipomovimiento` (`id`, `descripcion`) VALUES
(1, 'COMPRA'),
(2, 'VENTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `m_tipousuarios`
--

CREATE TABLE `m_tipousuarios` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `m_tipousuarios`
--

INSERT INTO `m_tipousuarios` (`id`, `descripcion`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'TRABAJADOR'),
(3, 'CLIENTE (PERSONA NATURAL)'),
(4, 'CLIENTE (EMPRESA)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `m_unidadmedida`
--

CREATE TABLE `m_unidadmedida` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `sigla` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `m_unidadmedida`
--

INSERT INTO `m_unidadmedida` (`id`, `descripcion`, `sigla`) VALUES
(1, 'Unidad', 'Unid'),
(2, 'Kilo', 'KG'),
(3, 'Gramo', 'g'),
(4, 'Litro', 'Lt');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `m_usuarios`
--

CREATE TABLE `m_usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(200) DEFAULT NULL,
  `correo` varchar(200) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `password` varchar(500) DEFAULT NULL,
  `fechaTransaccion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idTipoUsuario` int(11) NOT NULL,
  `rut` int(11) NOT NULL,
  `dv` varchar(1) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `paterno` varchar(200) NOT NULL,
  `materno` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `m_usuarios`
--

INSERT INTO `m_usuarios` (`id`, `username`, `correo`, `telefono`, `celular`, `password`, `fechaTransaccion`, `idTipoUsuario`, `rut`, `dv`, `nombre`, `paterno`, `materno`) VALUES
(1, 'pobrequer', 'pedro.obreque.r@gmail.com', '+56955205283', '+56955205283', '$2y$10$EChkIKL9Ag4wUWVYcN.ye.YhE1ZvgllHWrJzkZ7WYI2jYxuvpCVbu', '2017-12-25 17:37:27', 1, 17598374, '0', 'Pedro', 'Obreque', 'Roa'),
(3, 'fobrequer', 'obreque.roa@gmail.com', '123', '123', '$2y$10$AphWpG1XBs4gQv1b2Qe2xOGJNGjWZv4voLwAVQspJxkBekxVFtCOu', '2017-12-26 18:18:41', 1, 123, '0', 'Francisco', 'Obreque', 'Roa'),
(4, 'cliente', 'cliente@gmail.com', '123', '123', '$2y$10$oE4QrnVwUfIhr/Pm72lCPevYGdzMwZq0ErcKApFz5d6vqUDzbSXhS', '2018-02-08 14:15:41', 3, 7967390, '0', 'Cliente', 'Test Paterno', 'Test Materno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_alertasinventario`
--

CREATE TABLE `t_alertasinventario` (
  `id` int(11) NOT NULL,
  `fechaTransaccion` datetime NOT NULL,
  `idInsumo` int(11) DEFAULT NULL,
  `idCategoriaInsumo` int(11) DEFAULT NULL,
  `cantidadMinima` int(11) DEFAULT NULL,
  `cantidadMaxima` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_cabeceramovimiento`
--

CREATE TABLE `t_cabeceramovimiento` (
  `id` int(11) NOT NULL,
  `idTipoMovimiento` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `fechaTransaccion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaCompra` date NOT NULL,
  `idEstado` int(11) NOT NULL,
  `numeroFactura` varchar(30) DEFAULT NULL,
  `comentarios` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `t_cabeceramovimiento`
--

INSERT INTO `t_cabeceramovimiento` (`id`, `idTipoMovimiento`, `idUsuario`, `idProveedor`, `fechaTransaccion`, `fechaCompra`, `idEstado`, `numeroFactura`, `comentarios`) VALUES
(10, 1, 1, 1, '2018-03-01 12:30:44', '2018-03-01', 1, '', NULL),
(11, 1, 1, 1, '2018-03-01 12:32:04', '2018-02-28', 1, '', NULL),
(12, 1, 1, 1, '2018-03-01 12:33:46', '2018-03-07', 1, '', NULL),
(13, 1, 1, 1, '2018-03-01 12:41:42', '2018-03-01', 1, '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_detallemovimiento`
--

CREATE TABLE `t_detallemovimiento` (
  `id` int(11) NOT NULL,
  `idCabecera` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` decimal(10,0) NOT NULL,
  `bruto` int(11) NOT NULL,
  `iva` int(11) NOT NULL,
  `neto` int(11) NOT NULL,
  `descuento` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `t_detallemovimiento`
--

INSERT INTO `t_detallemovimiento` (`id`, `idCabecera`, `idProducto`, `cantidad`, `bruto`, `iva`, `neto`, `descuento`) VALUES
(10, 10, 13, '10', 1000, 190, 1190, '0'),
(11, 11, 13, '5', 1000, 190, 1190, '0'),
(12, 12, 13, '20', 15000, 2850, 17850, '0'),
(13, 13, 13, '3', 5000, 950, 5950, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_registraevento`
--

CREATE TABLE `t_registraevento` (
  `id` int(11) NOT NULL,
  `fechaTransaccion` datetime NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idEvento` int(11) NOT NULL,
  `visible` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_registramovimientoventacabecera`
--

CREATE TABLE `t_registramovimientoventacabecera` (
  `id` int(11) NOT NULL,
  `fechaTransaccion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUsuario` int(11) NOT NULL,
  `IdCliente` int(11) NOT NULL,
  `idTipoMoviimiento` int(11) NOT NULL,
  `idEstado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_registramovimientoventadetalle`
--

CREATE TABLE `t_registramovimientoventadetalle` (
  `id` int(11) NOT NULL,
  `IdReceta` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `idCabecera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_registrapmp`
--

CREATE TABLE `t_registrapmp` (
  `id` int(11) NOT NULL,
  `fechaTransaccion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idTipoMovimiento` int(11) NOT NULL,
  `idCabecera` int(11) NOT NULL,
  `idInsumo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precioUnitario` int(11) NOT NULL,
  `totalMovimiento` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `pmp` int(11) NOT NULL,
  `totalExistencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `t_registrapmp`
--

INSERT INTO `t_registrapmp` (`id`, `fechaTransaccion`, `idTipoMovimiento`, `idCabecera`, `idInsumo`, `cantidad`, `precioUnitario`, `totalMovimiento`, `stock`, `pmp`, `totalExistencia`) VALUES
(5, '2018-03-01 12:30:44', 1, 10, 13, 10, 119, 1190, 10, 119, 1190),
(6, '2018-03-01 12:32:04', 1, 11, 13, 5, 238, 1190, 15, 179, 2380),
(7, '2018-03-01 12:33:46', 1, 12, 13, 20, 893, 17850, 35, 692, 20230),
(8, '2018-03-01 12:41:42', 1, 13, 13, 3, 1983, 5950, 38, 784, 26180);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `m_bodegas`
--
ALTER TABLE `m_bodegas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `m_categoriainsumos`
--
ALTER TABLE `m_categoriainsumos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `m_estado`
--
ALTER TABLE `m_estado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `m_evento`
--
ALTER TABLE `m_evento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `m_insumos`
--
ALTER TABLE `m_insumos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCategoriaInsumo` (`idCategoriaInsumo`),
  ADD KEY `idBodega` (`idBodega`),
  ADD KEY `idMarca` (`idMarca`),
  ADD KEY `idUnidadMedida` (`idUnidadMedida`);

--
-- Indices de la tabla `m_marcas`
--
ALTER TABLE `m_marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `m_movimientos`
--
ALTER TABLE `m_movimientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `m_recetacabecera`
--
ALTER TABLE `m_recetacabecera`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `m_recetadetalle`
--
ALTER TABLE `m_recetadetalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idRecetaCabecera` (`idRecetaCabecera`);

--
-- Indices de la tabla `m_tipomovimiento`
--
ALTER TABLE `m_tipomovimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `m_tipousuarios`
--
ALTER TABLE `m_tipousuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `m_unidadmedida`
--
ALTER TABLE `m_unidadmedida`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `m_usuarios`
--
ALTER TABLE `m_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idTipoUsuario` (`idTipoUsuario`),
  ADD KEY `idTipoUsuario_2` (`idTipoUsuario`);

--
-- Indices de la tabla `t_alertasinventario`
--
ALTER TABLE `t_alertasinventario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idInsumo` (`idInsumo`),
  ADD KEY `idCategoriaInsumo` (`idCategoriaInsumo`);

--
-- Indices de la tabla `t_cabeceramovimiento`
--
ALTER TABLE `t_cabeceramovimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idTipoMovimiento` (`idTipoMovimiento`),
  ADD KEY `idEstado` (`idEstado`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `t_detallemovimiento`
--
ALTER TABLE `t_detallemovimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCabecera` (`idCabecera`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `t_registraevento`
--
ALTER TABLE `t_registraevento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEvento` (`idEvento`);

--
-- Indices de la tabla `t_registramovimientoventacabecera`
--
ALTER TABLE `t_registramovimientoventacabecera`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idTipoMoviimiento` (`idTipoMoviimiento`),
  ADD KEY `idEstado` (`idEstado`);

--
-- Indices de la tabla `t_registramovimientoventadetalle`
--
ALTER TABLE `t_registramovimientoventadetalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCabecera` (`idCabecera`),
  ADD KEY `IdReceta` (`IdReceta`);

--
-- Indices de la tabla `t_registrapmp`
--
ALTER TABLE `t_registrapmp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idInsumo` (`idInsumo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `m_bodegas`
--
ALTER TABLE `m_bodegas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `m_categoriainsumos`
--
ALTER TABLE `m_categoriainsumos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `m_estado`
--
ALTER TABLE `m_estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `m_evento`
--
ALTER TABLE `m_evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `m_insumos`
--
ALTER TABLE `m_insumos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `m_marcas`
--
ALTER TABLE `m_marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `m_movimientos`
--
ALTER TABLE `m_movimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `m_recetacabecera`
--
ALTER TABLE `m_recetacabecera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `m_recetadetalle`
--
ALTER TABLE `m_recetadetalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `m_tipomovimiento`
--
ALTER TABLE `m_tipomovimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `m_tipousuarios`
--
ALTER TABLE `m_tipousuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `m_unidadmedida`
--
ALTER TABLE `m_unidadmedida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `m_usuarios`
--
ALTER TABLE `m_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `t_alertasinventario`
--
ALTER TABLE `t_alertasinventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `t_cabeceramovimiento`
--
ALTER TABLE `t_cabeceramovimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `t_detallemovimiento`
--
ALTER TABLE `t_detallemovimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `t_registraevento`
--
ALTER TABLE `t_registraevento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `t_registramovimientoventacabecera`
--
ALTER TABLE `t_registramovimientoventacabecera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `t_registramovimientoventadetalle`
--
ALTER TABLE `t_registramovimientoventadetalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `t_registrapmp`
--
ALTER TABLE `t_registrapmp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `m_insumos`
--
ALTER TABLE `m_insumos`
  ADD CONSTRAINT `m_insumos_ibfk_1` FOREIGN KEY (`idCategoriaInsumo`) REFERENCES `m_categoriainsumos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_insumos_ibfk_3` FOREIGN KEY (`idBodega`) REFERENCES `m_bodegas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_insumos_ibfk_4` FOREIGN KEY (`idUnidadMedida`) REFERENCES `m_unidadmedida` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `m_recetadetalle`
--
ALTER TABLE `m_recetadetalle`
  ADD CONSTRAINT `m_recetadetalle_ibfk_1` FOREIGN KEY (`idRecetaCabecera`) REFERENCES `m_recetacabecera` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `m_usuarios`
--
ALTER TABLE `m_usuarios`
  ADD CONSTRAINT `m_usuarios_ibfk_1` FOREIGN KEY (`idTipoUsuario`) REFERENCES `m_tipousuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `t_alertasinventario`
--
ALTER TABLE `t_alertasinventario`
  ADD CONSTRAINT `t_alertasinventario_ibfk_1` FOREIGN KEY (`idInsumo`) REFERENCES `m_insumos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_alertasinventario_ibfk_2` FOREIGN KEY (`idCategoriaInsumo`) REFERENCES `m_categoriainsumos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `t_cabeceramovimiento`
--
ALTER TABLE `t_cabeceramovimiento`
  ADD CONSTRAINT `t_cabeceramovimiento_ibfk_1` FOREIGN KEY (`idTipoMovimiento`) REFERENCES `m_tipomovimiento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_cabeceramovimiento_ibfk_2` FOREIGN KEY (`idEstado`) REFERENCES `m_estado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `t_detallemovimiento`
--
ALTER TABLE `t_detallemovimiento`
  ADD CONSTRAINT `t_detallemovimiento_ibfk_1` FOREIGN KEY (`idCabecera`) REFERENCES `t_cabeceramovimiento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_detallemovimiento_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `m_insumos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `t_registraevento`
--
ALTER TABLE `t_registraevento`
  ADD CONSTRAINT `t_registraevento_ibfk_1` FOREIGN KEY (`idEvento`) REFERENCES `m_evento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `t_registramovimientoventacabecera`
--
ALTER TABLE `t_registramovimientoventacabecera`
  ADD CONSTRAINT `t_registramovimientoventacabecera_ibfk_1` FOREIGN KEY (`idTipoMoviimiento`) REFERENCES `m_movimientos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `t_registramovimientoventadetalle`
--
ALTER TABLE `t_registramovimientoventadetalle`
  ADD CONSTRAINT `t_registramovimientoventadetalle_ibfk_1` FOREIGN KEY (`idCabecera`) REFERENCES `t_registramovimientoventacabecera` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `t_registrapmp`
--
ALTER TABLE `t_registrapmp`
  ADD CONSTRAINT `t_registrapmp_ibfk_1` FOREIGN KEY (`idInsumo`) REFERENCES `m_insumos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
