<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header">Solicitar Sala</h4>

                    <div class="card-body">
                        <form method="post" @submit.prevent="registrarSolicitud()" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Sala A Solicitar: *</label>
                                    <select required class="form-select" v-model="solicitud.idSala">
                                        <option value="0" selected disabled>Seleccione una sala...</option>
                                        <option :value="sala.idSala" v-text="sala.nomSala" v-for="sala in salas" :key="sala.idSala"></option>
                                    </select>
                                    <span class="is-invalid" v-if="errores && errores['solicitud.sala']">
                                        <strong>{{ errores['solicitud.idSala'][0] }}</strong>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Fecha: *</label>
                                    <input required type="date" v-model="solicitud.fecha" class="form-control">
                                    <span class="is-invalid" v-if="errores && errores['solicitud.fecha']">
                                        <strong>{{ errores['solicitud.fecha'][0] }}</strong>
                                    </span>                                
                                </div>
                            </div>
                            <br>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Hora de inicio</label>
                                    <input required type="time" v-model="solicitud.horaIni" class="form-control" min="08:00" max="17:00">
                                    <span class="is-invalid" v-if="errores && errores['solicitud.horaIni']">
                                        <strong>{{ errores['solicitud.horaIni'][0] }}</strong>
                                    </span> 
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Hora de fin</label>
                                    <input required type="time" v-model="solicitud.horaFin" class="form-control" :min="solicitud.horaIni" max="18:00">
                                    <span class="is-invalid" v-if="errores && errores['solicitud.horaFin']">
                                        <strong>{{ errores['solicitud.horaFin'][0] }}</strong>
                                    </span>
                                </div>
                            </div>
                            <br>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">Solicitar Sala</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    data(){
        return {
            solicitud:{
                'idSala': 0,
                'fecha': '',
                'horaIni': '',
                'horaFin': '',
                'rutaSol': ''
            },
            salas: [],
            errores: {},
            errores: [],
            
        }
    },
    methods: {
        getSalas(){
            let me = this;
            axios.get('/catalogoSalas').then(response=>{
                me.salas = response.data.salas;
            })
            .catch(error=>{
                me.errores = error.data;
            })
        },
        registrarSolicitud(){
            let me = this;
            axios.post('/solicitud',{"solicitud": me.solicitud}).then(response=>{
                if(response.data.code == 1) {
                    me.errores = {};
                    me.successSolicitud = true;
                    me.resetVariables();
                }else{
                    me.errores = {};
                    me.cursoExistente = true;
                }
            }).catch(error=>{
                if(error.response.status == 422){
                    me.errores = error.response.data.errors;
                    console.log(me.errores);
                    me.solicitud.horaIni = '';
                    me.solicitud.horaFin = '';
                }
            })
        },
        resetVariables(){
            this.solicitud = {
                'idSala': 0,
                'fecha': '',
                'horaIni': '',
                'horaFin': ''
            };
        },
    },
    mounted() {
        this.getSalas();
    }
}
</script>
