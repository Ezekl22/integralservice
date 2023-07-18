// ----------------------------PANTALLA-USUARIOS-----------------------
let MOPantallaEditar = false;

const guardarEdicion = (id) =>{
    //window.location.href = "./index.php?module=usuarios";
    document.getElementById(id).style.display ="none";
}
//verifico si la pantalla de editar esta a la vista y si lo esta le cambio el display para ocultarla
const mostrarOcultarPantallaEditar = (id,inUse) =>{
    let contDisplay = document.getElementById(id).style.display;
    document.getElementById(id).style.display = contDisplay == "flex" & inUse == '0' ? "none" : contDisplay == "none" & inUse =='1' && "flex";
}

const agregarComponenteProducto = () =>{
    let contProductos = document.getElementById("contProductos");
    let contComponente = document.createElement("div");
    let numContenedores = contProductos.childElementCount;
    let id = "producto"+(numContenedores+1);
    contComponente.className = "input-group input-group-sm mb-3";
    contComponente.id = id;
    contComponente.innerHTML = `<button class="btn btn-outline-secondary button ms-7 align-self-start" onclick="quitarComponenteProducto('${id}')" type="button" id="quitar">-</button>
                                <label class="input-group-text" for="producto" id="inputGroup-sizing-sm">Producto:</label>
                                <input type="text" class="form-control" disabled aria-label="Dollar amount (with dot and two decimal places)" id="producto">
                                <label class="input-group-text" for="cantidad" id="inputGroup-sizing-sm">Cantidad:</label>
                                <input type="text" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" id="cantidad">
                                <label class="input-group-text" for="valorunt" id="inputGroup-sizing-sm">Valor unitario:</label>
                                <input type="text" class="form-control" disabled aria-label="Dollar amount (with dot and two decimal places)" id="valorunt">
                                <label class="input-group-text" for="cantidad" id="inputGroup-sizing-sm">Total:</label>
                                <input type="text" class="form-control me-7" disabled aria-label="Dollar amount (with dot and two decimal places)" id="cantidad">`;
    contProductos.appendChild(contComponente);
}

const mostrarGrillaProductos = ()=>{
    let contGrilla = document.getElementById('contGrillaProducto');
    let contenedor = document.createElement("div");
    let cuerpoGrilla;
    contenedor.className = "grilla w-75 d-flex flex-column align-items-center rounded-4";
    
    productos.forEach(producto => {
       cuerpoGrilla =cuerpoGrilla+ `<tr class="grilla__cuerpo">
                            <td>${producto[1]}</td>
                            <td>${producto[2]}</td>
                            <td>${producto[3]}</td>
                            <td>${producto[4]}</td>
                            <td>${producto[5]}</td>
                            <td>${producto[6]}</td>
                            <td>${producto[7]}</td>
                        </tr>`;  
    });
    contenedor.innerHTML = `<div class="border w-75 mt-5 mb-5 rounded-4">
                                <table class="grilla__contenedor border-0">
                                    <tr class="grilla grilla__cabecera">
                                        <th>Nombre</th>
                                        <th>Marca</th>
                                        <th>Detalle</th>
                                        <th>Stock de usuario</th>
                                        <th>Tipo</th>
                                        <th>preciocompra</th>
                                        <th>precioventa</th>
                                    </tr>
                                    ${cuerpoGrilla}
                                </table>
                            </div>`;
    contGrilla.appendChild(contenedor);
}

const quitarComponenteProducto = (id) =>{
    document.getElementById(id).remove();
}