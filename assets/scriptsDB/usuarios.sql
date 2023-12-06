DROP TABLE IF EXISTS users;
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
(1, 'Pedro1', 'Pintoss', 'Administrador', 'Pedro22@gmail.com', '123'),
(2, 'ADMINISTRADOR', 'ADMIN', 'ADMINISTRADOR', 'ADMINISTRADOR@gmail.com', '123'),
(3, 'Alberto', 'Centurion', 'REPARADOR', 'Alberto22@gmail.com', '123');

ALTER TABLE `usuarios`
ADD PRIMARY KEY (`idusuario`);

ALTER TABLE `usuarios`
MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
