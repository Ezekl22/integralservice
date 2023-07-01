// ----------------------------PANTALLA-USUARIOS-----------------------
const guardarEdicion = (id) =>{
    //window.location.href = "./index.php?module=usuarios";
    document.getElementById(id).style.display ="none";
}

const mostrarpantallaEditar = (id) =>{
    const main = document.getElementById(id);
    if(main.style.display == "none")
        main.style.display ="flex";
}