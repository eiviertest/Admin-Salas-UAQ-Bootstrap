<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detallado de solicitudes</title>
    <!--<link href="{{ public_path('css/app.css') }}" rel="stylesheet" type="text/css">-->
<body>
    <div>
        <h2>Detallado de solicitudes</h2>
        <h3>Área: {{$area->nomArea}}</h3>
    </div>
    <table class="table table-bordered table-striped table-sm">
        <thead class="thead">
            <tr>
                <th>Nombre de persona</th>
                <th>Estado</th>
                <th>Sala</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($solicitudes as $solicitud)
            <tr>
                <td>{{$solicitud->nombre}}</td>
                <td>{{$solicitud->nomEst}}</td>
                <td>{{$solicitud->nomSala}}</td>
            </tr>
            @endforeach                                
        </tbody>
    </table>
    <div>
        <p><strong>Total de solicitudes: </strong>{{count($solicitudes)}}</p>
    </div>
</body>
</html>