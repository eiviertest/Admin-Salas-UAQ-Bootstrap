<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="row card-header">
                        <div class="col-md-8">
                            <h4 class="">Administrar Cursos</h4>
                        </div>
                        <!-- <div class="col-md-4 d-flex justify-content-center">
                            <button type="button" class="btn btn-primary" disabled>Carga Masiva</button>
                        </div> -->
                    </div>

                    <div class="card-body">
                        <div class="alert alert-success" role="alert" v-if="successCurso">
                            El curso se ha creado con éxito.
                        </div>
                        <div class="alert alert-warning" role="alert" v-if="cursoExistente">
                            Un curso ya se encuentra registrado.
                        </div>
                        <form method="post" @submit.prevent="registrarCurso()" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Nombre de curso</label>
                                    <input required v-model="curso.nomCur" name="nomCur" id="nomCur" type="text" class="form-control" placeholder="Nombre de curso">
                                    <span class="is-invalid" v-if="errores && errores['curso.nomCur']">
                                        <strong>{{ errores['curso.nomCur'][0] }}</strong>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Instructor del curso</label>
                                    <input required v-model="curso.instructor" type="text" class="form-control" placeholder="Nombre del instructor">
                                    <span class="is-invalid" v-if="errores && errores['curso.instructor']">
                                        <strong>{{ errores['curso.instructor'][0] }}</strong>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Requisitos</label>
                                    <textarea required v-model="curso.requisitos" type="text" class="form-control" placeholder="Requisitos del curso"></textarea>
                                    <span class="is-invalid" v-if="errores && errores['curso.requisitos']">
                                        <strong>{{ errores['curso.requisitos'][0] }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Sala</label>
                                    <select required class="form-select" v-model="curso.sala">
                                        <option value="0" selected disabled>Seleccione una sala</option>
                                        <option :value="sala.idSala" v-text="sala.nomSala" v-for="sala in salas" :key="sala.idSala"></option>
                                    </select>
                                    <span class="is-invalid" v-if="errores && errores['curso.sala']">
                                        <strong>{{ errores['curso.sala'][0] }}</strong>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Fecha de inicio</label>
                                    <input required type="date" v-model="curso.fecInCur" class="form-control">
                                    <span class="is-invalid" v-if="errores && errores['curso.fecInCur']">
                                        <strong>{{ errores['curso.fecInCur'][0] }}</strong>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Fecha de finalización</label>
                                    <input required type="date" v-model="curso.fecFinCur" class="form-control" :min="curso.fecInCur">
                                    <span class="is-invalid" v-if="errores && errores['curso.fecFinCur']">
                                        <strong>{{ errores['curso.fecFinCur'][0] }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Hora de inicio</label>
                                    <input required type="time" v-model="horario.horaIni" class="form-control" min="08:00">
                                    <span class="is-invalid" v-if="errores && errores['curso.horarios']">
                                        <strong>{{ errores['curso.horarios'][0] }}</strong>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Hora de fin</label>
                                    <input required type="time" v-model="horario.horaFin" class="form-control" :min="horario.horaIni" max="18:00">
                                    <span class="is-invalid" v-if="errores && errores['curso.horarios']">
                                        <strong>{{ errores['curso.horarios'][0] }}</strong>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Cupo límite</label>
                                    <input required v-model="curso.cupolimite" type="number" max="15" min="0" class="form-control" placeholder="Cupo del curso">
                                    <span class="is-invalid" v-if="errores && errores['curso.cupolimite']">
                                        <strong>{{ errores['curso.cupolimite'][0] }}</strong>
                                    </span>
                                </div>
                            </div>
                            <br>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">Registrar curso</button>
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
                'nomCur': '',
                'instructor': '',
                'requisitos': '',
                'cupolimite': '',
                'fecInCur': '',
                'fecFinCur': '',
                'sala': 0,
                'horarios': []
            },
            horario: {
                'horaIni': '',
                'horaFin': ''
            },
            salas: [],
            errores: {},
            successCurso: false,
            cursoExistente: false
        }
    },
    methods: {
        registrarCurso(){
            me.cursoExistente = false;
            me.successCurso = false;
            let me = this;
            me.curso.horarios = [];
            me.curso.horarios.push({
                'horIn': me.horario.horaIni,
                'horFin': me.horario.horaFin
            });
            axios.post('/curso',{"curso": me.curso}).then(response=>{
                if(response.data.code == 1) {
                    me.errores = {};
                    me.successCurso = true;
                    me.resetVariables();
                }else{
                    me.errores = {};
                    me.cursoExistente = true;
                }
            }).catch(error=>{
                if(error.response.status == 422){
                    me.errores = error.response.data.errors;
                    me.curso.horarios = [];
                }
            })
        },
        resetVariables(){
            this.curso = {
                'nomCur': '',
                'instructor': '',
                'requisitos': '',
                'cupolimite': '',
                'fecInCur': '',
                'fecFinCur': '',
                'sala': 0,
                'horarios': []
            };
            this.horario = {
                'horaIni': '',
                'horaFin': ''
            };
        },
        getSalas(){
            let me = this;
            axios.get('/catalogoSalas').then(response=>{
                me.salas = response.data.salas;
            })
            .catch(error=>{
                me.errores = error.data;
            })
        }
    },
    mounted() {
        this.getSalas();
    }
}
</script>