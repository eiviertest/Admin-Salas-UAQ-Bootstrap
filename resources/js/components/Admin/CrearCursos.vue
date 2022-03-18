<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="">Administrar Cursos</h4>
                            </div>
                            <div class="col-md-4 d-flex flex-row-reverse">
                                <button type="button" class="btn btn-success" v-if="!mostrar && cursos.length > 0" v-on:click="mostrar = !mostrar">Ver Cursos Registrados <font-awesome-icon icon="fa-solid fa-eye" /> </button>
                                <button type="button" class="btn btn-success" v-if="mostrar" v-on:click="mostrar = !mostrar">Registrar Curso <font-awesome-icon icon="fa-solid fa-plus" /> </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="vld-parent">
                            <loading :active.sync="isLoading"
                                    :can-cancel="false"
                                    :is-full-page="true"/>
                        </div>
                        <form method="post" @submit.prevent="registrarCurso()" enctype="multipart/form-data" class="form-horizontal" v-if="!mostrar">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Nombre de Curso: *</label>
                                    <input required v-model="curso.nomCur" name="nomCur" id="nomCur" type="text" class="form-control" placeholder="Nombre de curso">
                                    <span class="is-invalid" v-if="errores && errores['curso.nomCur']">
                                        <strong>{{ errores['curso.nomCur'][0] }}</strong>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Instructor del Curso: *</label>
                                    <input required v-model="curso.instructor" type="text" class="form-control" placeholder="Nombre del instructor">
                                    <span class="is-invalid" v-if="errores && errores['curso.instructor']">
                                        <strong>{{ errores['curso.instructor'][0] }}</strong>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Requisitos: *</label>
                                    <textarea required v-model="curso.reqCur" type="text" class="form-control" placeholder="Requisitos del curso"></textarea>
                                    <span class="is-invalid" v-if="errores && errores['curso.reqCur']">
                                        <strong>{{ errores['curso.reqCur'][0] }}</strong>
                                    </span>
                                </div>
                            </div>
                            <br>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Sala: *</label>
                                    <select required class="form-select" v-model="curso.idSala">
                                        <option value="0" selected disabled>Seleccione una sala</option>
                                        <option :value="sala.idSala" v-text="sala.nomSala" v-for="sala in salas" :key="sala.idSala"></option>
                                    </select>
                                    <span class="is-invalid" v-if="errores && errores['curso.idSala']">
                                        <strong>{{ errores['curso.idSala'][0] }}</strong>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Fecha de Inicio: *</label>
                                    <input required type="date" v-model="curso.fecInCur" class="form-control">
                                    <span class="is-invalid" v-if="errores && errores['curso.fecInCur']">
                                        <strong>{{ errores['curso.fecInCur'][0] }}</strong>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Fecha de Finalización: *</label>
                                    <input required type="date" v-model="curso.fecFinCur" class="form-control" :min="curso.fecInCur">
                                    <span class="is-invalid" v-if="errores && errores['curso.fecFinCur']">
                                        <strong>{{ errores['curso.fecFinCur'][0] }}</strong>
                                    </span>
                                </div>
                            </div>
                            <br>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Hora de Inicio: *</label>
                                    <input required type="time" step="3600" v-model="horario.horaIni" class="form-control" min="08:00" max="18:00">
                                    <span class="is-invalid" v-if="errores && errores['curso.horarioscurso']">
                                        <strong>{{ errores['curso.horarioscurso'][0] }}</strong>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Hora de Fin: *</label>
                                    <input required type="time" step="3600" v-model="horario.horaFin" class="form-control" :min="horario.horaIni" max="18:00">
                                    <span class="is-invalid" v-if="errores && errores['curso.horarioscurso']">
                                        <strong>{{ errores['curso.horarioscurso'][0] }}</strong>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="text-input">Cupo Límite: *</label>
                                    <input required v-model="curso.cupCur" type="number" max="15" min="0" class="form-control" placeholder="Cupo del curso">
                                    <span class="is-invalid" v-if="errores && errores['curso.cupCur']">
                                        <strong>{{ errores['curso.cupCur'][0] }}</strong>
                                    </span>
                                </div>
                            </div>
                            <br>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">Registrar Curso  <font-awesome-icon icon="fa-solid fa-plus" /> </button>
                                </div>
                            </div>
                        </form>
                        <div v-if="mostrar">
                            <div class="row">
                                <div class="col d-flex flex-row-reverse">
                                    <button class="btn btn-info" v-on:click="mostrarFiltros = !mostrarFiltros ">Filtros <font-awesome-icon icon="fa-solid fa-angle-down" /></button>
                                </div>
                            </div>
                            <div class="row" v-if="mostrarFiltros">
                                <div class="col-md-3">
                                    <label class="form-control-label" for="text-input">Fecha de Inicio</label>
                                    <input required type="date" v-model="fecha_inicio" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-control-label" for="text-input">Fecha de Fin</label>
                                    <input required type="date" v-model="fecha_fin" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-control-label" for="text-input">Sala</label>
                                    <select required class="form-select" v-model="sala">
                                        <option value="0" selected disabled>Seleccione una sala</option>
                                        <option :value="sala.idSala" v-text="sala.nomSala" v-for="sala in salas" :key="sala.idSala"></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <table class="table" v-if="mostrar">
                            <thead> 
                                <tr>
                                    <th style="text-align: center" scope="col">Nombre del curso</th>
                                    <th style="text-align: center" scope="col">Fecha de inicio</th>
                                    <th style="text-align: center" scope="col">Fecha de fin</th>
                                    <th style="text-align: center" scope="col">Más detalles</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="curso in cursos" :key="curso.idCur"> 
                                    <td align="center" v-text="curso.nomCur"></td>
                                    <td align="center" v-text="curso.fecInCur"></td>
                                    <td align="center" v-text="curso.fecFinCur"></td>
                                    <td align="center" v-on:click="verDetalle(curso.idCur)">
                                        <a class="btn btn-outline-primary" href="#" role="button">Ver Detalles <font-awesome-icon icon="fa-solid fa-circle-info" /></a>
                                    </td>
                                    <td v-if="curso.estado != 0">
                                        <button class="btn btn-warning" v-on:click="disableCurso(curso.idCur)">Deshabilitar <font-awesome-icon icon="fa-solid fa-trash-arrow-up" /> </button>
                                        <button class="btn btn-danger" v-on:click="editarCurso(curso.idCur)">Actualizar <font-awesome-icon icon="fa-solid fa-pencil" /> </button>
                                    </td>
                                    <td v-else>
                                        <button class="btn btn-info" v-on:click="enableCurso(curso.idCur)">Habilitar <font-awesome-icon icon="fa-regular fa-pen-to-square" /> </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav v-if="mostrar">
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
                        <RUCurso v-if="modalRUCurso" :idCurso="idCurso" :accion="accion" @closeModal="modalRUCurso = false" :salas="salas" @sucessUpdate="getCursos(1)"></RUCurso>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import RUCurso from './RUCurso.vue';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    components: {
        RUCurso,
        Loading
    },
    data(){
        return{
            curso:{
                'nomCur': '',
                'instructor': '',
                'reqCur': '',
                'cupCur': '',
                'fecInCur': '',
                'fecFinCur': '',
                'idSala': 0,
                'horarioscurso': []
            },
            horario: {
                'horaIni': '',
                'horaFin': ''
            },
            salas: [],
            errores: {},
            successCurso: false,
            cursoExistente: false,
            mostrar: false,
            cursos: [],
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
            modalRUCurso: false,
            accion: '',
            idCurso: 0,
            isLoading: true,
            fecha_inicio: '',
            fecha_fin: '',
            estatus: '',
            sala: 0,
            mostrarFiltros: false
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
            me.getCursos(page);
        },
        registrarCurso(){
            let me = this;
            me.isLoading = true;
            me.cursoExistente = false;
            me.successCurso = false;
            me.curso.horarioscurso = [];
            me.curso.horarioscurso.push({
                'horIn': me.horario.horaIni,
                'horFin': me.horario.horaFin
            });
            axios.post('/curso',{"curso": me.curso}).then(response=>{
                if(response.data.code == 1) {
                    me.errores = {};
                    me.successCurso = true;
                    me.getCursos(1);
                    me.resetVariables();
                    // Alerta que notifica que todo salio correcto
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'El registro se ha realizado con éxito',
                        showConfirmButton: false,
                        timer: 1200
                    })
                }else{
                    me.errores = {};
                    me.cursoExistente = true;
                    me.isLoading = false;
                    // Alerta que notifica que surgio un error
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Ya existe un curso registrado',
                        showConfirmButton: false,
                        timer: 1200
                    })
                }
            }).catch(error=>{
                if(error.response.status == 422){
                    me.errores = error.response.data.errors;
                    me.curso.horarios = [];
                }else{
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Fallo en el sistema.',
                        button: 'Entendido'
                    });
                }
            })
        },
        resetVariables(){
            this.curso = {
                'nomCur': '',
                'instructor': '',
                'reqCur': '',
                'cupCur': '',
                'fecInCur': '',
                'fecFinCur': '',
                'idSala': 0,
                'horarios': []
            };
            this.horario = {
                'horaIni': '',
                'horaFin': ''
            };
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
                    title: 'Fallo en el sistema.',
                    button: 'Entendido'
                });
            })
        },
        getCursos(page){
            let me = this;
            axios.get('/curso_admin?page=' + page, {
                params: {
                    estatus : me.estatus,
                    fecha_inicio : me.fecha_inicio,
                    fecha_fin : me.fecha_fin,
                    sala: me.sala
                }
            }).then(response=>{
                me.cursos = response.data.cursos.data;
                me.pagination = response.data.pagination;
                me.isLoading = false;
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
        editarCurso(idCurso){
            this.modalRUCurso = true;
            this.accion = "Actualizar curso";
            this.idCurso = idCurso;
        },
        verDetalle(idCurso){
            this.modalRUCurso = true;
            this.accion = "Ver Datos del Curso";
            this.idCurso = idCurso;
        },
        disableCurso(idCurso){
        Swal.fire({
                title: '¿Estás seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, deshabilitar registro!'
                }).then((result) => {
                if (result.isConfirmed) {
                    // Petición para eliminar el registro
                    let me = this;
                    me.isLoading = true;
                    axios.put('/curso',
                    {
                    'idCur': idCurso,
                            }).then(function (response) {
                                if(response.data.code == 1) {
                                    me.getCursos(1);
                                    //Mensaje de eliminación 
                                    Swal.fire(
                                    'Deshabilitado!',
                                    'El registro ha sido deshabilitado exitosamente.',
                                    'success'
                                    )
                            }
                            }).catch( function (error) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'Fallo en el sistema.',
                                    button: 'Entendido'
                                });
                        });
                }
            })
        },
        enableCurso(idCurso){
        Swal.fire({
                title: '¿Estás seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, habilitar registro!'
                }).then((result) => {
                if (result.isConfirmed) {
                    // Petición para eliminar el registro
                    let me = this;
                    me.isLoading = true;
                    axios.put('/enable',
                    {
                    'idCur': idCurso,
                            }).then(function (response) {
                                if(response.data.code == 1) {
                                    me.getCursos(1);
                                    //Mensaje de eliminación 
                                    Swal.fire(
                                    'Habilitado!',
                                    'El registro ha sido habilitado exitosamente.',
                                    'success'
                                    )
                            }
                            }).catch( function (error) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'Fallo en el sistema.',
                                    button: 'Entendido'
                                });
                        });
                }
            })
        },
    },
    mounted() {
        this.getSalas();
        this.getCursos(1);
    },
    watch: {
        fecha_inicio: function(val){
            this.isLoading = true;
            this.fecha_inicio = val;
            this.getCursos(1);
        },
        fecha_fin: function(val){
            this.isLoading = true;
            this.fecha_fin = val;
            this.getCursos(1);
        },
        sala: function(val){
            this.isLoading = true;
            this.sala = val;
            this.getCursos(1);
        }
    }
}
</script>