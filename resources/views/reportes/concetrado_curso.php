<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos impartidos</title>
    <!--<link href="{{ public_path('css/app.css') }}" rel="stylesheet" type="text/css">-->
<body>
    <div>
        <h2>Concentrado por curso</h2>
        <h3><span class="derecha">{{$curso}}</span></h3>
    </div>
    <table class="table table-bordered table-striped table-sm">
        <thead class="thead">
            <tr>
                <th>Nombre de curso</th>
                <th>Fecha de inicio</th>
                <th>Fecha de terminación</th>
                <th>Cupo de curso</th>
                <th>Sala</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursos as $curso)
            <tr>
                <td>{{$curso->nomCur}}</td>
                <td>{{$curso->fecInCur}}</td>
                <td>{{$curso->fecFinCur}}</td>
                <td>{{$curso->cupCur}}</td>
                <td>{{$curso->nomSala}}</td>
            </tr>
            @endforeach                                
        </tbody>
    </table>
    <div class="izquierda">
        <p><strong>Total de cursos: </strong>{{count($cursos)}}</p>
    </div>
</body>
</html>