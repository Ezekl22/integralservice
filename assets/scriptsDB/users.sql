
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `lastname` text NOT NULL,
  `type` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `name`, `lastname`, `type`, `username`, `password`) VALUES
(1, 'Pedro1', 'Pintoss', 'Administrador', 'Pedro22', '123'),
(2, 'ADMINISTRADOR', 'ADMIN', 'ADMINISTRADOR', 'ADMINISTRADOR', '123'),
(3, 'Alberto', 'Centurion', 'REPARADOR', 'Alberto22', '123');

ALTER TABLE `users`
ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
