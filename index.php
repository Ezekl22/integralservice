<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Casa de Impresoras</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="./assets/js/scripts.js"></script>
</head>
<body>
    <!-- Obtener el módulo actual -->
    <?php 
    include './controladores/GestionPantallasControlador.php';
    $module = isset($_GET['module']) ? $_GET['module'] : ''; 
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    ?>

    <nav class="navbar navbar-expand-lg nav__background">
        <div class="container-fluid">
              <a class="navbar-brand" href="#">
                    <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo" alt="logo de integral Service">
                    Integral Service
              </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse d-flex justify-content-end me-5" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                          <a type="button" class="btn button" <?php if($module!=''){echo 'href="index.php"';}else{echo 'data-bs-target="#inicioSesion" data-bs-toggle="modal"';}?>>
                                <?php if($module!=''){echo "Cerrar sesión";} else{echo "Iniciar sesión";} ?>
                          </a>
                    </ul>
              </div>
        </div>
    </nav>
    <main>
        <section>
            
        </section>
        <div class="modal fade" id="inicioSesion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                    <div class="modal-content">
                          <div class="modal-header headerPop__background">
                                <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo" alt="logo de integral Service">
                                <h2 class="modal-title fs-5" id="exampleModalLabel">Inicio de sesion</h2>
                                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body d-flex flex-column">
                                <input type="text" class="mb-4 mx-5" placeholder="usuario">
                                <input type="text" class="mx-5"placeholder="contraseña">
                                <div class="d-flex justify-content-center">
                                      <button type="button" class="btn btn-link btn__recuperarC" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#recuperarCon">
                                            recuperar contraseña
                                      </button>
                                </div>
                          </div>
                          <div class="modal-footer d-flex justify-content-center headerPop__background">
                                <button type="button" class="btn button me-5" data-bs-dismiss="modal">Cancelar</button>
                                <a aria-label="Close" class="btn button " href="index.php?module=menu">Ingresar</a>
                          </div>
                    </div>
              </div>
        </div>
        <div class="modal fade" id="inicioSesion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                    <div class="modal-content">
                          <div class="modal-header headerPop__background">
                                <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo" alt="logo de integral Service">
                                <h2 class="modal-title fs-5" id="exampleModalLabel">Inicio de sesion</h2>
                                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body d-flex flex-column">
                                <input type="text" class="mb-4 mx-5" placeholder="usuario">
                                <input type="text" class="mx-5"placeholder="contraseña">
                                <div class="d-flex justify-content-center">
                                      <button type="button" class="btn btn-link btn__recuperarC" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#recuperarCon">
                                            recuperar contraseña
                                      </button>
                                </div>
                          </div>
                          <div class="modal-footer d-flex justify-content-center headerPop__background">
                                <button type="button" class="btn button me-5" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" onclick="cargarMenu()" data-bs-dismiss="modal" aria-label="Close" class="btn button ">Ingresar</button>
                          </div>
                    </div>
              </div>
        </div>
        <div class="modal fade" id="recuperarCon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                    <div class="modal-content">
                          <div class="modal-header headerPop__background">
                                <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo" alt="logo de integral Service">
                                <h2 class="modal-title fs-5" id="exampleModalLabel">Recuperar contraseña</h2>
                                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body d-flex flex-column">
                                <div class="d-flex mb-4 mx-5">ingrese su correo electronico y recibira un codigo de verificacion.</div>
                                <input type="text" class="mx-5 mb-4" placeholder="Email">
                          </div>
                          <div class="modal-footer d-flex justify-content-center headerPop__background"> 
                                <button type="button" class="btn me-5 button" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn button" data-bs-toggle="modal" data-bs-target="#ingCodigo">
                                      Enviar
                                </button>
                          </div>
                    </div>
              </div>
        </div>
        <div class="modal fade" id="ingCodigo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                    <div class="modal-content">
                          <div class="modal-header headerPop__background">
                                <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo" alt="logo de integral Service">
                                <h2 class="modal-title fs-5" id="exampleModalLabel">Recuperar contraseña</h2>
                                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body d-flex flex-column">
                                <div class="d-flex mb-4 mx-5">Ingrese el codigo que se envio a su correo.</div>
                                <input type="text" class="mx-5 mb-4" placeholder="Código">
                          </div>
                          <div class="modal-footer d-flex justify-content-center headerPop__background"> 
                                <button type="button" class="btn me-5 button" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn button" data-bs-toggle="modal" data-bs-target="#nuevaCont">
                                      Verificar
                                </button>
                          </div>
                    </div>
              </div>
        </div>
        <div class="modal fade" id="nuevaCont" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                    <div class="modal-content">
                          <div class="modal-header headerPop__background">
                                <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo" alt="logo de integral Service">
                                <h2 class="modal-title fs-5" id="exampleModalLabel">Recuperar contraseña</h2>
                                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body d-flex flex-column">
                                <div class="d-flex mb-4 mx-5">Ingrese la nueva contraseña.</div>
                                <input type="text" class="mx-5 mb-4" placeholder="Nueva contraseña">
                                <input type="text" class="mx-5 mb-4" placeholder="Repita la contraseña">
                          </div>
                          <div class="modal-footer d-flex justify-content-center headerPop__background"> 
                                <button type="button" class="btn me-5 button" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn button" data-bs-toggle="modal" data-bs-target="#inicioSesion">
                                      Guardar
                                </button>
                          </div>
                    </div>
              </div>
        </div>
    </main>

    <?php
    switch ($module) {
        case 'presupuestos':
            include('./controladores/PresupuestoCtr.php');
            $indexPage = new PresupuestoCtr();
            break;
        case 'reparacion':
            include('controladores/ReparacionControlador.php');
            break;
        case 'clientes':
            include('controladores/ClienteControlador.php');
            break;
        case 'proveedores':
            include('controladores/ProveedorControlador.php');
            $indexPage = new SupplierController();
            switch ($action) {
                  case 'edit':
                        $indexPage ->getPantallaEdit();
                        break;
                  case 'delete':
                        $indexPage ->getPantallaDelete();
                        break;
                  case 'create':
                        $indexPage ->getPantallaCreate();
                        break;
                  default:
                        $indexPage -> index();
                        break;
            }
            break;
      case 'pedidos':
            include('controladores/PedidoCompraControlador.php');
            break;
        case 'usuarios':
            include './controladores/UsuarioControlador.php';
            $indexPage = new UserController();
            break;
        case 'menu':
            include './controladores/MenuControlador.php';
            $indexPage = new MenuController();
            $indexPage -> index();
            break;
        default:
          include './vistas/inicio/index.php';
            break;
    }
    if($module){
      switch ($action) {
            case 'edit':
                  $indexPage ->getPantallaEdit();
                  break;
            case 'delete':
                  $indexPage ->getPantallaDelete();
                  break;
            case 'create':
                  $indexPage ->getPantallaCreate();
                  break;
            default:
                  $indexPage -> index();
                  break;
      }
    }
    ?>

  <footer class="d-flex justify-content-end main__footer footer__index">
        <div class="text-end me-5 p-4">
              Creado por:  Matias Premat y Ezequiel Centurion
        </div>
  </footer>

</body>
</html>
