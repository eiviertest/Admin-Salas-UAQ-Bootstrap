<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header">Solicitar Sala</h4>

                    <div class="card-body">
                        <div class="row">
                            <form method="post" @submit.prevent="registrarSolicitud()" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input"><h5>Sala A Solicitar: *</h5></label>
                                    <select @change="getEventos()" required class="form-select" v-model="solicitud.idSala">
                                        <option value="0" selected disabled>Seleccione una sala...</option>
                                        <option :value="sala.idSala" v-text="sala.nomSala" v-for="sala in salas" :key="sala.idSala"></option>
                                    </select>
                                    <div v-if="errorSelect" class="alert alert-warning d-flex align-items-center" role="alert">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                        </svg>
                                        <div>
                                            Seleccione una Sala por favor.
                                        </div>
                                    </div>
                                    <br>
                                    <label class="form-control-label" for="text-input"><h5>Fecha: *</h5></label>
                                    <input @change="getEventos()" required type="date" v-model="solicitud.fecha" class="form-control" :min="dateFormat">
                                    <span class="is-invalid" v-if="errores && errores['solicitud.fecha']">
                                        <strong>{{ errores['solicitud.fecha'][0] }}</strong>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input"><h5>Hora de inicio: *</h5></label>
                                    <input @change="getEventos()" required type="time" v-model="solicitud.horaIni" class="form-control" step="3600" min="08:00" max="19:00">
                                    <span class="is-invalid" v-if="errores && errores['solicitud.horaIni']">
                                        <strong>{{ errores['solicitud.horaIni'][0] }}</strong>
                                    </span> 
                                    <br>
                                    <label class="form-control-label" for="text-input"><h5>Hora de Fin: *</h5></label>
                                    <input @change="getEventos()" required type="time" v-model="solicitud.horaFin" class="form-control" step="3600" :min="solicitud.horaIni" max="20:00">
                                    <span class="is-invalid" v-if="errores && errores['solicitud.horaFin']">
                                        <strong>{{ errores['solicitud.horaFin'][0] }}</strong>
                                    </span>
                                    <br>                             
                                </div>
                                <div class="col-md-4">
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <font-awesome-icon icon="fa-solid fa-circle-info fa-2xl" />
                                        En caso de no encontrar una sala disponible para su solicitud, despues de varios intentos.
                                        <p>Puede llamar a el <strong>Centro de Computo Academico - UAQ. Telefono: 1921200  Extensión: 3271 ó 3270.</strong></p>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row form-group">
                                <div class="col-md-8">
                                    <label class="form-control-label"><h5><font-awesome-icon icon="fa-solid fa-file-invoice" /> Formato de Solicitud: *</h5></label>
                                    <input required accept="application/pdf" class="form-control" type="file" id="inputFormSol" @change="seleccionarArchivo">
                                    <br>
                                    <div v-if="errorFile" class="alert alert-warning d-flex align-items-center" role="alert">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                        </svg>
                                        <div>
                                            El tipo de archivo es incorrecto, seleccione un <strong>PDF</strong> por favor.
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary">Solicitar Sala <font-awesome-icon icon="fa-solid fa-house-laptop" /></button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <font-awesome-icon icon="fa-solid fa-circle-info fa-2xl" />
                                        <strong>Recuerda</strong> que cada solicitud de sala debe de generarse con tres dias de antelacion como minimo.
                                    </div>
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <font-awesome-icon icon="fa-solid fa-circle-info fa-2xl" />
                                        <strong>Recuerda</strong> que en el calendario de abajo puedes visualizar las fechas en las cuales estan ocupadas las salas.
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row form-group">
                                
                            </div>
                        </form>
                        </div>
                        <br>
                        <div class="row">
                            <label class="form-control-label h2">Eventos</label>
                            <FullCalendar :options="calendarOptions"/>
                        </div>
                        <div class="vld-parent">
                        <loading :active.sync="isLoading"
                                :can-cancel="false"
                                :is-full-page="true"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import '@fullcalendar/core/vdom'
