


function mostrarToast(tipo,texto = "") {
 
    switch (tipo) {
        case "exito":
            icono = "success";
            titulo = "Exito";
            timer = 3000;
            botonCerrar = false;
            break;
    
        default:
            icono = "error";
            titulo = "Error";
            timer = 0;
            botonCerrar = true;
            break;
    }
    
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        iconColor: 'white',
        customClass: {
          popup: 'colored-toast',
        },
        showConfirmButton: false,
        timer: timer,
        timerProgressBar: false,
        showCloseButton: botonCerrar,
      })
    
    Toast.fire({
        icon: icono,
        title: titulo,
        text:  texto,
        });
}