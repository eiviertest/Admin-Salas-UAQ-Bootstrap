/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faUserSecret } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(faUserSecret);

Vue.component('font-awesome-icon', FontAwesomeIcon);

Vue.config.productionTip = false;

require('./bootstrap');

window.Swal = require('sweetalert2')
window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('inicio', require('./components/Inicio.vue').default);
//Admin
Vue.component('reportes', require('./components/Admin/Reportes.vue').default);
Vue.component('crear-curso', require('./components/Admin/CrearCursos.vue').default);
Vue.component('solicitud-curso-persona', require('./components/Admin/SolicitudCursoPersona').default);
Vue.component('solicitudes-admin', require('./components/Admin/MostrarSolicitudes.vue').default);
Vue.component('areas', require('./components/Admin/Areas.vue').default);
Vue.component('salas', require('./components/Admin/Salas.vue').default);
// CRUD
Vue.component('crear', require('./components/CRUDArea/Crear.vue').default);
Vue.component('editar', require('./components/CRUDArea/Editar.vue').default);
Vue.component('mostrar', require('./components/CRUDArea/Mostrar.vue').default);
Vue.component('mostrar-salas', require('./components/CRUDSalas/MostrarSalas.vue').default);
//User
Vue.component('ver-cursos-user', require('./components/User/EnrolarseACursos.vue').default);
Vue.component('asistencia-cursos', require('./components/User/AsistenciaCursos.vue').default);
Vue.component('mis-solicitudes', require('./components/User/MisSolicitudes.vue').default);
Vue.component('solicitar-sala', require('./components/User/SolicitarSala.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        menu: 0
    }
});
