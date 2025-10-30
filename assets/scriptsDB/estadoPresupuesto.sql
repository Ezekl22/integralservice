DROP TABLE IF EXISTS estadopresupuesto;
CREATE TABLE `estadopresupuesto` (
  `idestadopresupuesto` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `estadopresupuesto` (`idestadopresupuesto`, `nombre`, `descripcion`) VALUES
(1, 'Pendiente presupuesto', 'sucede cuando una reparacion esta pendiente a presupuestar'),
(2, 'Presupuestado', 'sucede cuando el presupuesto de cualquier tipo esta presupuestado'),
(3, 'Pendiente reparacion', 'sucede cuando un presupuesto de tipo reparacion esta pendiente a reparar'),
(4, 'Reparado', 'sucede cuando un presupuesto de tipo reparacion ya esta reparado'),
(5, 'Facturado', 'sucede cuando un presupuesto de cualquier tipo esta facturado'),
(6, 'Anulado', 'sucede cuando un presupuesto de cualquier tipo se cancela');

ALTER TABLE `estadopresupuesto`
  ADD PRIMARY KEY (`idestadopresupuesto`);

ALTER TABLE `estadopresupuesto`
  MODIFY `idestadopresupuesto` int(11) NOT NULL AUTO_INCREMENT;
