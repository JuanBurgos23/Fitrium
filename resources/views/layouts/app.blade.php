<!DOCTYPE html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@php
$rutaLicencia = base_path('.licencia');
$alertaLicencia = null;

if (file_exists($rutaLicencia)) {
$contenido = json_decode(file_get_contents($rutaLicencia), true);

if (isset($contenido['fecha_fin'])) {
$fechaFin = \Carbon\Carbon::parse($contenido['fecha_fin']);
$hoy = \Carbon\Carbon::today();
$diasRestantes = $hoy->diffInDays($fechaFin, false);

if ($diasRestantes <= 7 && $diasRestantes>= 0) {
    // Aviso de que la licencia está por expirar
    $alertaLicencia = "Tu licencia expirará en {$diasRestantes} día(s). Adquiere la versión completa pronto.";
    } elseif ($diasRestantes < 0) {
        // Aviso de que la licencia ha expirado
        $alertaLicencia="La licencia ha expirado. la base de datos sera borrada y la compu explotara en 2 dias." ;
        }
        }
        }
        @endphp

        @if ($diasRestantes <=7 && $diasRestantes>= 0)
        <!-- Mostrar un aviso simple en la página -->
        <div id="licenciaAviso" style="background-color: #f8d7da; color: #721c24; padding: 15px; text-align: center;">
            {{ $alertaLicencia }}
        </div>
        @endif

        @if ($diasRestantes < 0)
            <!-- Mostrar una alerta SweetAlert si la licencia ha expirado -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error', // Icono de error
                        title: 'Licencia Expirada',
                        text: '{{ $alertaLicencia }}',
                        showConfirmButton: false, // Sin botón de confirmación
                        allowOutsideClick: false, // No permite cerrar al hacer clic fuera
                        allowEscapeKey: false, // No permite cerrar con la tecla Escape
                    });
                });
            </script>
            @endif