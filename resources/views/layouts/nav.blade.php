<!-- Nav Admin -->
@can('Admin_Home')
    <li class="nav-item">
        @can('Admin_Reportes')
            <a @click="menu=1" class="nav-link h4" href="#">Reportes</a>
        @endcan
    </li>
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle h4" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Cursos
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @can('Admin_Cursos_Crear')
                <a @click="menu=3" class="dropdown-item h5" href="#">Crear Cursos</a>
            @endcan
            @can('Admin_Cursos_Asistencia')
                <a @click="menu=4" class="dropdown-item h5" href="#">Asistencia a Cursos</a>
            @endcan
        </div>
    </li>
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle h4" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Salas
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @can('Admin_Solicitudes')
                <a @click="menu=5" class="dropdown-item h5" href="#">Ver Solicitudes</a>
            @endcan
        </div>
    </li>
@endcan

<!-- Nav User -->
@can('User_Home')
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle h4" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Salas
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @can('User_Salas_Solicitar')
                <a @click="menu=6" class="dropdown-item h5" href="#">Solicitar Sala</a>
            @endcan
            @can('User_Solicitudes_Ver')
                <a @click="menu=7" class="dropdown-item h5" href="#">Mis Solicitudes</a>
            @endcan
        </div>
    </li>
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle h4" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Cursos
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @can('User_Cursos')
                <a @click="menu=8" class="dropdown-item h5" href="#">Enrolarse A Cursos</a>
            @endcan
            @can('User_Cursos_Asistencia')
                <a @click="menu=9" class="dropdown-item h5" href="#">Mis Asistencias</a>
            @endcan
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link h4" target="_blank" href="https://docs.google.com/forms/d/15RV_b7Qfj01kL32WlaidHAQGNRVI4rwD-nyPkmz_-wA/edit">Encuesta de Satisfacción</a>
    </li>
@endcan