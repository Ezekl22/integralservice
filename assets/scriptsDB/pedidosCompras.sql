DROP TABLE IF EXISTS pedidoscompras;

CREATE TABLE `pedidoscompras` (
  `idpedidocompra` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `fecha` text NOT NULL,
  `estado` text NOT NULL,
  `total` float NOT NULL,
  `nrocomprobante` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `pedidoscompras` (`idpedidocompra`, `idproveedor`,`fecha`,`estado`, `total`,`nrocomprobante`) VALUES
(1, 2, '05-02-2023', 'Pedido', 140000, 'B-013456789'),
(2, 1, '03-06-2023','Entregado', 100000, 'B-098735610'),
(3, 3, '08-06-2023', 'Cancelado', 50000, 'B-312751963');

ALTER TABLE `pedidoscompras`
  ADD PRIMARY KEY (`idpedidocompra`),
  ADD UNIQUE KEY `idproveedor` (`idproveedor`);

ALTER TABLE `pedidoscompras`
  MODIFY `idpedidocompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

