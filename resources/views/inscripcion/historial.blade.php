<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl">
            <!-- Navbar content -->
        </nav>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <h2>Historial de Inscripciones</h2>
                </div>
                <!-- Botón Volver -->
                <a href="{{ route('mostrar_inscripcion') }}" class="btn btn-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>


                <!-- Formulario de búsqueda y filtro por fechas -->
                <div class="mb-3">
                    <form method="GET" action="{{ route('historial_inscripciones') }}" class="row g-3">
                        <!-- Campo de búsqueda -->
                        <div class="col-md-3">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por CI o Apellido Paterno" class="form-control">
                        </div>
                        <!-- Rango de fechas -->
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="fecha_fin" value="{{ request('fecha_fin') }}">
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <!-- Botón para filtrar -->
                            <button class="btn btn-primary" type="submit" title="Filtrar">
                                <i class="fas fa-filter"></i>
                            </button>

                            <!-- Botón para limpiar filtros -->
                            <a href="{{ route('historial_inscripciones') }}" class="btn btn-warning" title="Limpiar">
                                <i class="fas fa-times"></i>
                            </a>

                            <!-- Botón para exportar PDF -->
                            <a href="{{ route('historial_inscripciones.pdf', ['search' => request('search'), 'fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')]) }}" class="btn btn-danger" title="Exportar PDF">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Tabla de inscripciones -->
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inscripciones as $inscripcion)
                                <tr>
                                    <td class="align-middle text-center">
                                        <h6 class="mb-0 text-sm">{{ $inscripcion->cliente->nombre_completo }}</h6>
                                    </td>
                                    <td class="align-middle text-center">
                                        <h6 class="mb-0 text-sm">{{ $inscripcion->cliente->ci }}</h6>
                                    </td>
                                    <td class="align-middle text-center">
                                        <h6 class="mb-0 text-sm">{{ $inscripcion->paquete->nombre }}</h6>
                                    </td>
                                    <td class="align-middle text-center">
                                        <h6 class="mb-0 text-sm">{{ $inscripcion->fecha_expiracion }}</h6>
                                    </td>
                                    <td class="align-middle text-center">
                                        <h6 class="mb-0 text-sm estado" data-estado="{{ $inscripcion->estado }}">
                                            <label class="badge 
                                            @if($inscripcion->estado == 'Vigente') badge-success 
                                            @elseif($inscripcion->estado == 'Caducado') badge-danger 
                                            @elseif($inscripcion->estado == 'Abandonado') badge-warning 
                                            @else badge-primary
                                            @endif">
                                                {{ $inscripcion->estado }}
                                            </label>
                                        </h6>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $inscripciones->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>