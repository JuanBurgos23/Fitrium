<x-layout bodyClass="g-sidenav-show bg-gray-200">
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

            <div class="col-12">

                <div class="card my-4">

                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <h2>Listado de Casillero</h2>
                    </div>

                    <div class="me-3 my-3 text-end">
                        <!-- Contenedor principal con flexbox -->
                        <div class="d-flex align-items-center">

                            <!-- Botón Agregar Cliente al mismo nivel que el formulario, con margen izquierdo -->
                            <button class="btn btn-primary ms-3" style="margin-left: 20px;" data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="fas fa-user-plus"></i> Agregar Casillero
                            </button>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nro. Casillero</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($casilleros as $casillero)
                                    <tr>
                                        <td class="align-middle text-center">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $casillero->nro_casillero }}</h6>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <label class="badge 
                            @if($casillero->estado == 'Disponible') badge-success 
                            @elseif($casillero->estado == 'Ocupado') badge-danger 
                            @else badge-primary 
                            @endif">
                                                {{ $casillero->estado }}
                                            </label>

                                        </td>
                                        <td class="align-middle text-center">
                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $casillero->id }}">
                                                <i class="fas fa-edit"></i> Editar
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay casillero registrados.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Paginación -->

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Agregar paquete -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Agregar Nuevo Casillero</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario de agregar paquete -->
                        <form action="/casillero-register" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nro_casillero" class="form-label">Nro Casillero</label>
                                <input type="text" class="form-control" id="nro_casillero" name="nro_casillero" required>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-control" id="estado" name="estado" required>
                                    <option value="Disponible">Disponible</option>
                                    <option value="Ocupado">Ocupado</option>
                                </select>
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

        <!-- Modal de Editar casillero -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Editar Casillero</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario de editar casillero -->
                        <form action="" method="POST" id="editForm">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nro_casillero" class="form-label">Nro Casillero</label>
                                <input type="text" class="form-control" id="edit_nro_casillero" name="nro_casillero">
                            </div>
                            <div class="mb-3">
                                <label for="edit_estado" class="form-label">Estado</label>
                                <select type="text" class="form-control" id="edit_estado" name="estado" >
                                    <option value="Disponible">Disponible</option>
                                    <option value="Ocupado">Ocupado</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script>
            // Llenar el formulario de editar con los datos del cliente
            const editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // El botón que activó el modal
                const id = button.getAttribute('data-id'); // Obtener el ID del cliente desde el atributo 'data-id'
                const form = document.getElementById('editForm');
                form.action = '/casillero-update/' + id; // Establecer la acción del formulario con la ruta correcta

                // Hacer la solicitud Fetch para obtener los datos del cliente
                fetch(`/casillero/edit/${id}`)
                    .then(response => response.json())
                    .then(casillero => {
                        // Llenar los campos del formulario con los datos obtenidos
                        document.getElementById('edit_nro_casillero').value = casillero.nro_casillero;
                        document.getElementById('edit_estado').value = casillero.estado;
                    })
                    .catch(error => {
                        console.error('Error al obtener los datos del casillero:', error);
                    });
            });
        </script>


    </main>
</x-layout>