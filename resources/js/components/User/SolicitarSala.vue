<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header">Solicitar Sala</h4>
                    <div v-if="errorForm" class="alert alert-warning d-flex align-items-center" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                        <div>
                            Existe un error en los datos Ingresados, por favor verifiquelos.
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <form method="post" @submit.prevent="registrarSolicitud()" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label class="form-control-label" for="text-input">Sala A Solicitar: *</label>
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
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-control-label" for="text-input">Fecha: *</label>
                                        <input @change="getEventos()" required type="date" v-model="solicitud.fecha" class="form-control">
                                        <span class="is-invalid" v-if="errores && errores['solicitud.fecha']">
                                            <strong>{{ errores['solicitud.fecha'][0] }}</strong>
                                        </span>                                
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label class="form-control-label" for="text-input">Hora de inicio: *</label>
                                        <input @change="getEventos()" required type="time" v-model="solicitud.horaIni" class="form-control" step="3600" min="08:00" max="17:00">
                                        <span class="is-invalid" v-if="errores && errores['solicitud.horaIni']">
                                            <strong>{{ errores['solicitud.horaIni'][0] }}</strong>
                                        </span> 
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-control-label" for="text-input">Hora de Fin: *</label>
                                        <input @change="getEventos()" required type="time" v-model="solicitud.horaFin" class="form-control" step="3600" :min="solicitud.horaIni" max="18:00">
                                        <span class="is-invalid" v-if="errores && errores['solicitud.horaFin']">
                                            <strong>{{ errores['solicitud.horaFin'][0] }}</strong>
                                        </span>
                                    </div>
                                </div>
                                <br>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label class="form-control-label">Formato de Solicitud: *</label>
                                        <input required accept="application/pdf" class="form-control" type="file" id="inputFormSol" @change="seleccionarArchivo">
                                        <br>
                                        <div v-if="errorFile" class="alert alert-warning d-flex align-items-center" role="alert">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                            </svg>
                                            <div>
                                                El tipo de archivo es incorrecto, seleccione un <strong>PDF</strong> por favor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary">Solicitar Sala</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <label class="form-control-label h2">Eventos</label>
                            <FullCalendar :options="calendarOptions"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import '@fullcalendar/core/vdom'
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

export default {
    components: {
        FullCalendar
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
            errores: {},
            errores: [],
            errorFile: false,
            errorSelect:false,
            errorForm:false,
            calendarOptions: {
                plugins: [ dayGridPlugin, interactionPlugin ],
                initialView: 'dayGridMonth',
                events: [],
                locale: 'es'
            }            
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
                me.errores = error.response.data;
            })
        },
        getSalas(){
            let me = this;
            axios.get('/catalogoSalas').then(response=>{
                me.salas = response.data.salas;
            })
            .catch(error=>{
                me.errores = error.data;
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
            this.errorFile = false,
            console.log(e.target.files[0].type);
            if(e.target.files[0].type == 'application/pdf'){
                console.log('Es un PDF');
                this.solicitud.rutaSol = e.target.files[0];
            }else{
                this.errorFile = true;
                console.log('Selecciona Un PDF webonzo');
            }
        },
        registrarSolicitud(){
            this.errorForm = false;
            this.verificarDatos();
            if(this.errorForm == false){
                let me = this;
                let solicitudForm = new FormData();
                for(let key in this.solicitud){
                    solicitudForm.append(key, this.solicitud[key]);
                }
                console.log(solicitudForm);
                axios.post('/solicitud',solicitudForm).then(response=>{
                    if(response.data.code == 1) {
                        me.errores = {};
                        me.resetVariables();
                        me.getEventos();
                    }else{
                        me.errores = {};
                    }
                }).catch(error=>{
                    if(error.response.status == 422){
                        me.errores = error.response.data.errors;
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
    },
    mounted() {
        this.getEventos();
        this.getSalas();
    }
}
</script>
