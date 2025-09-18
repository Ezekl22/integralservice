
DROP TABLE IF EXISTS productos;

CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `marca` text NOT NULL,
  `detalle` text NOT NULL,
  `stock` int(11) NOT NULL,
  `tipo` text NOT NULL,
  `preciocompra` DECIMAL(20, 2) NOT NULL,
  `precioventa` DECIMAL(20, 2) NOT NULL,
  `estado` text NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `productos` (`idproducto`, `nombre`, `marca`, `detalle`, `stock`, `tipo`, `preciocompra`, `precioventa`,`estado`) VALUES
(0, 'mano de obra', 'mano de obra', 'representa la mano de obra del tecnico', 10, 'mano de obra', 0, 0, 'habilitado'),
(1, 'Impresora Multifuncional Smart Tank 520', 'HP', 'Impresión, copia y escaneado', 10, 'producto', 40000, 70000, 'habilitado'),
(2, 'Impresora Monofunción Wifi Ecotank', 'Epson', 'Impresión, copia, escaneado y wifi', 20, 'producto', 75000, 100000, 'habilitado'),
(3, 'Cabezal Ink Tank', 'Hp', ' modelo 315 415 Gt5820 M0h50a M0h51a', 5, 'repuesto', 30000, 35000, 'habilitado');

ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`);


ALTER TABLE `productos`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;