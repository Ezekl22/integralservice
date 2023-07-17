
CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `tax_category` text NOT NULL,
  `adress` text NOT NULL,
  `phone` int NOT NULL,
  `mail` text NOT NULL,
  `balance` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `suppliers` (`id`, `name`, `tax_category`, `adress`, `phone`, `mail`, `balance`) VALUES
(1, 'Pepe', 'Monotributista', 'Irigoyen 1500', '3454021000', 'pepe@gmail.com', '500'),
(2, 'Pepa', 'Responsable Inscripto', 'Urquiza 350', '3454085050', 'pepa@yahoo.com', '-340'),
(3, 'Juan', 'Monotributista', 'Urdinarrain 1100', '3454200123', 'juan@hotmail.com', '10');

ALTER TABLE `suppliers`
ADD PRIMARY KEY (`id`);

ALTER TABLE `suppliers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
