let MOPantallaEditar = false;

const guardarEdicion = (id) => {
  //window.location.href = "./index.php?module=usuarios";
  document.getElementById(id).style.display = "none";
};
//verifico si la pantalla de editar esta a la vista y si lo esta le cambio el display para ocultarla
const mostrarOcultarPantallaEditar = (id, inUse) => {
  let contDisplay = document.getElementById(id).style.display;
  document.getElementById(id).style.display =
    (contDisplay == "flex") & (inUse == "0")
      ? "none"
      : (contDisplay == "none") & (inUse == "1") && "flex";
};

const agregarComponenteProducto = () => {
  let contProductos = document.getElementById("contProductos");
  let contComponente = document.createElement("div");
  let numContenedores = contProductos.childElementCount;
  let id = "producto" + (numContenedores + 1);
  let productoSeleccionado;
  const queryString = window.location.search;
  const params = new URLSearchParams(queryString);
  const modulo = params.get("module");

  productos.forEach((producto) => {
    const checkSeleccion = document.getElementById("seleccion" + producto[0]);
    if (checkSeleccion.checked) productoSeleccionado = producto;
  });
  contComponente.className = "input-group input-group-sm mb-3";
  contComponente.id = id;

  contComponente.innerHTML = `<button class="btn btn-outline-secondary button ms-7 align-self-start" onclick="quitarComponenteProducto()" type="button" id="btnQuitar">-</button>
                                <label class="input-group-text" for="producto" id="inputGroup-sizing-sm">Producto:</label>
                                <input type="text" class="form-control w-25" disabled id="producto" value = "${
                                  productoSeleccionado[1]
                                }">
                                <label class="input-group-text" for="cantidad" id="inputGroup-sizing-sm">Cantidad:</label>
                                <input type="number" class="form-control" aria-label="0" onchange="cantidadOnChange('${
                                  productoSeleccionado[0]
                                }','${id}')" id="cantidad" name="cantidad[]">
                                <label class="input-group-text" for="valorunt" id="inputGroup-sizing-sm">Valor unitario:</label>
                                <input type="text" class="form-control" disabled value= "${currencyFormatter(
                                  modulo == "pedidos"
                                    ? productoSeleccionado[6]
                                    : productoSeleccionado[7]
                                )}" id="valorunt">
                                <label class="input-group-text" for="totañ" id="inputGroup-sizing-sm">Total:</label>
                                <input type="number" class="form-control me-7" disabled aria-label="0" id="total" step="any">
                                <input type="hidden" class="form-control me-7" aria-label="0" value="${
                                  productoSeleccionado[0]
                                }" id="idproductos" name="idproductos[]">`;
  contProductos.appendChild(contComponente);
  cerrarGrilla("contGrillaProducto");
};

const currencyFormatter = (value) => {
  const currency = "USD";
  const formatter = new Intl.NumberFormat("en-US", {
    style: "currency",
    minimumFractionDigits: 2,
    currency,
  });
  return formatter.format(value);
};

const mostrarGrillaProductos = (tipo) => {
  cerrarGrilla("contGrillaProducto");
  let contGrilla = document.getElementById("contGrillaProducto");
  let contenedor = document.createElement("div");
  let cuerpoGrilla = "";
  contenedor.className =
    "grilla d-flex flex-column align-items-center rounded-4 w-100";

  productos.forEach((producto) => {
    if (producto[8] == "habilitado") {
      cuerpoGrilla =
        cuerpoGrilla +
        `<tr class="grilla__cuerpo">
            <td>${producto[1]}</td>
            <td>${producto[2]}</td>
            <td>${producto[3]}</td>
            <td>${producto[4]}</td>
            <td>${producto[5]}</td>
            <td>${producto[6]}</td>
            <td>${producto[7]}</td>
            <td>
                <div class="form-check d-flex justify-content-center">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="seleccion${producto[0]}">
                </div>
            </td>
        </tr>`;
    }
  });
  contenedor.innerHTML = `<div class="d-flex mt-3 justify-content-end" style="width:90%;">
                                <div class="input-group input-group-sm w-25">
                                    <input type="text" class="form-control" placeholder="Ingrese su busqueda" aria-label="Recipient's username" aria-describedby="buscar">
                                    <input class="btn btn-outline-secondary button" type="button" id="buscar" value="Buscar"></button>
                                </div>
                            </div>
                            <div class="border px-3 pt-4 mb-5 mt-3 rounded-4" style="width:90%;">
                                <table class="grilla__contenedor w-100 border-0">
                                    <tr class="grilla grilla__cabecera">
                                        <th>Nombre</th>
                                        <th>Marca</th>
                                        <th>Detalle</th>
                                        <th>Stock</th>
                                        <th>Tipo</th>
                                        <th>preciocompra</th>
                                        <th>precioventa</th>
                                        <th>selección</th>
                                    </tr>
                                    ${cuerpoGrilla}
                                </table>
                                <div class="d-flex justify-content-center">
                                    <div class="input-group input-group-sm my-3 w-25">
                                        <label class="input-group-text" for="cantidad" id="inputGroup-sizing-sm">Cantidad:</label>
                                        <input type="number" class="form-control" aria-label="0" id="cantidadProducto" value="1" min="1">
                                    </div>
                                </div>
                            </div>`;
  contGrilla.appendChild(contenedor);
};

