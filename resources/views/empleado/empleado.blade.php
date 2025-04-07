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
                        <h2>Listado de Recepcionista</h2>
                    </div>

                    <div class="me-3 my-3 text-end">
                        <!-- Contenedor principal con flexbox -->
                        <div class="d-flex align-items-center">

                            <!-- Botón Agregar Cliente al mismo nivel que el formulario, con margen izquierdo -->
                            <button class="btn btn-primary ms-3" style="margin-left: 20px;" data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="fas fa-user-plus"></i> Agregar Recepcionista
                            </button>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre Completo</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Correo</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Telefono</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">C.I</th>


                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                    <tr>
                                        <td class="align-middle text-center">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $user->nombre_completo }}</h6>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $user->email}}</h6>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $user->telefono }}</h6>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $user->ci }}</h6>
                                            </div>
                                        </td>

                                        <td class="align-middle text-center">
                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $user->id }}">
                                                <i class="fas fa-edit"></i> Editar
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay Recepcionistas registrados.</td>
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
                        <h5 class="modal-title" id="addModalLabel">Agregar Nuevo Recepcionista</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario de agregar paquete -->
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf

                            <!-- Nombre del usuario -->
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <!-- Nombre del usuario -->
                            <div class="form-group">
                                <label for="paterno">Paterno</label>
                                <input type="text" name="paterno" class="form-control" required>
                            </div>
                            <!-- Nombre del usuario -->
                            <div class="form-group">
                                <label for="materno">Materno</label>
                                <input type="text" name="materno" class="form-control" required>
                            </div>
                            <!-- Nombre del usuario -->
                            <div class="form-group">
                                <label for="telefono">Telefono</label>
                                <input type="text" name="telefono" class="form-control" required>
                            </div>
                            <!-- Nombre del usuario -->
                            <div class="form-group">
                                <label for="ci">C.I</label>
                                <input type="text" name="ci" class="form-control" required>
                            </div>

                            <!-- Correo electrónico -->
                            <div class="form-group">
                                <label for="email">Correo electrónico</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <!-- Contraseña -->
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div class="form-group">
                                <label for="password_confirmation">Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Editar Recepcionista -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Editar Recepcionista</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario de editar recepcionista -->
                        <form action="" method="POST" id="editForm">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_paterno" class="form-label">Apellido Paterno</label>
                                <input type="text" class="form-control" id="edit_paterno" name="paterno" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_materno" class="form-label">Apellido Materno</label>
                                <input type="text" class="form-control" id="edit_materno" name="materno" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_ci" class="form-label">C.I.</label>
                                <input type="text" class="form-control" id="edit_ci" name="ci" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="edit_telefono" name="telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="edit_email" name="email" required>
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
            // Llenar el formulario de editar con los datos del usuario
            const editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // El botón que activó el modal
                const id = button.getAttribute('data-id'); // Obtener el ID del usuario desde el atributo 'data-id'
                const form = document.getElementById('editForm');
                form.action = '/recepcionista-update/' + id; // Establecer la acción del formulario con la ruta correcta

                // Hacer la solicitud Fetch para obtener los datos del usuario
                fetch(`/recepcionista/edit/${id}`)
                    .then(response => response.json())
                    .then(usuario => {
                        // Llenar los campos del formulario con los datos obtenidos
                        document.getElementById('edit_name').value = usuario.name;
                        document.getElementById('edit_paterno').value = usuario.paterno;
                        document.getElementById('edit_materno').value = usuario.materno;
                        document.getElementById('edit_ci').value = usuario.ci;
                        document.getElementById('edit_telefono').value = usuario.telefono;
                        document.getElementById('edit_email').value = usuario.email;
                    })
                    .catch(error => {
                        console.error('Error al obtener los datos del usuario:', error);
                    });
            });
        </script>


    </main>
</x-layout>