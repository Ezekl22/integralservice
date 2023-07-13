
DROP TABLE IF EXISTS productos;

CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `marca` text NOT NULL,
  `detalle` text NOT NULL,
  `stock` int(11) NOT NULL,
  `tipo` text NOT NULL,
  `preciocompra` double NOT NULL,
  `precioventa` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `productos` (`idproducto`, `nombre`, `marca`, `detalle`, `stock`, `tipo`, `preciocompra`, `precioventa`) VALUES
(1, 'Impresora Multifuncional Smart Tank 520', 'HP', 'Impresión, copia y escaneado', 10, 'producto', 40000, 70000),
(2, 'Impresora Monofunción Wifi Ecotank', 'Epson', 'Impresión, copia, escaneado y wifi', 20, 'producto', 75000, 100000),
(3, 'Cabezal Ink Tank', 'Hp', ' modelo 315 415 Gt5820 M0h50a M0h51a', 5, 'repuesto',30000,35000);

ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`);


ALTER TABLE `productos`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT;