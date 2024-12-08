


function mostrarToast(tipo,texto = "",descripcionError = "") {

  btnVerMas = descripcionError == "" ? "":` <br> <div id="ver-mas" class="w-100 d-flex justify-content-center"><a href="#">Ver mas</a></div>`;
 
  switch (tipo) {
      case "exito":
          icono = "success";
          timer = 3000;
          botonCerrar = false;
          break;
  
      default:
          icono = "error";
          timer = 0;
          botonCerrar = true;
          texto = texto + btnVerMas;
          break;
  }
    
  const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      customClass: {
        popup: 'colored-toast',
        confirmButton: "btn btn-link btn-see-more",
        closeButton: "btn-position"
      },
      showConfirmButton: false,
      timer: timer,
      timerProgressBar: false,
      showCloseButton: botonCerrar,
    })
  
  Toast.fire({
      icon: icono,
      html: texto,
      didOpen: () => {
        const verMasBtn = document.getElementById("ver-mas");
        verMasBtn.addEventListener("click", () => {
            Swal.fire({
                title: "Detalle del error",
                html: descripcionError,
                icon: 'error', // Cambia según el tipo de mensaje
                confirmButtonText: "Cerrar"
            });
        });
    } 
  });
}