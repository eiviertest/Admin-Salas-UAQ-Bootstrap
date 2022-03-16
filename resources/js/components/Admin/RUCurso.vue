<template>
    <div class="modal" id="myModalUpdate" style="display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{accion}}</h4>
                    <button type="button" class="close btn btn-danger" @click="closeModal()" data-dismiss="modal">X</button>
                </div>
                <div class="modal-body">
                    <div class="vld-parent">
                        <loading :active.sync="isLoading"
                                :can-cancel="false"
                                :is-full-page="true"/>
                    </div>
                    <form method="put" @submit.prevent="updateCurso()">
                        <div class="row form-group">
                            <div class="col">
                                <label class="form-control-label" for="text-input">Nombre de Curso:</label>
                                <input disabled required v-model="curso.nomCur" name="nomCur" id="nomCur" type="text" class="form-control" placeholder="Nombre de curso">
                                <span class="is-invalid" v-if="errores && errores['curso.nomCur']">
                                    <strong>{{ errores['curso.nomCur'][0] }}</strong>
                                </span>
                            </div>
                            <div class="col">
                                <label class="form-control-label" for="text-input">Instructor del Curso:</label>
                                <input disabled required v-model="curso.instructor" type="text" class="form-control" placeholder="Nombre del instructor">
                                <span class="is-invalid" v-if="errores && errores['curso.instructor']">
                                    <strong>{{ errores['curso.instructor'][0] }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <label class="form-control-label" for="text-input">Requisitos:</label>
                                <textarea disabled required v-model="curso.reqCur" type="text" class="form-control" placeholder="Requisitos del curso"></textarea>
                                <span class="is-invalid" v-if="errores && errores['curso.reqCur']">
                                    <strong>{{ errores['curso.reqCur'][0] }}</strong>
                                </span>
                            </div>
                            <div class="col">
                                <label class="form-control-label" for="text-input">Sala:</label>
                                <select disabled required class="form-select" v-model="curso.idSala">
                                    <option value="0" selected disabled>Seleccione una Sala</option>
                                    <option :value="sala.idSala" v-text="sala.nomSala" v-for="sala in salas" :key="sala.idSala"></option>
                                </select>
                                <span class="is-invalid" v-if="errores && errores['curso.idSala']">
                                    <strong>{{ errores['curso.idSala'][0] }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <label class="form-control-label" for="text-input">Fecha de Inicio:</label>
                                <input :disabled="accion == 'Ver Datos del Curso'" required type="date" v-model="curso.fecInCur" class="form-control">
                                <span class="is-invalid" v-if="errores && errores['curso.fecInCur']">
                                    <strong>{{ errores['curso.fecInCur'][0] }}</strong>
                                </span>
                            </div>
                            <div class="col">
                                <label class="form-control-label" for="text-input">Fecha de Finalización:</label>
                                <input :disabled="accion == 'Ver Datos del Curso'" required type="date" v-model="curso.fecFinCur" class="form-control" :min="curso.fecInCur">
                                <span class="is-invalid" v-if="errores && errores['curso.fecFinCur']">
                                    <strong>{{ errores['curso.fecFinCur'][0] }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <label class="form-control-label" for="text-input">Hora de Inicio:</label>
                                <input :disabled="accion == 'Ver Datos del Curso'" step="3600" v-for="horario in curso.horarioscurso" :key="horario.idHor" required type="time" v-model="horario.horIn" class="form-control" min="08:00" max="18:00">
                            </div>
                            <div class="col">
                                <label class="form-control-label" for="text-input">Hora de Fin:</label>
                                <input :disabled="accion == 'Ver Datos del Curso'" step="3600" v-for="horario in curso.horarioscurso" :key="horario.idHor" required type="time" v-model="horario.horFin" class="form-control" :min="horario.horIn" max="18:00">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <label class="form-control-label" for="text-input">Cupo Límite:</label>
                                <input disabled required v-model="curso.cupCur" name="cupCur" id="cupCur" type="text" class="form-control" placeholder="Cupo límite">
                            </div>
                            <div class="col">
                                <label class="form-control-label" for="text-input">Estado:</label>
                                <br>
                                <a class="btn btn-success" v-if="curso.estado == 1">Habilitado</a>
                                <a class="btn btn-warning" v-else>Deshabilitado</a>
                            </div>
                        </div>
                        <br>
                        <div class="row form-group">
                            <br>
                            <button v-if="accion == 'Actualizar curso'" type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form> 
                </div>
                <div class="modal-footer">
                    <button type="button" @click="closeModal()" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>  
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default({
    components: {
        Loading
    },
    name:"RU-Cuso",
    props: { 
        accion: String,
        idCurso: Number,
        salas: Array
    },
    data(){
        return{
            curso: {},
            errores: [],
            isLoading: true
        }
    },
    methods:{
        getDataCurso(idCurso){
            let me = this;
            axios.get('/getDataCurso/' + idCurso).then(response=>{
                me.curso = response.data;
                me.isLoading = false;
            })
        },
        updateCurso(){
        let me = this;
        me.isLoading = true;
        axios.put('/update_curso',{"curso": me.curso})
                .then(response=>{
                if(response.data.code==1){
                    me.$emit('sucessUpdate');
                    me.closeModal();
                    //Alerta que notifica que todo salio correcto
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'El registro se ha actualizado con éxito',
                        showConfirmButton: false,
                        timer: 1200
                    });
                }else{
                    // Alerta que notifica que surgio un error
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Ya existe un curso registrado',
                        showConfirmButton: false,
                        timer: 1200
                    })
                    me.isLoading= false;
                }
                })
                .catch(error=>{
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Fallo en el sistema.',
                        button: 'Entendido'
                    });
                })
        },
        closeModal(){
            this.$emit('closeModal')
        }
    },
    mounted() {
        this.getDataCurso(this.idCurso);
    }
})
</script>