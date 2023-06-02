
const onClickGuardar = () =>{
    const form = document.querySelector("form");
    const contenedor = document.querySelector("#contenedor");
    const contMensaje = document.createElement("div");

    contMensaje.className = "d-flex flex-column align-items-center";
    contMensaje.id ="contMensaje";
    contMensaje.innerHTML =`<h4 class="mt-2 text__white">El usuario se ha editado correctamente </h4>
                            <a type="buttom" href="index.php?module=usuarios" class="btn button my-3">Aceptar</buttom>`;

    contenedor.remove();

    form.appendChild(contMensaje);
}
