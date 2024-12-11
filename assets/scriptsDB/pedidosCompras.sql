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
  ADD UNIQUE KEY `idproveedor` (`idproveedor`);

ALTER TABLE `pedidoscompras`
  MODIFY `idpedidocompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

