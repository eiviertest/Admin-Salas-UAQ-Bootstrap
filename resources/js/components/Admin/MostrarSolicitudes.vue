<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header h4">Solicitudes de Salas</h4>
                    <div class="card-body">
                        <div class="vld-parent">
                            <loading :active.sync="isLoading"
                                    :can-cancel="false"
                                    :is-full-page="true"/>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col d-flex flex-row-reverse">
                                    <button class="btn btn-info" v-on:click="mostrarFiltros = !mostrarFiltros ">Filtros <font-awesome-icon icon="fa-solid fa-angle-down" /></button>
                                </div>
                            </div>
                            <div class="row" v-if="mostrarFiltros">
                                <div class="col-md-2 h5">
                                    <label class="form-control-label h5" for="text-input">Sala</label>
                                    <select required class="form-select" v-model="idSala">
                                        <option value="0" selected disabled>Seleccione una sala</option>
                                        <option :value="sala.idSala" v-text="sala.nomSala" v-for="sala in salas" :key="sala.idSala"></option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-control-label h5" for="text-input">Fecha</label>
                                    <input required type="date" v-model="fecha" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-control-label" for="text-input"><h5>Hora de inicio: *</h5></label>
                                    <input required type="time" v-model="horaIni" class="form-control" step="3600" min="08:00" max="19:00">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-control-label" for="text-input"><h5>Hora de Fin: *</h5></label>
                                    <input required type="time" v-model="horaFin" class="form-control" step="3600" min="08:00" max="20:00">                            
                                </div>
                                <div class="col-md-3 h5">
                                    <label class="form-control-label h5" for="text-input">Usuario</label>
                                    <select required class="form-select" v-model="idPersona">
                                        <option value="0" selected disabled>Seleccione un Usuario</option>
                                        <option :value="persona.idPer" v-text="persona.nombrePer" v-for="persona in personas" :key="persona.idPer"></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <table class="table">
                            <thead class="h5"> 
                                <tr>
                                    <th style="text-align: center" scope="col">Sala</th>
                                    <th style="text-align: center" scope="col">Fecha</th>
                                    <th style="text-align: center" scope="col">Hora de Inicio</th>
                                    <th style="text-align: center" scope="col">Hora de Finalización</th>
                                    <th style="text-align: center" scope="col">Estado</th>
                                    <th style="text-align: center" scope="col">Más Detalles</th>
                                    <th style="text-align: center" scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="h5">
                                <tr v-for="solicitud in solicitudes" :key="solicitud.idSol"> 
                                    <td align="center" v-text="solicitud.sala"></td>
                                    <td align="center" v-text="solicitud.fecha"></td>
                                    <td align="center" v-text="solicitud.horaIni"></td>
                                    <td align="center" v-text="solicitud.horaFin"></td>
                                    <td align="center" v-text="solicitud.estado"></td>
                                    <td >
                                        <button class="btn btn-outline-primary" v-on:click="verDetalle(solicitud.idSol)">Ver Detalles <font-awesome-icon icon="fa-solid fa-circle-info" /></button>
                                    </td>
                                    <td v-if="solicitud.estado == 'En proceso'">
                                        <button class="btn btn-primary" v-on:click="getDocumento(solicitud.uuid)">Mostrar Formato <font-awesome-icon icon="fa-solid fa-eye" /></button>
                                        <button class="btn btn-success" v-on:click="aceptarSolicitud(solicitud.idSol)">Aceptar  <font-awesome-icon icon="fa-solid fa-check" /></button>
                                        <button class="btn btn-danger" v-on:click="rechazarSolicitud(solicitud.idSol)">Rechazar <font-awesome-icon icon="fa-solid fa-ban" /></button>
                                    </td>
                                    <td v-else>
                                        <button class="btn btn-primary" v-on:click="getDocumento(solicitud.uuid)">Mostrar Formato <font-awesome-icon icon="fa-solid fa-eye" /></button>
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
                        <ModalSolicitud v-if="modalVerDetalle" :idSolicitud="idSolicitud" @closeModal="modalVerDetalle = false" @sucessUpdate="getSolicitudes(1)"></ModalSolicitud>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ModalSolicitud from './ModalSolicitud.vue';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    components: {
        Loading,
        ModalSolicitud
    },
    data() {
        return {
            solicitudes: [],
            salas: [],
            personas: [],
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
            isLoading: true,
            modalVerDetalle: false,
            idSolicitud : 0,
            mostrarFiltros: false,
            idSala : 0,
            fecha : '',
            horaIni : '',
            horaFin : '',
            idPersona : 0

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
            axios.get('/solicitud_admin?page=' + page, {
                params: {
                    fecha : me.fecha,
                    sala : me.idSala,
                    horaInicio : me.horaIni,
                    horaFin : me.horaFin,
                    persona : me.idPersona
                }
            }).then(function (response) {
                me.solicitudes = response.data.solicitudes.data;
                me.pagination = response.data.pagination;
                me.isLoading = false;
            }).catch(function (error) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Fallo en el sistema.'
                });
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
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Fallo en el sistema.'
                    });
            });
        },
        rechazarSolicitud(idSol){
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Una vez rechazada no se podrán revertir los cambios!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, rechazar registro!'
                }).then((result) => {
                if (result.isConfirmed) {
                    // Petición para eliminar el registro
                    let me = this;
                    axios.put('/solicitud',{
                            'idSol': idSol,
                            'idEst': 3,
                            }).then(function (response) {
                                me.getSolicitudes(1);
                                Swal.fire(
                                    'Rechazada!',
                                    'La solicitud ha sido rechazada correctamente.',
                                    'success'
                                )
                            }).catch( function (error) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'Fallo en el sistema.'
                                });
                        })
                        .catch(error=>{
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Fallo en el sistema.'
                            });
                        })
                }
            })
        },
        getDocumento(uuid){
            window.open('/solicitud_mostrar_formato/'+uuid, '_blank');
        },
        verDetalle(idSolicitud){
            this.modalVerDetalle = true;
            this.idSolicitud = idSolicitud;
        },
        getSalas(){
            let me = this;
            me.isLoading = true;
            axios.get('/catalogoSalas').then(response=>{
                me.salas = response.data.salas;
            })
            .catch(error=>{
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Fallo en el sistema.'
                });
            })
        },
        getPersonas(){
            let me = this;
            me.isLoading = true;
            axios.get('/catalogoPersonas').then(response=>{
                me.personas = response.data.personas;
            })
            .catch(error=>{
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Fallo en el sistema.'
                });
            })
        },
    },
    mounted() {
        this.getSalas();
        this.getPersonas();
        this.getSolicitudes(1);
    },
    watch: {
        fecha: function(val){
            this.isLoading = true;
            this.fecha = val;
            this.getSolicitudes(1);
        },
        idSala: function(val){
            this.isLoading = true;
            this.idSala = val;
            this.getSolicitudes(1);
        },
        idPersona: function(val){
            this.isLoading = true;
            this.idPersona = val;
            this.getSolicitudes(1);
        },
        horaIni: function(val){
            this.isLoading = true;
            this.horaIni = val;
            this.getSolicitudes(1);
        },
        horaFin: function(val){
            this.isLoading = true;
            this.horaFin = val;
            this.getSolicitudes(1);
        }
    }
}
</script>