import esLocale from '@fullcalendar/core/locales/es';
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import moment from 'moment'

export default {
    components: {
        FullCalendar,
        Loading
    },
    data(){
        return {
            solicitud:{
                'idSala': 0,
                'fecha': '',
                'horaIni': '',
                'horaFin': '',
                'rutaSol': null
            },
            salas: [],
            dateFormat : '',
            errores: {},
            errores: [],
            errorFile: false,
            errorSelect:false,
            errorForm:false,
            calendarOptions: {
                plugins: [ dayGridPlugin ],
                initialView: 'dayGridMonth',
                events: [],
                locales: [esLocale],
                locale: 'es',
            },          
            isLoading: true,
            
        }
    },
    methods: {
        getEventos(){
            let me = this;
            axios.get('/calendar',{
                params: {
                    sala : me.solicitud.idSala,
                    fecha: me.solicitud.fecha,
                    horaInicio: me.solicitud.horaIni,
                    horaFin: me.solicitud.horaFin
                }
            }).then(response=>{
                me.calendarOptions.events = response.data.eventos;
            })
            .catch(error=>{
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Fallo en el sistema.'
                });
            })
        },
        getSalas(){
            let me = this;
            axios.get('/catalogoSalas').then(response=>{
                me.salas = response.data.salas;
                me.isLoading = false;
            })
            .catch(error=>{
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Fallo en el sistema.'
                });
            })
        },
        verificarDatos(){
            this.errorSelect = false;
            if(this.solicitud.idSala == 0){
                this.errorSelect = true;
                this.errorForm = true;
            }else{
                if(this.errorFile == true){
                    this.errorForm = true;
                }else{
                    this.errorForm = false;
                }
            }
        },
        seleccionarArchivo(e){
            this.errorFile = false;
            if(e.target.files[0].type == 'application/pdf'){
                this.solicitud.rutaSol = e.target.files[0];
            }else{
                this.errorFile = true;
            }
        },
        registrarSolicitud(){
            this.errorForm = false;
            this.verificarDatos();
            if(this.errorForm == false){
                let me = this;
                me.isLoading = true;
                let solicitudForm = new FormData();
                for(let key in this.solicitud){
                    solicitudForm.append(key, this.solicitud[key]);
                }
                axios.post('/solicitud',solicitudForm).then(response=>{
                    if(response.data.code == 1) {
                        me.errores = {};
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Su solicitud se ha registrado con éxito.',
                            text: 'Puede ver el estado en "Mis Solicitudes".'
                        });
                        me.resetVariables();
                        me.getEventos();
                        me.isLoading = false;
                    }else{
                        if(response.data.code == 2){
                            Swal.fire({
                                position: 'center',
                                icon: 'warning',
                                title: 'Su solicitud no se ha registrado.',
                                text: 'Se encontraron inconvenientes al momento de registrar la solicitud, fecha u horas seleccionadas, favor de verificarlos.'
                            });
                            me.isLoading = false;
                        }
                        me.errores = {};
                    }
                }).catch(error=>{
                    if(error.response.status == 422){
                        me.errores = error.response.data.errors;
                    }else{
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Fallo en el sistema.'
                        });
                    }
                })
            }
        },
        resetVariables(){
            this.solicitud = {
                'idSala': 0,
                'fecha': '',
                'horaIni': '',
                'horaFin': '',
                'rutaSol': null
            };
            document.getElementById("inputFormSol").value = null;
        },
        format_date(value){
            if (value) {
                var date3days = moment(value).add(3, 'd');
                this.dateFormat = moment(date3days).format('YYYY-MM-DD')
            }
        },
    },
    mounted() {
        this.getEventos();
        this.getSalas();
        var dateHoy = Date.now();
        this.format_date(dateHoy);
    }
}
</script>
