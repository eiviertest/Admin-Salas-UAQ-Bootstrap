<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header">Solicitudes de salas</h4>
                    <div class="card-body">
                        <div class="vld-parent">
                            <loading :active.sync="isLoading"
                                    :can-cancel="false"
                                    :is-full-page="true"/>
                        </div>
                        <table class="table">
                            <thead> 
                                <tr>
                                    <th scope="col">Sala</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Hora de inicio</th>
                                    <th scope="col">Hora de finalización</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="solicitud in solicitudes" :key="solicitud.idSol"> 
                                    <td v-text="solicitud.sala"></td>
                                    <td v-text="solicitud.fecha"></td>
                                    <td v-text="solicitud.horaIni"></td>
                                    <td v-text="solicitud.horaFin"></td>
                                    <td v-text="solicitud.estado"></td>
                                    <td v-if="solicitud.estado == 'En proceso'">
                                        <button class="btn btn-primary" v-on:click="aceptarSolicitud(solicitud.idSol)">Aceptar</button>
                                        <button class="btn btn-danger" v-on:click="rechazarSolicitud(solicitud.idSol)">Rechazar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Anterior</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click="cambiarPagina(pagination.current_page + 1)">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    components: {
        Loading
    },
    data() {
        return {
            solicitudes: [],
            errores: [],
            pagination: {
                'total': 0, 
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0
            },
            offset: 2,
            isLoading: true
        }
    },
    computed: {
        isActived: function(){
            return this.pagination.current_page;
        },
        pagesNumber: function(){
            if(!this.pagination.to){
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if(from < 1){
                from = 1;
            }
            var to = from + (this.offset * 2);
            if(to >= this.pagination.last_page){
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while(from <= to){
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },
    methods: {
        cambiarPagina(page){
            let me = this;
            me.pagination.current_page = page;
            me.isLoading = true;
            me.getSolicitudes(page);
        },
        getSolicitudes(page) {
            let me = this;
            axios.get('/solicitud_admin?page=' + page).then(function (response) {
                me.solicitudes = response.data.solicitudes.data;
                me.pagination = response.data.pagination;
                me.isLoading = false;
            }).catch(function (error) {
                me.errores = error.data;
            });
        },
        aceptarSolicitud(idSol){
            let me = this;
            me.isLoading = true;
            axios.put('/solicitud',{
                    'idSol': idSol,
                    'idEst': 2
                }).then(function (response) {
                    me.getSolicitudes(1);
                }).catch( function (error) {
                    me.errores = error.data;
            });
        },
        rechazarSolicitud(idSol){
            let me = this;
            me.isLoading = true;
            axios.put('/solicitud',{
                    'idSol': idSol,
                    'idEst': 3,
                }).then(function (response) {
                    me.getSolicitudes(1);
                }).catch( function (error) {
                    me.errores = error.data;
            });
        }
    },
    mounted() {
        this.getSolicitudes(1);
    }
}
</script>