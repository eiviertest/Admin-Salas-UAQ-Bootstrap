<!-- Nav Admin -->
<li class="nav-item">
    <a @click="menu=1" class="nav-link" href="#">Reportes</a>
</li>
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        Cursos
    </a>

    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a @click="menu=2" class="dropdown-item" href="#">Ver Cursos</a>
        <a @click="menu=3" class="dropdown-item" href="#">Crear Cursos</a>
        <a @click="menu=4" class="dropdown-item" href="#">Crear Multiples Cursos</a>
    </div>
</li>
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        Salas
    </a>

    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a @click="menu=5" class="dropdown-item" href="#">Ver Solicitudes</a>
    </div>
</li>