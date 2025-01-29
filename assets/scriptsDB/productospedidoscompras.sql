DROP TABLE IF EXISTS productospedidoscompras;

CREATE TABLE `productospedidoscompras` (
  `idproductopedidocompra` int(11) NOT NULL,
  `idpedidocompra` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `preciounit` DECIMAL(20, 2) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `productospedidoscompras` (`idproductopedidocompra`, `idpedidocompra`, `idproducto`, `preciounit`, `cantidad`) VALUES
(1, 2, 1, 30000, 2),
(2, 1, 2, 25000, 1),
(3, 1, 1, 30000, 2),
(4, 3, 3, 70000, 1);

ALTER TABLE `productospedidoscompras`
  ADD PRIMARY KEY (`idproductopedidocompra`),
  ADD KEY `idpedidocompra` (`idpedidocompra`),
  ADD KEY `idproducto` (`idproducto`);

ALTER TABLE `productospedidoscompras`
  MODIFY `idproductopedidocompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;