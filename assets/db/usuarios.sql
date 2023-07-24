DROP TABLE IF EXISTS `usuarios`;

SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `tipo` text NOT NULL,
  `nombre` text DEFAULT NULL,
  `apellido` text DEFAULT NULL,
  `nombreusuario` text DEFAULT NULL,
  `contrasenia` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `nombreusuario`, `tipo`, `contrasenia`) VALUES
(1, 'Administrador', 'Admin', 'admin@hotmail.com', 'administrador', '123');

ALTER TABLE `usuarios`
ADD PRIMARY KEY (`id`),
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;