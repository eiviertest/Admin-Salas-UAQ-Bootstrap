<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concentrado por curso</title>
    <!--<link href="{{ public_path('css/app.css') }}" rel="stylesheet" type="text/css">-->
<body>
    <div>
        <h2>Datos del curso</h2>
        <h3>Nombre: {{$datos_curso->nomCur}}</h3>
        <h3>Fecha de inicio: {{$datos_curso->fecInCur}}</h3>
        <h3>Fecha de termino: {{$datos_curso->fecFinCur}}</h3>
        <h3>Impartido en la sala: {{$datos_curso->nomSala}}</h3>
    </div>
    <table class="table table-bordered table-striped table-sm">
        <thead class="thead">
            <tr>
                <th>Nombre de la persona</th>
                <th>Área/Facultad/Institución</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($personas as $persona)
            <tr>
                <td>{{$persona->nombre}}</td>
                <td>{{$persona->nomArea}}</td>
            </tr>
            @endforeach                                
        </tbody>
    </table>
</body>
</html>