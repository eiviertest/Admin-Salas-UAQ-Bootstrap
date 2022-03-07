<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header">Solicitar Sala</h4>

                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Sala A Solicitar: *</label>
                                    <select class="form-select" v-model="solicitud.sala">
                                        <option value=0 selected disabled>Seleccione una opción...</option>
                                        <option value=1 >Sala A</option>
                                        <option value=2>Sala B</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Fecha: *</label>
                                    <input required type="date" v-model="solicitud.fecha" class="form-control">                                   
                                </div>
                            </div>
                            <br>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Hora de inicio</label>
                                    <input required type="time" v-model="solicitud.horaIni" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Hora de fin</label>
                                    <input required type="time" v-model="solicitud.horaFin" class="form-control" :min="solicitud.horaIni" max="18:00">
                                </div>
                            </div>
                            <br>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-primary" @click="registrarSolicitud()">Solicitar Sala</button>
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
                'sala': 0,
                'fecha': '',
                'horaIni': '',
                'horaFin': ''
            },
            
        }
    },
    methods: {
        registrarSolicitud(){
            console.log(
                'Hora Inicio: ' + this.solicitud.horaIni + ', Hora Fin: ' + this.solicitud.horaFin
            );
            console.log(
                'Sala: ' + this.solicitud.sala
            );
            console.log(
                'Fecha: ' + this.solicitud.fecha 
            );
        }
    },
    watch: {
        /**
        eleccionSala: function (val) {
            if(val == 1) {
                //Cursos impartidos
                this.mostrarFechas = true;
                //this.getCursosImpartidos();
            }else if(val == 2) {
                //Solicitudes por area
                this.mostrarFechas = true;
                //this.getAreas();
            }else {
                console.log('Sin elección.')
            }
        },
        eleccionFecha: function (val) {
            if(val != '') {
                //Cursos impartidos
                this.mostrarHorarios = true;
                //this.getCursosImpartidos();
            }else {
                console.log('Sin elección.')
            }
        },
         */
    }
}
</script>
