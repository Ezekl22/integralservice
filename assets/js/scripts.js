// ----------------------------PANTALLA-USUARIOS-----------------------
let MOPantallaEditar = false;

const guardarEdicion = (id) =>{
    //window.location.href = "./index.php?module=usuarios";
    document.getElementById(id).style.display ="none";
}
//verifico si la pantalla de editar esta a la vista y si lo esta le cambio el display para ocultarla
const mostrarOcultarPantallaEditar = (id,inUse) =>{
    document.getElementById(id).style.display = inUse ? "none" : "flex";
}