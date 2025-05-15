<!-- index.php -->
<!DOCTYPE html>
<html>

<head>
      <meta charset="UTF-8">
      <title>Casa de Impresoras</title>
      <link rel="stylesheet" type="text/css" href="assets/css/style.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
            crossorigin="anonymous"></script>
      <script src="./assets/js/scripts.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="./assets/js/toast.js"></script>

</head>

<body>
      <!-- Obtener el módulo actual -->
      <?php
      require_once './controladores/gestionPantallasControlador.php';
      require_once './assets/constantes.php';
      $GestionPantallaCtr = new GestionPantallasControlador;
      session_start();
      $sesionCtr = isset($_SESSION['session']) ? $_SESSION['session'] : "";
      session_write_close();
      ?>

      <nav class="navbar navbar-expand-lg nav__background">
            <div class="container-fluid">
                  <a class="navbar-brand" href=<?php echo $GestionPantallaCtr->getModule() && $sesionCtr != '' ? "index.php?module=menu" : "#" ?>>
                        <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo"
                              alt="logo de integral Service">
                        Integral Service
                  </a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse d-flex justify-content-end me-5" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                              <a type="button" class="btn button" <?php if ($GestionPantallaCtr->getModule() != '') {
                                    echo 'href="index.php?action=logout"';
                              } else {
                                    echo 'data-bs-target="#inicioSesion" data-bs-toggle="modal"';
                              } ?>>
                                    <?php if ($GestionPantallaCtr->getModule() != '') {
                                          echo "Cerrar sesión";
                                    } else {
                                          echo "Iniciar sesión";
                                    } ?>
                              </a>
                        </ul>
                  </div>
            </div>
      </nav>
      <main>
            <section>

            </section>
            <?php
            $GestionPantallaCtr->crearPopUp(new PopUpMdl('inicioSesion', 'Inicio de sesión', "", INICIO_SESION_BTN_P, 'index.php?action=login'));
            $GestionPantallaCtr->crearPopUp(new PopUpMdl('recuperarCon', 'Recuperar contraseña', "", $recuperarContrasenaBotonesP));
            $GestionPantallaCtr->crearPopUp(new PopUpMdl('ingCodigo', 'Ingresar código', "", $ingresarCodigoBotonesP));
            $GestionPantallaCtr->crearPopUp(new PopUpMdl('nuevaCont', 'Cambiar contraseña', "", $cambiarContrasenaBotonesP));
            ?>
      </main>
      <?php $GestionPantallaCtr->cargarPantalla(); ?>

      <footer class="d-flex justify-content-end main__footer footer__index">
            <div class="text-end me-5 p-4">
                  Creado por: Matias Premat y Ezequiel Centurion
            </div>
      </footer>

</body>

</html>