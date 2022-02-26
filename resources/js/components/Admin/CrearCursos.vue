<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="row card-header">
                        <div class="col-md-8">
                            <h4 class="">Administrar Cursos</h4>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center">
                            <button type="button" class="btn btn-primary" disabled>Carga Masiva</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Nombre de curso</label>
                                    <input required v-model="curso.nombre" type="text" class="form-control" placeholder="Nombre de curso">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Instructor del curso</label>
                                    <input required v-model="curso.instructor" type="text" class="form-control" placeholder="Nombre del instructor">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Requisitos</label>
                                    <textarea required v-model="curso.requisitos" type="text" class="form-control" placeholder="Requisitos del curso"></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Sala</label>
                                    <select class="form-select" v-model="curso.sala">
                                        <option value="0" selected disabled>Seleccione una sala</option>
                                        <option :value="sala.idSala" v-text="sala.nomSala" v-for="sala in salas" :key="sala.idSala"></option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Fecha de inicio</label>
                                    <input required type="date" v-model="curso.fecInCur" class="form-control">                                   
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Fecha de finalización</label>
                                    <input required type="date" v-model="curso.fecFinCur" class="form-control" :min="curso.fecInCur">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Hora de inicio</label>
                                    <input required type="time" v-model="horario[0]['horaIni']" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Hora de fin</label>
                                    <input required type="time" v-model="horario[0]['horaFin']" class="form-control" :min="horario[0]['horaIni']" max="18:00">
                                </div>
                            </div>
                            <br>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-primary" @click="registrarCurso()">Registrar curso</button>
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
        return{
            curso:{
                'nombre': '',
                'instructor': '',
                'requisitos': '',
                'sala': 0,
                'fechaInCur': '',
                'fechaInCur': ''
            },
            horario: [{
                'horaIni': '',
                'horaFin': ''
            }],
            salas: []
        }
    },
    methods: {
        registrarCurso(){

        }
    },
    mounted() {

    }
}
</script>