const cerrarGrilla = (id) => {
  let grilla = document.getElementById(id).childNodes[0];
  if (grilla) grilla.remove();
};

const quitarComponenteProducto = () => {
  getProductosChekeados().forEach((productoChekeado) => {
    productoChekeado.parentElement.parentElement.remove();
  });
  recalcularTotal();
  onChangeChecks();
};

const habilitarDeshabilitarBtn = () => {};

const recalcularTotal = () => {
  const totalesProductos = document.querySelectorAll("#total");
  const importeTotal = document.getElementById("totalproductos");
  const inputManoDeObra = document.getElementById("manodeobra");

  let total = parseFloat(0);
  totalesProductos.forEach((totalProducto) => {
    total =
      total + parseFloat(totalProducto.childNodes[0].data.replace(/[$,]/g, ""));
  });

  if (inputManoDeObra != null && inputManoDeObra.value != "") {
    total += parseFloat(inputManoDeObra.value);
  }

  importeTotal.setAttribute("value", currencyFormatter(total));
};

const cantidadOnChange = (idProducto, id, esPresupuesto) => {
  const inputCantidad = document.querySelector("#" + id + " #cantidad");
  let cantidad = parseInt(inputCantidad.value) || 0;
  
  const producto = productos.find(
    (producto) => parseInt(producto.idproducto) === parseInt(idProducto)
  );
  
  // Validar que la cantidad sea al menos 1
  if (cantidad < 1) {
    cantidad = 1;
    inputCantidad.value = 1;
  }
  
  // Validar que la cantidad no exceda el stock disponible
  if (cantidad > producto.stock) {
    cantidad = producto.stock;
    inputCantidad.value = producto.stock;
  }
  
  const inputTotal = document.querySelector("#" + id + " #total").childNodes[0];
  const queryString = window.location.search;
  const params = new URLSearchParams(queryString);
  const modulo = params.get("module");
  const precioUnit =
    modulo === "pedidos" ? producto.preciocompra : producto.precioventa;
  inputTotal.data = currencyFormatter(precioUnit * parseInt(cantidad));
  recalcularTotal();
};

const mostrarVentanaModal = (id) => {
  var miModal = new bootstrap.Modal(document.getElementById(id));
  miModal.show();
};

const validarFormulario = () => {};

