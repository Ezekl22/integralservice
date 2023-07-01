// ----------------------------PANTALLA-USUARIOS-----------------------
let MOPantallaEditar = false;

const guardarEdicion = (id) =>{
    //window.location.href = "./index.php?module=usuarios";
    document.getElementById(id).style.display ="none";
}

const mostrarOcultarPantallaEditar = (id) =>{
    const main = document.getElementById(id);
    if(MOPantallaEditar){
        main.style.display = "none";
        MOPantallaEditar = false;
    }else{
        main.style.display ="flex";
        MOPantallaEditar = true;
    }
        
}