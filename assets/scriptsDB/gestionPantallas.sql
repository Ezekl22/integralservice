DROP TABLE IF EXISTS gestionpantallas;

CREATE TABLE `gestionpantallas` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `action` text NOT NULL,
  `inuse` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `gestionpantallas` (`id`, `name`, `action`, `inuse`) VALUES
(1, 'usuarios', 'editar', false),
(2, 'clientes', 'editar', false),
(3, 'proveedores', 'editar', false),
(4, 'presupuestos', 'editar', false),
(5, 'pedidosCompra', 'editar', false),
(6, 'productos', 'editar', false),
(7, 'reparaciones', 'editar', false);

ALTER TABLE `gestionpantallas`
ADD PRIMARY KEY (`id`);

ALTER TABLE `gestionpantallas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;