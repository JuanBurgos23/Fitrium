<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl">
            <!-- Navbar content -->
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="col-12">

                <div class="container">
                    <h2>Historial de Inscripciones de {{ $cliente->nombre_completo }}</h2>
                    <a href="{{ route('exportar_historial_pdf', $cliente->id) }}" class="btn btn-danger mb-3">
                        <i class="fas fa-file-pdf"></i> Exportar PDF
                    </a>
                    <a href="{{ route('mostrar_inscripcion') }}" class="btn btn-secondary mb-3">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Paquete</th>
                                <th>Fecha de Inscripción</th>
                                <th>Fecha de Expiración</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cliente->inscripciones as $inscripcion)
                            <tr>
                                <td>{{ $inscripcion->paquete->nombre }}</td>
                                <td>{{ $inscripcion->fecha_inicio }}</td>
                                <td>{{ $inscripcion->fecha_expiracion }}</td>
                                <td>{{ $inscripcion->estado }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

</x-layout>