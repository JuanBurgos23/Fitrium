<!-- resources/views/clientes.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Asistencia</title>
  
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    
   
    
</head>

<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

        <div class="container-fluid py-4" style="margin-top: 40px;">
            @if(session('success'))
            <div class="alert alert-success" id="successMessage">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => {
                    document.getElementById('successMessage')?.remove();
                }, 3000);
            </script>
            @endif

            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header d-flex justify-content-between align-items-center px-4">
                        <h2 class="mb-0">Listado de Asistencia</h2>

                    </div>

                    <div class="me-3 my-3 text-end">
                        <!-- Contenedor principal con flexbox -->
                        <div class="d-flex align-items-center">

                            <!-- Botón Agregar Cliente al mismo nivel que el formulario, con margen izquierdo -->
                            <button class="btn btn-primary ms-3" style="margin-left: 20px;" data-toggle="modal" data-target="#modalAgregarAsistencia">
                                <i class="fas fa-user-plus"></i> Agregar Asistencia
                            </button>

                        </div>
                    </div>

                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nombre Completo</th>
                                        <th class="text-center">CI</th>
                                        <th class="text-center">Hora Entrada</th>
                                        <th class="text-center">Casillero</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($asistencias as $cliente)
                                    <tr>
                                        <td class="text-center">{{ $cliente->inscripcion->cliente->nombre_completo ?? 'Sin nombre' }}</td>
                                        <td class="text-center">
                                            {{ $cliente->inscripcion->cliente->ci ?? 'Sin CI' }}
                                        </td>
                                        <td class="text-center">{{ $cliente->hora_entrada }}</td>
                                        <td class="text-center">{{ $cliente->casillero->nro_casillero ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $cliente->estado === 'Activo' ? 'badge-success' : 'badge-primary' }}">
                                                {{ ucfirst($cliente->estado) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($cliente->estado === 'Activo')
                                            <form action="{{ route('asistencia.finalizar', $cliente->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-door-open"></i> Finalizar
                                                </button>
                                            </form>
                                            @else
                                            <em>No disponible</em>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay asistencias registradas.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Agregar Asistencia -->
        <div class="modal fade" id="modalAgregarAsistencia" tabindex="-1" role="dialog" aria-labelledby="modalAgregarAsistenciaLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('asistencia.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalAgregarAsistenciaLabel">Agregar Asistencia</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <!-- Buscador de Cliente -->
                            <div class="mb-3">
                                <label for="buscarCliente" class="form-label">Buscar Cliente</label>
                                <input type="text" class="form-control" id="buscarCliente" placeholder="Ingrese nombre o CI">
                                <div id="clientesResultados" class="list-group mt-1 d-none"></div>
                            </div>

                            <!-- Select Cliente (rellenado dinámicamente) -->
                            <div class="form-group">
                                <label for="inscripcion_id">Cliente Seleccionado</label>
                                <select class="form-control" name="id_inscripcion" id="inscripcion_id" required>
                                    <option value=""></option>
                                    @foreach($clientesVigentes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre_completo }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Select Casillero -->
                            <div class="form-group">
                                <label for="casillero_id">Casillero Disponible</label>
                                <select class="form-control" name="casillero_id" id="casillero_id" required>
                                    @foreach($casillerosDisponibles as $casillero)
                                    <option value="{{ $casillero->id }}">N° {{ $casillero->nro_casillero }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Registrar Asistencia</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const buscarClienteInput = document.getElementById('buscarCliente');
                const clientesResultados = document.getElementById('clientesResultados');
                const selectCliente = document.getElementById('inscripcion_id');

                buscarClienteInput.addEventListener('input', function() {
                    let query = buscarClienteInput.value.trim();
                    if (query.length < 2) {
                        clientesResultados.classList.add('d-none');
                        clientesResultados.innerHTML = '';
                        return;
                    }

                    fetch(`/api/clientes-vigentes?query=${query}`)
                        .then(response => response.json())
                        .then(clientes => {
                            clientesResultados.innerHTML = '';
                            if (clientes.mensaje) {
                                // Si no hay clientes vigentes, mostrar mensaje
                                clientesResultados.innerHTML = `<div class="list-group-item list-group-item-action text-danger">${clientes.mensaje}</div>`;
                                clientesResultados.classList.remove('d-none');
                            } else if (clientes.length > 0) {
                                // Mostrar clientes vigentes
                                clientes.forEach(cliente => {
                                    let clienteItem = document.createElement('a');
                                    clienteItem.href = "#";
                                    clienteItem.classList.add('list-group-item', 'list-group-item-action');
                                    clienteItem.textContent = `${cliente.nombre_completo} - CI: ${cliente.ci}`;
                                    clienteItem.addEventListener('click', function() {
                                        seleccionarCliente(cliente);
                                    });
                                    clientesResultados.appendChild(clienteItem);
                                });
                                clientesResultados.classList.remove('d-none');
                            } else {
                                // Si no hay resultados, ocultar la lista
                                clientesResultados.classList.add('d-none');
                            }
                        })
                        .catch(error => console.error('Error en la búsqueda:', error));
                });

                function seleccionarCliente(cliente) {
                    // Limpiar select y añadir solo el cliente seleccionado
                    selectCliente.innerHTML = '';
                    const option = document.createElement('option');
                    option.value = cliente.id; // Este debe ser el ID de inscripción
                    option.textContent = `${cliente.nombre_completo} - CI: ${cliente.ci}`;
                    option.selected = true;
                    selectCliente.appendChild(option);

                    // Ocultar lista y actualizar input
                    clientesResultados.classList.add('d-none');
                    buscarClienteInput.value = `${cliente.ci}`;
                }
            });
        </script>

    </main>
</x-layout>