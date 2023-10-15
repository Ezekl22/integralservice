DROP TABLE IF EXISTS productospedidoscompras;

CREATE TABLE `productospedidoscompras` (
  `idproductopedidocompra` int(11) NOT NULL,
  `idpedidocompra` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `productospedidoscompras` (`idproductopedidocompra`, `idpedidocompra`, `idproducto`, `cantidad`) VALUES
(1, 2, 1, 2),
(2, 1, 2, 1),
(3, 1, 1, 2),
(4, 3, 3, 1);

ALTER TABLE `productospedidoscompras`
  ADD PRIMARY KEY (`idproductopedidocompra`),
  ADD UNIQUE KEY `idpedidocompra` (`idpedidocompra`,`idproducto`),
  ADD KEY `idproducto` (`idproducto`);

ALTER TABLE `productospedidoscompras`
  MODIFY `idproductopedidocompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `productospedidoscompras`
  ADD CONSTRAINT `productospedidoscompras_ibfk_1` FOREIGN KEY (`idpedidocompra`) REFERENCES `presupuestos` (`idpedidocompra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productospedidoscompras_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE;