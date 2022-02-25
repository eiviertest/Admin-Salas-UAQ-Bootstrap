<!-- Nav Admin -->
@can('Admin_Home')
    <li class="nav-item">
        @can('Admin_Reportes')
            <a @click="menu=1" class="nav-link" href="#">Reportes</a>
        @endcan
    </li>
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Cursos
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @can('Admin_Cursos')
                <a @click="menu=2" class="dropdown-item" href="#">Administrar Cursos</a>
            @endcan
            @can('Admin_Cursos_Crear')
                <a @click="menu=3" class="dropdown-item" href="#">Crear Cursos</a>
            @endcan
            @can('Admin_Cursos_Asistencia')
                <a @click="menu=4" class="dropdown-item" href="#">Asistencia a Cursos</a>
            @endcan
        </div>
    </li>
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Salas
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @can('Admin_Solicitudes')
                <a @click="menu=5" class="dropdown-item" href="#">Ver Solicitudes</a>
            @endcan
        </div>
    </li>
@endcan

<!-- Nav User -->
@can('User_Home')
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Salas
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @can('User_Salas_Solicitar')
                <a @click="menu=6" class="dropdown-item" href="#">Solicitar Sala</a>
            @endcan
            @can('User_Solicitudes_Ver')
                <a @click="menu=7" class="dropdown-item" href="#">Mis Solicitudes</a>
            @endcan
        </div>
    </li>
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Cursos
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @can('User_Cursos')
                <a @click="menu=8" class="dropdown-item" href="#">Enrolarse A Cursos</a>
            @endcan
            @can('User_Cursos_Asistencia')
                <a @click="menu=9" class="dropdown-item" href="#">Mis Asistencias</a>
            @endcan
        </div>
    </li>
@endcan