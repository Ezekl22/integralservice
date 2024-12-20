DROP DATABASE IF EXISTS integralservice;

CREATE DATABASE integralservice;

USE integralservice;

--tabla usuarios

DROP TABLE IF EXISTS usuarios;
CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `apellido` text NOT NULL,
  `tipo` text NOT NULL,
  `mail` text NOT NULL,
  `contrasena` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`idusuario`, `nombre`, `apellido`, `tipo`, `mail`, `contrasena`) VALUES

(1, 'Pedro1', 'Pintoss', 'Reparador', 'Pedro22@gmail.com', '123'),
(2, 'ADMINISTRADOR BASE', 'ADMIN', 'Administrador base', 'ADMINISTRADOR@gmail.com', '123'),
(3, 'Alberto', 'Centurion', 'Vendedor', 'Alberto22@gmail.com', '123');

ALTER TABLE `usuarios`
ADD PRIMARY KEY (`idusuario`);

ALTER TABLE `usuarios`
MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--tabla clientes

DROP TABLE IF EXISTS clientes;

CREATE TABLE `clientes` (
  `idcliente` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `apellido` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `cuit` text DEFAULT NULL,
  `categoriafiscal` text DEFAULT NULL,
  `fechaCreacion` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `clientes` (`idcliente`, `nombre`, `apellido`, `email`, `cuit`,`categoriafiscal`, `fechaCreacion`) VALUES
(1, 'Carlos', 'Argento', 'carlosA@gmail.com', '20-37432645-6','Consumidor final', current_timestamp()),
(2, 'Daiana', 'Romero', 'Dai34@gmail.com', '27-32568790-2', 'Responsable inscripto',current_timestamp()),
(3, 'Alberto', 'Centurion', 'alberto@gmail.com', '23-27587104-6','Monotributista', current_timestamp());

ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcliente`);

ALTER TABLE `clientes`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- tabla presupuestos


DROP TABLE IF EXISTS presupuestos;

CREATE TABLE `presupuestos` (
  `idpresupuesto` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `nrocomprobante` text NOT NULL,
  `tipo` text NOT NULL,
  `estado` text NOT NULL,
  `fecha` text NOT NULL,
  `puntoventa` text NOT NULL,
  `total` DECIMAL(20, 2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `presupuestos` (`idpresupuesto`, `idcliente`,`nrocomprobante`, `tipo`, `estado`, `fecha`,`puntoventa`,`total`) VALUES
(1, 2, '013456789', 'Venta', 'Presupuestado', '05-02-2023', '0001', 140000),
(2, 1, '098735610', 'Venta', 'pendiente presupuesto', '09-05-2023','0001', 100000),
(3, 1, '312751963', 'Reparacion', 'Reparado', '08-06-2023', '0001', 50000);

ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`idpresupuesto`),
  ADD KEY `idcliente` (`idcliente`);


ALTER TABLE `presupuestos`
  MODIFY `idpresupuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4 ;

ALTER TABLE `presupuestos`
  ADD CONSTRAINT `presupuestos_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--tabla pedidos de compra

DROP TABLE IF EXISTS pedidoscompras;

CREATE TABLE `pedidoscompras` (
  `idpedidocompra` int(11) NOT NULL,
  `nrocomprobante` text NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `estado` text NOT NULL,
  `total` DECIMAL(20, 2) NOT NULL,
  `fecha` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `pedidoscompras` (`idpedidocompra`, `nrocomprobante`, `idproveedor`,`estado`, `total`,`fecha`) VALUES
(1, 'B-013456789', 2, 'Pedido', 140000, '05-02-2023'),
(2, 'B-098735610', 1,'Entregado', 100000, '03-06-2023'),
(3, 'B-312751963', 3, 'Cancelado', 50000, '08-06-2023');

ALTER TABLE `pedidoscompras`
  ADD PRIMARY KEY (`idpedidocompra`),
  ADD KEY `idproveedor` (`idproveedor`);

ALTER TABLE `pedidoscompras`
  MODIFY `idpedidocompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--tabla productos


DROP TABLE IF EXISTS productos;

CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `marca` text NOT NULL,
  `detalle` text NOT NULL,
  `stock` int(11) NOT NULL,
  `tipo` text NOT NULL,
  `preciocompra` DECIMAL(20, 2) NOT NULL,
  `precioventa` DECIMAL(20, 2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `productos` (`idproducto`, `nombre`, `marca`, `detalle`, `stock`, `tipo`, `preciocompra`, `precioventa`) VALUES
(1, 'Impresora Multifuncional Smart Tank 520', 'HP', 'Impresión, copia y escaneado', 10, 'producto', 40000, 70000),
(2, 'Impresora Monofunción Wifi Ecotank', 'Epson', 'Impresión, copia, escaneado y wifi', 20, 'producto', 75000, 100000),
(3, 'Cabezal Ink Tank', 'Hp', ' modelo 315 415 Gt5820 M0h50a M0h51a', 5, 'repuesto',30000,35000);

ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`);


ALTER TABLE `productos`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--tabla reparaciones

DROP TABLE IF EXISTS reparaciones;
CREATE TABLE `reparaciones` (
  `idreparacion` int(11) NOT NULL,
  `idpresupuesto` int(11) NOT NULL,
  `modelo` text NOT NULL,
  `marca` text NOT NULL,
  `numeroserie` text NOT NULL,
  `descripcion` text NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `reparaciones`
  ADD PRIMARY KEY (`idreparacion`),
  ADD KEY `idpresupuesto` (`idpresupuesto`);

ALTER TABLE `reparaciones`
  MODIFY `idreparacion` int(11) NOT NULL AUTO_INCREMENT;

--tabla proveedores

DROP TABLE IF EXISTS proveedores;

CREATE TABLE `proveedores` (
  `idproveedor` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `categoria_fiscal` text DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `telefono` text DEFAULT NULL,
  `correo` text DEFAULT NULL,
  `cuit` text DEFAULT NULL,
  `saldo` DECIMAL(20, 2) DEFAULT NULL,
  `fechaCreacion` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `proveedores` (`idproveedor`, `nombre`, `categoria_fiscal`, `direccion`, `telefono`, `correo`, `cuit`, `saldo`, `fechaCreacion`) VALUES
(1, 'Carlos', 'Monotributista', 'Urquiza 99', '3451234567', 'carlosA@gmail.com', '22-34885500-4', 0, current_timestamp()),
(2, 'Mariana', 'Responsable Inscripto', 'Pellegrini 99', '3457654321', 'mariana@gmail.com', '20-38449281-6', 11000, current_timestamp()),
(3, 'Carlos', 'Monotributista', 'Urquiza 99', '3451234567', 'carlosA@gmail.com', '27-32568790-2', 850, current_timestamp());

ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idproveedor`);

ALTER TABLE `proveedores`
  MODIFY `idproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--tabla productos-pedidos

DROP TABLE IF EXISTS productospedidoscompras;

CREATE TABLE `productospedidoscompras` (
  `idproductopedidocompra` int(11) NOT NULL,
  `idpedidocompra` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `preciounit` DECIMAL(20, 2) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `productospedidoscompras` (`idproductopedidocompra`, `idpedidocompra`, `idproducto`, `preciounit`, `cantidad`) VALUES
(1, 2, 1, 40000, 2),
(2, 1, 2, 75000, 1),
(3, 1, 1, 40000, 2),
(4, 3, 3, 30000, 1);

ALTER TABLE `productospedidoscompras`
  ADD PRIMARY KEY (`idproductopedidocompra`),
  ADD KEY `idpedidocompra` (`idpedidocompra`),
  ADD KEY `idproducto` (`idproducto`);

ALTER TABLE `productospedidoscompras`
  MODIFY `idproductopedidocompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--tabla productos-presupuesto

DROP TABLE IF EXISTS productospresupuestos;

CREATE TABLE `productospresupuestos` (
  `idpresupuestoproducto` int(11) NOT NULL,
  `idpresupuesto` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `preciounit` DECIMAL(20, 2) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `productospresupuestos` (`idpresupuestoproducto`, `idpresupuesto`, `idproducto`, `preciounit`, `cantidad`) VALUES
(1, 2, 1, 70000, 2),
(2, 1, 2, 100000, 1),
(3, 1, 1, 70000, 2),
(4, 3, 3, 35000, 1);

ALTER TABLE `productospresupuestos`
  ADD PRIMARY KEY (`idpresupuestoproducto`),
  ADD KEY `idpresupuesto` (`idpresupuesto`),
  ADD KEY `idproducto` (`idproducto`);

ALTER TABLE `productospresupuestos`
  MODIFY `idpresupuestoproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