const cargarGrillaProducto = (module, productosPrecargados = []) => {
  const queryString = window.location.search;
  const params = new URLSearchParams(queryString);
  const modulo = params.get("module");
  let contProductos = document.getElementById("grilla");
  if (productosPrecargados.length == 0) {
    let seAgregaProducto = true;
    let contComponente = document.createElement("tr");
    let cantidad =
      parseInt(document.getElementById("cantidadProducto").value) || 0;
    let productoSeleccionado;

    // Validar que la cantidad sea mayor a 0
    if (cantidad <= 0) {
      mostrarToast("error", "La cantidad debe ser mayor a 0");
      return;
    }

    productos.forEach((producto) => {
      const checkSeleccion = document.getElementById("seleccion" + producto[0]);
      if (checkSeleccion) {
        productoSeleccionado = checkSeleccion.checked
          ? producto
          : productoSeleccionado;
      }
    });

    // Validar que el producto tenga stock disponible
    if (productoSeleccionado && productoSeleccionado.stock <= 0) {
      mostrarToast("error", "Este producto no tiene stock disponible");
      return;
    }
    if (module === "presupuestos") {
      cantidad =
        cantidad >= productoSeleccionado.stock
          ? productoSeleccionado.stock
          : cantidad;
    } else {
      cantidad = cantidad;
    }
    let id = "producto" + productoSeleccionado[0];
    if (contProductos.childElementCount > 0) {
      Array.from(contProductos.children).forEach((productoGrilla) => {
        if (productoGrilla.id == id) {
          const cantidadProducto = document.querySelector(
            "#grilla #" + id + " #cantidad"
          );
          sumatoriaCantidad = Number(cantidadProducto.value) + Number(cantidad);
          
          // Validar que la cantidad total no exceda el stock
          if (sumatoriaCantidad > productoSeleccionado.stock) {
            sumatoriaCantidad = productoSeleccionado.stock;
            mostrarToast("warning", "Cantidad total ajustada al stock disponible (" + productoSeleccionado.stock + ")");
          }
          
          cantidadProducto.value = sumatoriaCantidad;

          cantidadOnChange(productoSeleccionado[0], productoGrilla.id, true);
          seAgregaProducto = false;
        }
      });
    }
    if (seAgregaProducto) {
      let precioUnit =
        modulo === "pedidos"
          ? productoSeleccionado[6]
          : productoSeleccionado[7];
      contComponente.className = "grilla__cuerpo";
      contComponente.id = id;
      contComponente.innerHTML = `<td id="producto"> ${
        productoSeleccionado.nombre
      } </td>
                                        <td> <input type="number" value="${cantidad}" class="form-control" onchange="cantidadOnChange('${
        productoSeleccionado[0]
      }','${id}', '${
        module === "presupuestos"
      }')" id="cantidad" name="cantidad[]" min="1" step="1" required></td>
                                        <td id="valorunt"> ${currencyFormatter(
                                          precioUnit
                                        )} </td>
                                        <td id="total"> ${currencyFormatter(
                                          parseInt(cantidad) * precioUnit
                                        )} </td>
                                        <td><input class="form-check-input checksProductos" onchange="onChangeChecks()" type="checkbox"></td>
                                        <input type="hidden" class="form-control me-7" aria-label="0" value="${
                                          productoSeleccionado[0]
                                        }" id="idproductos" name="idproductos[]">`;
      contProductos.appendChild(contComponente);
    }
    cerrarGrilla("contGrillaProducto");
  } else {
    productosPrecargados.forEach((productoPrecargado) => {
      let id = "producto" + productoPrecargado[0];
      let contComponente = document.createElement("tr");
      contComponente.className = "grilla__cuerpo";
      contComponente.id = id;
      contComponente.innerHTML = `<td id="producto"> ${
        productoPrecargado.nombre
      } </td>
                                 <td> <input type="number" value="${
                                   productoPrecargado.cantidad
                                 }" class="form-control" onchange="cantidadOnChange('${
        productoPrecargado.idproducto
      }','${id}', '${
        module === "presupuestos"
      }')" id="cantidad" name="cantidad[]" min="1" step="1" required></td>
                                 <td id="valorunt"> ${currencyFormatter(
                                   productoPrecargado[5]
                                 )} </td>
                                 <td id="total"> ${currencyFormatter(
                                   parseInt(productoPrecargado.cantidad) *
                                     productoPrecargado[5]
                                 )} </td>
                                 <td><input class="form-check-input checksProductos" onchange="onChangeChecks()" type="checkbox"></td>
                                 <input type="hidden" class="form-control me-7" aria-label="0" value="${
                                   productoPrecargado.idproducto
                                 }" id="idproductos" name="idproductos[]">`;
      contProductos.appendChild(contComponente);
    });
  }
  recalcularTotal();
};

const onChangeChecks = () => {
  let btnQuitar = document.getElementById("btnQuitar");
  let productosChekeados = getProductosChekeados();
  btnQuitar.disabled =
    productosChekeados && productosChekeados.length > 0 ? false : true;
};

const getProductosChekeados = () => {
  let checksSeleccionados = document.querySelectorAll(".checksProductos");
  let checksCheckeados = [];
  for (let i = 0; i < checksSeleccionados.length; i++) {
    if (checksSeleccionados[i].checked)
      checksCheckeados.push(checksSeleccionados[i]);
  }
  return checksCheckeados;
};

