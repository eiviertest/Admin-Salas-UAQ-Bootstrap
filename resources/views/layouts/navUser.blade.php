<!-- Nav User -->
<li class="nav-item">
    <a @click="menu=6" class="nav-link" href="#">Ver Cursos</a>
</li>
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        Salas User
    </a>

    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a @click="menu=7" class="dropdown-item" href="#">Mis Solicitudes</a>
        <a @click="menu=8" class="dropdown-item" href="#">Solicitar Sala</a>
    </div>
</li>