@extends('admin.app')

@section('template_title')
    Reportes
@endsection

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

</head>

<body id="page-top">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Reportes de uso</h1>
            <p class="mb-4">Reportes sobre el uso de cajones en los distintos eventos registrados en nuestra plataforma.</p>

            <!-- Content Row -->
            <div class="row">

                <!-- Donut Chart -->
                <div class="col-xl-10 col-lg-10">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Gráfica en dona</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="fecha">Fecha:</label>
                                <input type="date" class="form-control" id="fecha">
                            </div>
                            <div class="form-group">
                                <label for="hora">Hora:</label>
                                <input type="time" class="form-control" id="hora">
                            </div>
                            <button id="obtenerDatos" class="btn btn-primary">Obtener Datos</button>
                            <div class="chart-pie pt-4">
                                <canvas id="myPieChart"></canvas>
                                <span id="disponibilidadNumero"></span>
                            </div>
                            
                            <hr>
                            Cajones más utilizados durante los eventos.
                        </div>     
                    </div>
                </div>           

                <!-- Bar Chart -->
                <div class="col-xl-10 col-lg-10">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Grafica de barras</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-bar">
                                <canvas id="myBarChart"></canvas>
                            </div>
                            <hr>
                            <div class="input-group mb-3">
                                <input type="date" class="form-control" id="fecha">
                                <input type="time" class="form-control" id="hora">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="obtenerDatos">Obtener Datos</button>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="mb-2">Disponibilidad de los cajones de estacionamiento de una hora específica:</p>
                                <p class="font-weight-bold mb-0" id="disponibilidadTexto"></p>
                            </div>
                        </div>
                    </div>
                </div>                         

            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->

    <!-- Page level custom scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('libs/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('libs/sbadmin/js/sb-admin-2.min.js')}}"></script>
    <script src="{{asset('libs/sbadmin/js/demo/chart-pie-demo.js')}}"></script>
    <script src="{{asset('libs/sbadmin/js/demo/chart-bar-demo.js')}}"></script>

    <link href="{{asset('libs/sbadmin/css/sb-admin-2.min.css')}}" rel="stylesheet">

</body>

</html>
@endsection