const tipoOnChange = (selector) => {
  const tipo = selector.target.value;
  recargarPagina({type: tipo});
};

const clickBorrarBusqueda = () => {
  // Seleccionar el input de búsqueda
  const input = document.getElementById("termino");

  // Agregar un listener de eventos al input para detectar cambios
  input.addEventListener("input", function () {
    // Verificar si el input está vacío
    if (input.value.trim() === "") {
      // Si está vacío, enviar el formulario
      document.getElementById("formBuscador").submit();
    }
  });
};

const recargarPagina = (parametros) => {
  var currentUrl = window.location.href;
  var url = new URL(currentUrl);

  for (var key in parametros) {
    if (parametros.hasOwnProperty(key)) {
      url.searchParams.set(key, parametros[key]);
    }
  }
  window.location.href = url.toString();
};

function imprimirEnIframeOculto(datos, tipoDocumento) {
  const iframe = document.createElement("iframe");
  iframe.style.position = "fixed";
  iframe.style.width = "0";
  iframe.style.height = "0";
  iframe.style.border = "none";
  document.body.appendChild(iframe);

  let emisor = {};
  let receptor = {};

  if (tipoDocumento === "presupuesto") {
    emisor = {
      nombre: "Integral Service",
      direccion: "Balcarce 653",
      provincia: "Entre Ríos",
      localidad: "Concordia",
      cuit: "20-38926571-6",
      categoriafiscal: "Monotributista",
    };
    receptor = {
      nombre: datos.cliente,
      categoriafiscal: datos.categoriafiscal,
      cuit: datos.cuit,
    };
  } else if (tipoDocumento === "pedido") {
    emisor = {
      nombre: datos.proveedor,
      direccion: datos.direccion || "",
      provincia: datos.provincia || "",
      localidad: datos.localidad || "",
      cuit: datos.cuit,
      categoriafiscal: datos.categoriafiscal,
    };
    receptor = {
      nombre: "Integral Service",
      direccion: "Balcarce 653",
      provincia: "Entre Ríos",
      localidad: "Concordia",
      cuit: "20-38926571-6",
      categoriafiscal: "Monotributista",
    };
  }

  const contenido = `
    <html>
    <head>
      <title>${
        tipoDocumento === "presupuesto" ? "Presupuesto" : "Pedido"
      }</title>
      <style>
        body {
          font-family: Arial, sans-serif;
          margin: 40px;
        }
        .factura {
          border: 1px solid #000;
          padding: 20px;
          width: 700px;
          margin: 0 auto;
        }
        .tipo-factura {
          display: inline-block;
          border: 2px solid #000;
          border-radius: 10px;
          padding: 8px 18px;
          font-weight: bold;
          font-size: 22px;
          text-align: center;
          margin-bottom: 10px;
        }
        h2 {
          text-align: center;
          margin: 5px 0 20px 0;
        }
        .info-emisor {
          display: flex;
          justify-content: space-between;
          margin-bottom: 10px;
        }
        .col {
          width: 48%;
        }
        .col p {
          margin: 4px 0;
          font-size: 14px;
        }
        .divider {
          border-top: 1px solid #000;
          margin: 15px 0;
        }
        .info-receptor {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 15px;
        }
        .info-receptor p {
          margin: 0;
          font-size: 14px;
        }
        .section-title {
          font-weight: bold;
          font-size: 15px;
          margin: 15px 0 5px 0;
          text-align: left;
        }
        table {
          width: 100%;
          border-collapse: collapse;
          margin-top: 5px;
          font-size: 14px;
        }
        th, td {
          border: 1px solid #000;
          padding: 6px;
          text-align: center;
        }
        th {
          background-color: #f2f2f2;
        }
        .total {
          text-align: right;
          font-weight: bold;
          margin-top: 10px;
          font-size: 16px;
        }
      </style>
    </head>
    <body>
      <div class="factura">
        <div style="text-align:center;">
          <div class="tipo-factura">${datos.tipo}</div>
          <h2>${
            datos.tipo === "C"
              ? "Factura"
              : tipoDocumento === "presupuesto"
              ? "Presupuesto"
              : "Pedido de compra"
          }</h2>

        </div>

        <!-- Bloque emisor -->
        <div class="info-emisor">
          <div class="col">
            <p><strong>${emisor.nombre}</strong></p>
            <p><strong>Condición frente al IVA:</strong> ${
              emisor.categoriafiscal
            }</p>
            ${
              emisor.direccion
                ? `<p><strong>Dirección:</strong> ${emisor.direccion}</p>`
                : ""
            }
            ${
              emisor.provincia
                ? `<p><strong>Provincia:</strong> ${emisor.provincia}</p>`
                : ""
            }
            ${
              emisor.localidad
                ? `<p><strong>Localidad:</strong> ${emisor.localidad}</p>`
                : ""
            }
          </div>
          <div class="col" style="text-align:right;">
            <p><strong>Punto de venta:</strong> 0001</p>
            ${
              datos.nrocomprobante
                ? `<p><strong>Comp. Nro:</strong> ${datos.nrocomprobante}</p>`
                : ""
            }
            <p><strong>Fecha:</strong> ${datos.fecha}</p>
            <p><strong>CUIT:</strong> ${emisor.cuit}</p>
          </div>
        </div>

        <div class="divider"></div>

        <!-- Bloque receptor -->
        <div class="info-receptor">
          <p><strong>${
            tipoDocumento === "presupuesto" ? "Cliente" : "Proveedor"
          }:</strong> ${receptor.nombre}</p>
          <p><strong>Condición frente al IVA:</strong> ${
            receptor.categoriafiscal
          }</p>
          <p><strong>CUIT:</strong> ${receptor.cuit}</p>
        </div>

        <div class="divider"></div>

        <!-- Título Productos/Servicios -->
        <p class="section-title">Productos / Servicios</p>

        <!-- Tabla productos -->
        <table>
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Marca</th>
              <th>Detalle</th>
              <th>Cantidad</th>
              <th>Precio unitario</th>
              <th>Importe</th>
            </tr>
          </thead>
          <tbody>
            ${datos.productos
              .map(
                (p) => `
              <tr>
                <td>${p.nombre}</td>
                <td>${p.marca}</td>
                <td>${p.detalle}</td>
                <td>${p.cantidad}</td>
                <td>$${(p.precioventa || p.preciocompra).toLocaleString()}</td>
                <td>$${(
                  p.total || p.cantidad * (p.precioventa || p.preciocompra)
                ).toLocaleString()}</td>
              </tr>
            `
              )
              .join("")}
            ${
              datos.manodeobra && datos.manodeobra > 0
                ? `
              <tr>
                <td>Mano de obra</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>$${parseFloat(datos.manodeobra).toLocaleString()}</td>
                <td>$${parseFloat(datos.manodeobra).toLocaleString()}</td>
              </tr>
            `
                : ""
            }
          </tbody>
        </table>

        <p class="total">Total: $${datos.total}</p>
      </div>
    </body>
    </html>
  `;

  const doc = iframe.contentWindow.document;
  doc.open();
  doc.write(contenido);
  doc.close();

  iframe.onload = function () {
    iframe.contentWindow.focus();
    iframe.contentWindow.print();
    setTimeout(() => iframe.remove(), 1000);
  };
}

