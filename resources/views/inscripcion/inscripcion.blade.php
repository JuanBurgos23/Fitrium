<!-- resources/views/clientes.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <style>
        input[readonly] {
            background-color: #2a2a2a !important;
            /* Fondo oscuro */
            color: #ffffff !important;
            /* Texto blanco */
            border: 1px solid #444 !important;
            /* Borde gris oscuro */
            cursor: not-allowed;
            /* Cursor de deshabilitado */
        }
    </style>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl">
            <!-- Navbar content -->
        </nav>

        <div class="container-fluid py-4" style="margin-top: 40px;"> <!-- Se añade un margen superior aquí -->
            @if(session('success'))
            <div class="alert alert-success" id="successMessage">
                {{ session('success') }}
            </div>
            <script>
                // Después de 3 segundos (3000 ms), eliminar el mensaje
                setTimeout(function() {
                    const successMessage = document.getElementById('successMessage');
                    if (successMessage) {
                        successMessage.style.display = 'none';
                    }
                }, 3000);
            </script>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="col-12">

                <div class="card my-4">

                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <h2>Clientes Inscritos</h2>
                    </div>

                    <div class="me-3 my-3 text-end">
                        <!-- Contenedor principal con flexbox -->
                        <div class="d-flex align-items-center">
                            <form method="GET" action="{{ route('mostrar_inscripcion') }}" class=" mb-0 d-flex align-items-center me-2 w-100">
                                <input type="text" name="search" value="{{ old('search', $search) }}" placeholder="Buscar por CI o Apellido Paterno" class="form-control flex-grow-1" style="max-width: 250px;">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </form>
                            <!-- Botón Agregar Cliente al mismo nivel que el formulario, con margen izquierdo -->
                            <button class="btn btn-primary ms-3" style="margin-left: 20px;" data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="fas fa-user-plus"></i> Agregar Inscripcion
                            </button>
                            <a href="{{ route('historial_inscripciones') }}" class="btn btn-info" style="margin-left: 20px;">
                                <i class="fas fa-history"></i> Ver Historial
                            </a>
                        </div>
                    </div>

                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre Completo</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">CI</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Paquete</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Expira</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($clientes as $cliente)
                                    @if (!empty($cliente->inscripciones) && $cliente->inscripciones->count() > 0)
                                    @foreach ($cliente->inscripciones as $inscripcion)
                                    @php
                                    $recibo = $inscripcion->recibos()->latest('id')->first(); // Obtener el recibo asociado
                                    @endphp
                                    <tr>
                                        <td class="align-middle text-center">
                                            <h6 class="mb-0 text-sm">{{ $cliente->nombre_completo }}</h6>
                                        </td>
                                        <td class="align-middle text-center">
                                            <h6 class="mb-0 text-sm">{{ $cliente->ci }}</h6>
                                        </td>
                                        <td class="align-middle text-center">
                                            <h6 class="mb-0 text-sm">{{ $inscripcion->paquete->nombre }}</h6>
                                        </td>
                                        <td class="align-middle text-center">
                                            <h6 class="mb-0 text-sm">{{ $inscripcion->fecha_expiracion }}</h6>
                                        </td>
                                        <td class="align-middle text-center">
                                            <label class="badge 
                            @if($inscripcion->estado == 'Vigente') badge-success 
                            @elseif($inscripcion->estado == 'Caducado') badge-danger 
                            @elseif($inscripcion->estado == 'Abandonado') badge-warning 
                            @else badge-primary 
                            @endif">
                                                {{ $inscripcion->estado }}
                                            </label>
                                            <label class="badge 
                            @if($recibo && $recibo->estado == 'Pagado') badge-success 
                            @elseif($recibo && $recibo->estado == 'Debe') badge-danger 
                            @else badge-primary 
                            @endif">
                                                {{ $recibo ? $recibo->estado : 'Sin recibo' }}
                                            </label>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-1 justify-content-center">
                                                @if ($inscripcion->estado == 'Caducado' || $inscripcion->estado == 'Abandonado')
                                                <!-- Mostrar botón de Renovar solo si la inscripción está caducada o abandonada -->
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalRenovar" onclick="abrirModalRenovar({{ $inscripcion->id }})">
                                                    Renovar
                                                </button>
                                                @endif
                                                <a href="{{ route('historial_cliente', ['id' => $cliente->id]) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-file-pdf"></i> Historial
                                                </a>
                                                <a href="{{ route('historial_recibos_cliente', ['id' => $cliente->id]) }}" class="btn btn-success btn-sm">
                                                    <i class="fas fa-file-invoice"></i> Recibos
                                                </a>
                                                @if($recibo && $recibo->estado == 'Debe')
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalPagar" data-id="{{ $recibo->id }}">
                                                    Pagar
                                                </button>
                                                @endif
                                                @if($recibo)
                                                <a href="{{ route('recibo.pdf', $recibo->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-download"></i> Generar Recibo
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6" class="text-center">No hay inscripciones registradas para este cliente.</td>
                                    </tr>
                                    @endif
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay clientes registrados.</td>
                                    </tr>
                                    @endforelse
                                </tbody>

                            </table>
                            {{ $clientes->links('pagination::bootstrap-4') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Pagar -->
        <div class="modal fade" id="modalPagar" tabindex="-1" aria-labelledby="modalPagarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPagarLabel">Realizar Pago</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form action="{{ route('pagar_recibo') }}" method="POST">
                        @csrf
                        <input type="hidden" id="recibo_id" name="recibo_id">

                        <div class="modal-body">
                            <p><strong>Recibido de:</strong> <span id="recibido_deDeuda"></span></p>
                            <p><strong>Concepto:</strong> <span id="conceptoDeuda"></span></p>
                            <p><strong>Total a pagar:</strong> <span id="totalDeuda"></span> Bs.</p>
                            <p><strong>Abonado:</strong> <span id="a_cuentaDeuda"></span> Bs.</p>
                            <p><strong>Saldo Pendiente:</strong> <span id="saldoDeuda"></span> Bs.</p>

                            <label for="monto_pagado">Monto a Pagar</label>
                            <input type="number" step="0.01" class="form-control" id="monto_pagadoDeuda" name="monto_pagadoDeuda" required>
                            <label for="forma_Pago" class="form-label">Forma de Pago</label>
                            <select type="text" class="form-control" id="forma_pagoDeuda" name="forma_pagoDeuda">
                                <option value="Efectivo">Efectivo</option>
                                <option value="QR">QR</option>
                                <option value="Transferencia">Transferencia</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Confirmar Pago</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal de Agregar inscripcio -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Agregar Nueva Inscripción</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/inscripcion-register" method="POST">
                            @csrf
                            <!-- Buscador de Cliente -->
                            <div class="mb-3">
                                <label for="buscarCliente" class="form-label">Buscar Cliente</label>
                                <input type="text" class="form-control" id="buscarCliente" placeholder="Ingrese nombre o CI">
                                <div id="clientesResultados" class="list-group mt-1 d-none"></div>
                            </div>

                            <!-- Campos que se llenan automáticamente -->
                            <input type="hidden" id="cliente_id" name="cliente_id">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="paterno" class="form-label">Apellido Paterno</label>
                                    <input type="text" class="form-control" id="paterno" name="paterno" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="materno" class="form-label">Apellido Materno</label>
                                    <input type="text" class="form-control" id="materno" name="materno" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ci" class="form-label">Cédula de Identidad (C.I)</label>
                                    <input type="text" class="form-control" id="ci" name="ci" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="correo" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="correo" name="correo" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="paquete_id" class="form-label">Paquete</label>
                                    <select name="paquete_id" id="paquete_id" class="form-control" required>
                                        <option value="">Seleccione un paquete</option>
                                        @foreach ($paquetes as $paquete)
                                        <option value="{{ $paquete->id }}" data-precio="{{ $paquete->precio }}">
                                            {{ $paquete->nombre }} - {{ $paquete->duracion }} días - Bs.{{ $paquete->precio }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- 🔹 Nuevo: Campos de Pago -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="monto_pagado" class="form-label">A Cuenta (Bs.)</label>
                                    <input type="number" class="form-control" id="monto_pagado" name="a_cuenta" min="0" step="0.01" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="saldo_pendiente" class="form-label">Saldo Pendiente (Bs.)</label>
                                    <input type="text" class="form-control" id="saldo_pendiente" name="saldo" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="total" class="form-label">Total (Bs.)</label>
                                    <input type="text" class="form-control" id="total" name="total" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="forma_Pago" class="form-label">Forma de Pago</label>
                                    <select type="text" class="form-control" id="forma_pago" name="forma_pago">
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="QR">QR</option>
                                        <option value="Transferencia">Transferencia</option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal de Renovar Inscripción -->
        <!-- Modal de Renovación -->
        <div class="modal fade" id="modalRenovar" tabindex="-1" aria-labelledby="modalRenovarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalRenovarLabel">Renovar Inscripción</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formRenovar" method="POST">
                            @csrf
                            <input type="hidden" name="inscripcion_id" id="inscripcion_id">

                            <label for="paquete_id">Seleccionar nuevo paquete:</label>
                            <select name="paquete_idRenovar" id="paquete_idRenovar" class="form-control" required>
                                <option value="">Seleccione un paquete</option>
                                @foreach ($paquetes as $paquete)
                                <option value="{{ $paquete->id }}" data-precio="{{ $paquete->precio }}">
                                    {{ $paquete->nombre }} - {{ $paquete->duracion }} días - Bs.{{ $paquete->precio }}
                                </option>
                                @endforeach
                            </select>
                            <!-- 🔹 Nuevo: Campos de Pago -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="monto_pagado" class="form-label">A Cuenta (Bs.)</label>
                                    <input type="number" class="form-control" id="monto_pagadoRenovar" name="a_cuentaRenovar" min="0" step="0.01" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="saldo_pendiente" class="form-label">Saldo (Bs.)</label>
                                    <input type="text" class="form-control" id="saldo_pendienteRenovar" name="saldoRenovar" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="total" class="form-label">Total (Bs.)</label>
                                    <input type="text" class="form-control" id="totalRenovar" name="totalRenovar" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="forma_Pago" class="form-label">Forma de Pago</label>
                                    <select type="text" class="form-control" id="forma_pago" name="forma_pagoRenovar">
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="QR">QR</option>
                                        <option value="Transferencia">Transferencia</option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Renovar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Función para abrir el modal con el ID correcto
            function abrirModalRenovar(inscripcionId) {
                let form = document.getElementById('formRenovar');
                let inscripcionInput = document.getElementById('inscripcion_id');

                // Guardar el ID en el input hidden (opcional si no se usa en el backend)
                inscripcionInput.value = inscripcionId;

                // Modificar la acción del formulario con el ID en la URL
                form.action = `/inscripcion/renovar/${inscripcionId}`;


            }

            document.addEventListener('DOMContentLoaded', function() {
                const buscarClienteInput = document.getElementById('buscarCliente');
                const clientesResultados = document.getElementById('clientesResultados');

                buscarClienteInput.addEventListener('input', function() {
                    let query = buscarClienteInput.value.trim();
                    if (query.length < 2) {
                        clientesResultados.classList.add('d-none');
                        clientesResultados.innerHTML = '';
                        return;
                    }

                    // Realizar búsqueda al servidor
                    fetch(`/buscar-cliente?query=${query}`)
                        .then(response => response.json())
                        .then(clientes => {
                            clientesResultados.innerHTML = '';
                            if (clientes.length > 0) {
                                clientes.forEach(cliente => {
                                    let clienteItem = document.createElement('a');
                                    clienteItem.href = "#";
                                    clienteItem.classList.add('list-group-item', 'list-group-item-action');
                                    clienteItem.textContent = `${cliente.nombre} ${cliente.paterno} - CI: ${cliente.ci}`;
                                    clienteItem.dataset.cliente = JSON.stringify(cliente);
                                    clienteItem.addEventListener('click', function() {
                                        seleccionarCliente(cliente);
                                    });
                                    clientesResultados.appendChild(clienteItem);
                                });
                                clientesResultados.classList.remove('d-none');
                            } else {
                                clientesResultados.classList.add('d-none');
                            }
                        })
                        .catch(error => console.error('Error en la búsqueda:', error));
                });

                function seleccionarCliente(cliente) {
                    document.getElementById('cliente_id').value = cliente.id;
                    document.getElementById('nombre').value = cliente.nombre;
                    document.getElementById('paterno').value = cliente.paterno;
                    document.getElementById('materno').value = cliente.materno;
                    document.getElementById('ci').value = cliente.ci;
                    document.getElementById('telefono').value = cliente.telefono;
                    document.getElementById('correo').value = cliente.correo;
                    clientesResultados.classList.add('d-none');
                    buscarClienteInput.value = `${cliente.nombre} ${cliente.paterno}`;
                }
            });

            //Nuevo: Actualizar saldo pendiente al cambiar monto pagado
            document.addEventListener("DOMContentLoaded", function() {
                const paqueteSelect = document.getElementById("paquete_id");
                const totalInput = document.getElementById("total");
                const montoPagadoInput = document.getElementById("monto_pagado");
                const saldoPendienteInput = document.getElementById("saldo_pendiente");

                // Cuando cambia el paquete, actualiza el total a pagar
                paqueteSelect.addEventListener("change", function() {
                    const selectedOption = paqueteSelect.options[paqueteSelect.selectedIndex];
                    const precio = selectedOption.getAttribute("data-precio");

                    totalInput.value = precio || "";
                    montoPagadoInput.value = ""; // Resetear monto pagado
                    saldoPendienteInput.value = precio || ""; // Asignar total como saldo pendiente
                });

                // Cuando cambia el monto pagado, recalcular saldo pendiente
                montoPagadoInput.addEventListener("input", function() {
                    const total = parseFloat(totalInput.value) || 0;
                    const pagado = parseFloat(montoPagadoInput.value) || 0;
                    const saldo = Math.max(total - pagado, 0); // Evita valores negativos

                    saldoPendienteInput.value = saldo.toFixed(2);
                });
                // Para el modal de renovación
                const paqueteSelectRenovar = document.getElementById("paquete_idRenovar");
                const totalInputRenovar = document.getElementById("totalRenovar");
                const montoPagadoInputRenovar = document.getElementById("monto_pagadoRenovar");
                const saldoPendienteInputRenovar = document.getElementById("saldo_pendienteRenovar");

                paqueteSelectRenovar.addEventListener("change", function() {
                    let precio = paqueteSelectRenovar.options[paqueteSelectRenovar.selectedIndex].dataset.precio || 0;
                    totalInputRenovar.value = precio;
                    saldoPendienteInputRenovar.value = precio;
                    montoPagadoInputRenovar.value = "";
                });

                montoPagadoInputRenovar.addEventListener("input", function() {
                    let total = parseFloat(totalInputRenovar.value) || 0;
                    let pagado = parseFloat(montoPagadoInputRenovar.value) || 0;
                    saldoPendienteInputRenovar.value = (total - pagado).toFixed(2);
                });
            });

            //Nuevo: Mostrar datos de recibo al abrir modal de pago
            document.getElementById('modalPagar').addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // Botón que abrió el modal
                const id = button.getAttribute('data-id'); // Obtener el ID del recibo

                if (!id) return;

                // Hacer la solicitud AJAX
                fetch(`/recibo/${id}`)
                    .then(response => response.json())
                    .then(recibo => {
                        // Llenar los campos del modal con los datos obtenidos
                        document.getElementById('recibo_id').value = recibo.id;
                        document.getElementById('recibido_deDeuda').textContent = recibo.recibido_de;
                        document.getElementById('conceptoDeuda').textContent = recibo.concepto;
                        document.getElementById('totalDeuda').textContent = recibo.total;
                        document.getElementById('a_cuentaDeuda').textContent = recibo.a_cuenta;
                        document.getElementById('saldoDeuda').textContent = recibo.saldo;
                    })
                    .catch(error => {
                        console.error('Error al obtener los datos del recibo:', error);
                    });
            });

            // Mejora con soporte para acentos y ñ
            function toTitleCase(str) {
                return str
                    .toLowerCase()
                    .replace(/(^|\s)([a-záéíóúñü])/g, function(match, separator, char) {
                        return separator + char.toUpperCase();
                    });
            }

            // Aplicar a los campos deseados
            ['nombre', 'paterno', 'materno'].forEach(function(id) {
                const input = document.getElementById(id);
                input.addEventListener('input', function() {
                    const caret = input.selectionStart; // mantener posición del cursor
                    this.value = toTitleCase(this.value);
                    input.setSelectionRange(caret, caret); // restaurar posición del cursor
                });
            });
        </script>



    </main>
</x-layout>