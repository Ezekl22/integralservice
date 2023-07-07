<!DOCTYPE html>
<html>
<head>
    <title>Usuarios</title>
</head>
<body>
    <main class="main__flex">
        <article class="mt-4">
                <h2 class="main__title">
                    Crear Usuario
                </h2>
        </article>
        <article class="mt-5 d-flex flex-column align-items-center">
            <div class="grilla w-75 d-flex flex-column align-items-center rounded-4">
                <form action="" method="POST" class="w-100 d-flex align-items-center flex-column">
                    <div class="border w-75 mt-5 mb-2 rounded-4 d-flex flex-column align-items-center">
                        <div class="w-75 d-flex mt-3">
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Nombre</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Apellido</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>
                        <div class="w-50 d-flex mt-3">
                            <div class="input-group input-group-sm mb-3">
                                <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                <select class="form-select" id="inputGroupSelect01">
                                    <option selected>Administrador</option>
                                    <option value="1">Vendedor</option>
                                    <option value="2">Reparador</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-75 d-flex mt-3">
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Nombre de usuario</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Contraseña</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-evenly w-75">
                        <a class="my-5 btn button w-25" type="button" href="index.php?module=usuarios&action=create">Guardar</a>
                        <a class="my-5 btn button w-25" type="button" href="index.php?module=usuarios&action=create">Cancelar</a>
                    </div>
                    
                </form> 
            </div>
        </article>
    </main>
</body>
</html>


