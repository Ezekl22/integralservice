<!DOCTYPE html>
<html>
<script>
    screenCenter("contenedor");
</script>

<head>
    <title>Proveedores</title>
</head>

<body>
    <main class="main__flex mb-5">
        <article class="mt-4">
            <h2 class="main__title">
                Crear proveedor
            </h2>
        </article>
        <article class="mt-5 d-flex flex-column align-items-center">
            <div class="grilla w-95 d-flex flex-column align-items-center rounded-4">
                <form action="index.php?module=proveedores&action=created" method="POST"
                    class="w-100 d-flex align-items-center flex-column">
                    <div class="border w-95 mt-5 mb-2 rounded-4 d-flex flex-column align-items-center" id="contenedor">
                        <div class="w-95 d-flex mt-4 mb-3">
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Nombre</span>
                                <input type="text" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="nombre" name="nombre" required>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <label class="input-group-text" for="categoria_fiscal">Categoria Fiscal:</label>
                                <select class="form-select" id="categoria_fiscal" name="categoria_fiscal" required>
                                    <option value="Monotributista">Monotributista</option>
                                    <option value="Responsable inscripto">Responsable inscripto</option>
                                    <option value="Excento">Excento</option>
                                </select>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Direccion</span>
                                <input type="text" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="direccion" name="direccion" required>
                            </div>
                        </div>
                        <div class="w-95 d-flex my-3">
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Telefono</span>
                                <input type="number" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="telefono" name="telefono" required>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Correo</span>
                                <input type="email" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="correo" name="correo" required>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Saldo</span>
                                <input type="number" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="saldo" name="saldo" step="any" required>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Cuit</span>
                                <input type="number" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="cuit" name="cuit" required>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-evenly w-75">
                        <a class="my-5 btn button w-25" type="button" href="index.php?module=proveedores">Cancelar</a>
                        <input class="my-5 btn button w-25" type="submit" value="Guardar">
                    </div>

                </form>
            </div>
        </article>
    </main>
</body>

</html>