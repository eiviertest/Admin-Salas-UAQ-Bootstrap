<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concentrado por curso</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.875rem;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;           
        }
        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }
        
        .table-bordered {
            border: 1px solid #c2cfd6;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 2px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c2cfd6;
        }
        th, td {
            display: table-cell;
            vertical-align: inherit;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }
        .detalle_curso {
            display: table;
            width: 100%;
            max-width: 100%;
            background-color: transparent;
            border-collapse: collapse;
        }
    </style>
<body>
    <div>
        <center><h2>Datos del curso</h2></center>
        <table class="detalle_curso">
            <thead>
                <tr>
                    <th>Nombre: {{$datos_curso->nomCur}}</th>
                    <th>Impartido en la sala: {{$datos_curso->nomSala}}</th>
                </tr>
                <tr>
                    <th>Fecha de termino: {{$datos_curso->fecFinCur}}</th>
                    <th>Fecha de inicio: {{$datos_curso->fecInCur}}</th>
                </tr>
            </thead>
        </table>
    </div>
    <br>
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
    <div>
        <p class="derecha"><strong>Total de personas: </strong>{{count($personas)}}</p>
    </div>
</body>
</html>