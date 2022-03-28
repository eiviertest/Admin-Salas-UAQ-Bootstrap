<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos impartidos</title>
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
    </style>
<body>
    <div>
        <center><h2>Cursos impartidos</h2></center>
        <h3><span>{{$semestre}}</span></h3>
    </div>
    <table class="table table-bordered table-striped table-sm">
        <thead class="thead">
            <tr>
                <th>Nombre de curso</th>
                <th>Instructor</th>
                <th>Fecha de inicio</th>
                <th>Fecha de terminación</th>
                <th>Hora de inicio</th>
                <th>Hora de termino</th>
                <th>Cupo de curso</th>
                <th>Sala</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursos as $curso)
            <tr>
                <td>{{$curso->nomCur}}</td>
                <td>{{$curso->instructor}}</td>
                <td>{{$curso->fecInCur}}</td>
                <td>{{$curso->fecFinCur}}</td>
                <td>{{$curso->horIn}}</td>
                <td>{{$curso->horFin}}</td>
                <td>{{$curso->cupCur}}</td>
                <td>{{$curso->nomSala}}</td>
            </tr>
            @endforeach                                
        </tbody>
    </table>
    <div>
        <p class="derecha"><strong>Total de cursos: </strong>{{count($cursos)}}</p>
    </div>
</body>
</html>