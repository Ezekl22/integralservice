<!DOCTYPE html>
<html>
<script>screenCenter("contenedor");</script>
<head>
    <title>Usuarios</title>
</head>

<body>
    <main class="main__flex mb-5">
        <article class="mt-4">
            <h2 class="main__title">
                Crear Usuario
            </h2>
        </article>
        <article class="mt-5 d-flex flex-column align-items-center">
            <div class="grilla w-75 d-flex flex-column align-items-center rounded-4">
                <form action="index.php?module=usuarios&action=created" method="POST"
                    class="w-100 d-flex align-items-center flex-column">
                    <div class="border w-75 mt-5 mb-2 rounded-4 d-flex flex-column align-items-center" id="contenedor">
                        <div class="w-75 d-flex mt-3">
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Nombre</span>
                                <input type="text" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="nombre" name="nombre" required>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Apellido</span>
                                <input type="text" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="apellido" name="apellido" required>
                            </div>
                        </div>
                        <div class="w-50 d-flex mt-3">
                            <div class="input-group input-group-sm mb-3">
                                <label class="input-group-text" for="tipo">Tipo</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="Administrador" selected>Administrador</option>
                                    <option value="Vendedor">Vendedor</option>
                                    <option value="Reparador">Reparador</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-75 d-flex mt-3">
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Mail</span>
                                <input type="text" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="mail" name="mail" required>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Contraseña</span>
                                <input type="password" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="contrasena" name="contrasena" required>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-evenly w-75">
                        <input class="my-5 btn button w-25" type="submit" value="Guardar">
                        <a class="my-5 btn button w-25" type="button" href="index.php?module=usuarios">Cancelar</a>
                    </div>

                </form>
            </div>
        </article>
    </main>
</body>

</html>