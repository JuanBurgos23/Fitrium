<!-- resources/views/clientes.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Asistencia</title>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


</head>
@extends('layouts.app')
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
                        <h2 class="mb-0">Historial de Asistencia</h2>

                    </div>

                    <div class="me-3 my-3 text-end">
                        <!-- Contenedor principal con flexbox -->
                        <div class="d-flex align-items-center">


                            <!-- Formulario de búsqueda con el input y botón en una fila -->
                            <form method="GET" action="{{ route('asistencia.historial') }}" class=" mb-0 d-flex align-items-center me-2 w-100">
                                <input type="text" name="search" value="{{ old('search', $search) }}" placeholder="Buscar por CI o Apellido Paterno" class="form-control flex-grow-1" style="max-width: 250px;">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </form>

                            <a href="{{ route('mostrar_asistencia') }}" class="btn btn-secondary mb-3">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>


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
                                        <th class="text-center">Hora Salida</th>
                                        <th class="text-center">Casillero</th>
                                        <th class="text-center">Estado</th>

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
                                        <td class="text-center">{{ $cliente->hora_salida ?? '-' }}</td>
                                        <td class="text-center">{{ $cliente->casillero->nro_casillero ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $cliente->estado === 'Activo' ? 'badge-success' : 'badge-primary' }}">
                                                {{ ucfirst($cliente->estado) }}
                                            </span>
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


        <script>

        </script>

    </main>
</x-layout>