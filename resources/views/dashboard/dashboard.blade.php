<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl">
            <!-- Navbar content -->
        </nav>
        <!-- End Navbar -->

        <style>
            .highcharts-figure,
            .highcharts-data-table table {
                min-width: 320px;
                max-width: 800px;
                margin: 1em auto;
            }

            .highcharts-data-table table {
                font-family: Verdana, sans-serif;
                border-collapse: collapse;
                border: 1px solid rgb(48, 45, 45);
                margin: 10px auto;
                text-align: center;
                width: 100%;
                max-width: 500px;
                background-color: #333 !important;
                /* Fondo oscuro para la tabla */
            }

            .highcharts-data-table caption {
                padding: 1em 0;
                font-size: 1.2em;
                color: #fff !important;
                /* Color de texto blanco para contraste */
            }

            .highcharts-data-table th {
                font-weight: 600;
                padding: 0.5em;
                background-color: #444 !important;
                /* Fondo oscuro para las cabeceras */
                color: #fff !important;
                /* Texto blanco para las cabeceras */
            }

            .highcharts-data-table td,
            .highcharts-data-table th,
            .highcharts-data-table caption {
                padding: 0.5em;
            }

            .highcharts-data-table thead tr,
            .highcharts-data-table tr:nth-child(even) {
                background: rgb(55, 55, 55) !important;
                /* Fondo oscuro para las filas pares */
            }

            .highcharts-data-table tr:nth-child(odd) {
                background: rgb(44, 44, 44) !important;
                /* Fondo oscuro para las filas impares */
            }

            .highcharts-data-table tr:hover {
                background: rgb(51, 51, 51) !important;
                /* Fondo oscuro cuando pasas el mouse sobre una fila */
            }

            .highcharts-description {
                margin: 0.3rem 10px;
                color: #fff !important;
                /* Cambiar el color del texto de la descripción a blanco */
            }

            .grafica-ingresos-figure,
            .highcharts-data-table table {
                min-width: 310px;
                max-width: 800px;
                margin: 1em auto;
            }

            #grafica-ingresos-container {
                height: 400px;
            }

            .grafica-ingresos-descripcion {
                margin: 0.3rem 10px;
                font-size: 1rem;
                color: #fff;
            }
        </style>

        <!-- Contenido Principal -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <!-- Total Clientes -->
                    <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h3 class="mb-0">{{ $totalClientes }}</h3>
                                    <div class="icon icon-box-primary">
                                        <span class="mdi mdi-account-multiple icon-item"></span>
                                    </div>
                                </div>
                                <h6 class="text-muted font-weight-normal">Total de Clientes</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Clientes Activos -->
                    <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h3 class="mb-0">{{ $clientesActivos }}</h3>
                                    <div class="icon icon-box-success">
                                        <span class="mdi mdi-account-check icon-item"></span>
                                    </div>
                                </div>
                                <h6 class="text-muted font-weight-normal">Clientes Activos</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Ingresos de Hoy -->
                    <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h3 class="mb-0">{{ number_format($ingresosHoy, 2) }} Bs.</h3>
                                    <div class="icon icon-box-warning">
                                        <span class="mdi mdi-cash-multiple icon-item"></span>
                                    </div>
                                </div>
                                <h6 class="text-muted font-weight-normal">Ingresos de Hoy</h6>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="col-lg-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Grafico Torta</h4>
                                        <figure class="highcharts-figure">
                                            <div id="container"></div>
                                            <p class="grafica-ingresos-descripcion">
                                                Este gráfico muestra el porcentaje de cada paquete mas inscrito.
                                            </p>
                                        </figure>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Grafico Columna</h4>
                                        <figure class="grafica-ingresos-figure">
                                            <div id="grafica-ingresos-container"></div>
                                            <p class="grafica-ingresos-descripcion">
                                                Este gráfico muestra los ingresos por mes durante el año actual.
                                            </p>
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>
            <script src="https://code.highcharts.com/modules/export-data.js"></script>
            <script src="https://code.highcharts.com/modules/accessibility.js"></script>


            <script>
                (function(H) {
                    H.seriesTypes.pie.prototype.animate = function(init) {
                        const series = this,
                            chart = series.chart,
                            points = series.points,
                            {
                                animation
                            } = series.options,
                            {
                                startAngleRad
                            } = series;

                        function fanAnimate(point, startAngleRad) {
                            const graphic = point.graphic,
                                args = point.shapeArgs;

                            if (graphic && args) {
                                graphic
                                    .attr({
                                        start: startAngleRad,
                                        end: startAngleRad,
                                        opacity: 1
                                    })
                                    .animate({
                                        start: args.start,
                                        end: args.end
                                    }, {
                                        duration: animation.duration / points.length
                                    }, function() {
                                        if (points[point.index + 1]) {
                                            fanAnimate(points[point.index + 1], args.end);
                                        }
                                        if (point.index === series.points.length - 1) {
                                            series.dataLabelsGroup.animate({
                                                    opacity: 1
                                                },
                                                void 0,
                                                function() {
                                                    points.forEach(point => {
                                                        point.opacity = 1;
                                                    });
                                                    series.update({
                                                        enableMouseTracking: true
                                                    }, false);
                                                    chart.update({
                                                        plotOptions: {
                                                            pie: {
                                                                innerSize: '40%',
                                                                borderRadius: 8
                                                            }
                                                        }
                                                    });
                                                });
                                        }
                                    });
                            }
                        }

                        if (init) {
                            points.forEach(point => {
                                point.opacity = 0;
                            });
                        } else {
                            fanAnimate(points[0], startAngleRad);
                        }
                    };
                }(Highcharts));

                // Datos de los paquetes más inscritos
                let paquetesData = @json($paquetesData);

                Highcharts.chart('container', {
                    chart: {
                        type: 'pie'
                    },
                    title: {
                        text: 'Paquetes más Inscritos'
                    },
                    subtitle: {
                        text: 'FITRIUM FITNESS - CLUB'
                    },
                    tooltip: {
                        headerFormat: '',
                        pointFormat: '<span style="color:{point.color}">\u25cf</span> ' +
                            '{point.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            borderWidth: 2,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b><br>{point.percentage}%',
                                distance: 20
                            }
                        }
                    },
                    series: [{
                        enableMouseTracking: false,
                        animation: {
                            duration: 2000
                        },
                        colorByPoint: true,
                        data: paquetesData
                    }]
                });

                Highcharts.chart('grafica-ingresos-container', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Ingresos mensuales'
                    },
                    subtitle: {
                        text: 'FITRIUM FITNESS - CLUB'
                    },
                    xAxis: {
                        categories: [
                            'Enero', 'Febrero', 'Marzo', 'Abril',
                            'Mayo', 'Junio', 'Julio', 'Agosto',
                            'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                        ],
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Ingresos (Bs.)'
                        }
                    },
                    tooltip: {
                        valueSuffix: ' Bs.'
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: 'Ingresos',
                        data: @json($ingresosPorMes)
                    }]
                });
            </script>


    </main>
</x-layout>