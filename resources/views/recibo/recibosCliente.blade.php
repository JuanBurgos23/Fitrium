<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card my-4">

                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <h2>Historial de Inscripciones de {{ $cliente->nombre_completo }}</h2>
                    </div>
                    <div class="me-3 my-3 text-end">
                        <!-- Contenedor principal con flexbox -->
                        <div class="d-flex align-items-center">
                            <!-- Botón Volver -->
                            <a href="{{ route('mostrar_inscripcion') }}" class="btn btn-secondary mb-3">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <!-- Botón para cambiar orden -->
                            <a href="{{ route('historial_recibos_cliente', ['id' => $cliente->id, 'orden' => $orden === 'asc' ? 'desc' : 'asc']) }}"
                                class="btn btn-primary mb-3">
                                <i class="fas fa-sort"></i> Ordenar por Fecha
                                ({{ $orden === 'asc' ? 'Descendente' : 'Ascendente' }})
                            </a>
                        </div>
                    </div>

                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">Fecha de Pago</th>
                                        <th class="text-center">Concepto</th>
                                        <th class="text-center">A cuenta</th>
                                        <th class="text-center">Debe</th>
                                        <th class="text-center">Total a Cancelar</th>
                                        <th class="text-center">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recibos as $recibo)
                                    <tr>
                                        <td class="text-center">{{ $recibo->fecha_pago }}</td>
                                        <td class="text-center">{{ $recibo->concepto }}</td>
                                        <td class="text-center">{{ $recibo->a_cuenta }} Bs.</td>
                                        <td class="text-center">{{ $recibo->saldo }} Bs.</td>
                                        <td class="text-center">{{ $recibo->total }} Bs.</td>
                                        <td class="text-center">
                                            <label class="badge 
                                    @if($recibo->estado == 'Pagado') badge-success 
                                    @elseif($recibo->estado == 'Debe') badge-danger 
                                    @else badge-primary 
                                    @endif">
                                                {{ $recibo->estado }}
                                            </label>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay recibos registrados para este cliente.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Agregar paginación -->
                            <div class="mt-3">
                                {{ $recibos->appends(['orden' => $orden])->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>
</x-layout>