function formatMoney(input) {
  // Eliminar caracteres no numéricos excepto el punto
  input.value = input.value.replace(/[^0-9.]/g, "");

  // Asegurar solo un punto decimal
  let parts = input.value.split(".");
  if (parts.length > 2) {
    input.value = parts[0] + "." + parts.slice(1).join("");
  }

  // Limitar a 2 decimales
  if (parts.length === 2) {
    input.value = parts[0] + "." + parts[1].substring(0, 2);
  }

  input.addEventListener("blur", () => {
    let parts = input.value.split(".");
    if (parts[0] != "" && (parts[1] === "" || parts.length === 1)) {
      input.value = parts[0] + ".00";
    }
    recalcularTotal();
  });
}

function togglePassword(button, event) {
  event.preventDefault();
  const input = document.getElementById("contrasena");
  icon = button.querySelector("#iconVerContrasena");

  const isHidden = input.type === "password";
  input.type = isHidden ? "text" : "password";

  // Cambia la imagen según el estado
  icon.src = isHidden
    ? "./assets/img/iconoNoVerContrasena.png"
    : "./assets/img/iconoVerContrasena.png";
}

function screenCenter(id) {
  window.onload = () => {
    const elemento = document.getElementById(id);
    if (elemento) {
      elemento.scrollIntoView({behavior: "smooth", block: "start"});
    }
  };
}
