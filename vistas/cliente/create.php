<!DOCTYPE html>
<html>

<head>
    <title>Clientes</title>
</head>

<body>
    <main class="main__flex mb-5">
        <article class="mt-4">
            <h2 class="main__title">
                Crear Cliente
            </h2>
        </article>
        <article class="mt-5 d-flex flex-column align-items-center">
            <div class="grilla w-75 d-flex flex-column align-items-center rounded-4">
                <form action="index.php?module=clientes&action=created" method="POST"
                    class="w-100 d-flex align-items-center flex-column">
                    <div class="border w-75 mt-5 mb-2 rounded-4 d-flex flex-column align-items-center">
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
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Email</span>
                                <input type="email" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="w-75 d-flex mt-3">
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Cuit</span>
                                <input type="text" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="cuit" name="cuit" required>
                            </div>
                            <div class="input-group input-group-sm mb-3 ms-4">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Categoria Fiscal</span>
                                <input type="text" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="categoriafiscal" name="categoriafiscal"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-evenly w-75">
                        <input class="my-5 btn button w-25" type="submit" value="Guardar">
                        <a class="my-5 btn button w-25" type="button" href="index.php?module=clientes">Cancelar</a>
                    </div>
                </form>
            </div>
        </article>
    </main>
</body>

</html>