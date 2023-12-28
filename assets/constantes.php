<?php 
define('DATOS_CARDS',array(
    [
        "Presupuestos" => "En esta pantalla se pueden ver los presupuestos de reparaciones o ventas.
        Solo pueden acceder los usuarios de tipo vendedor o administrador."
    ],
    [
        "Pedidos de compra" => "En esta pantalla se pueden ver los pedidos de compra.
        Solo pueden acceder los usuarios de tipo vendedor o administrador."
    ],
    [
        "Reparaciones" => "En esta pantalla se pueden ver las reparaciones.
        Solo pueden acceder los usuarios de tipo reparador o administrador."
    ],
    [
        "Productos" => "En esta pantalla se pueden ver los productos.
        Solo pueden acceder los usuarios de tipo vendedor o administrador."
    ],
    [
        "Usuarios" => "En esta pantalla se pueden ver los usuarios.
        Solo pueden acceder los usuarios de tipo administrador."
    ],
    [
        "Clientes" => "En esta pantalla se pueden ver los clientes.
        Solo pueden acceder los usuarios de tipo vendedor o administrador."
    ],
    [
        "Proveedores" => "En esta pantalla se pueden ver los proveedores.
        Solo pueden acceder los usuarios de tipo vendedor o administrador."
    ]
    ));

define('GRILLA_USUARIOS',array("Nombre","Apellido","Tipo","Mail"));

// Datos del popup de inicio de sesion
$inicioSesionCuerpoP = '<input id="mail" type="text" class="mb-4 mx-5 form-control w-75" name="mail" placeholder="Mail" required>
                        <input type="text" id="contrasena"  name="contrasena" class="mx-5 form-control w-75" placeholder="Contraseña" required>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-link btn__recuperarC" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#recuperarCon">
                                    Recuperar contraseña
                            </button>
                        </div>';

$InicioSesionBotonesP = array(["texto" => "Cancelar","tipo" => "button","href" => ""],["texto" => "Ingresar","tipo" => "submit","href" => ""]);

// Datos del popup de recuperar contraseña
$recuperarContrasenaCuerpoP = '<form action="index.php?action=login" method="POST" class=" d-flex flex-column align-items-center">
                                    <div class="d-flex mb-4 mx-5">Ingrese su correo electrónico y recibirá un código de verificación.</div>
                                    <input type="text" class="mb-4 mx-5 form-control w-75" placeholder="mail" required>
                                </form>';

$recuperarContrasenaBotonesP = array(["texto" => "cancelar","tipo" => "button","href" => ""],["texto" => "Enviar","tipo" => "submit","href" => ""]);

// Datos del popup de inicio de ingresar codigo
$ingresarCodigoCuerpoP = '<div class="d-flex mb-4 mx-5">Ingrese el codigo que se envio a su correo.</div>
                          <input type="text" class="mx-5 mb-4" placeholder="Código" required>';

$ingresarCodigoBotonesP = array(["texto" => "cancelar","tipo" => "button","href" => ""],["texto" => "Verificar","tipo" => "submit","href" => ""]);

// Datos del popup de inicio de ingresar codigo
$cambiarContrasenaCuerpoP = '<form action="index.php?action=login" method="POST" class=" d-flex flex-column align-items-center">
                                <div class="d-flex mb-4 mx-5">Ingrese la nueva contraseña.</div>
                                <input type="text" class="mx-5 mb-4" placeholder="Nueva contraseña" required>
                                <input type="text" class="mx-5 mb-4" placeholder="Repita la contraseña" required>
                            </form>';

$cambiarContrasenaBotonesP = array(["texto" => "cancelar","tipo" => "button","href" => ""],["texto" => "Guardar","tipo" => "submit","href" => ""]);

?>

