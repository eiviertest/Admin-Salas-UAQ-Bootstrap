<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>Reportes</h4>
                            </div>
                            <div class="col-md-4 d-flex justify-content-center" v-if="btnDescargarInfo">
                                <button class="btn btn-success justify-content-end" v-on:click="descargarInfo(ruta, id)">Descargar información <font-awesome-icon icon="fa-solid fa-file-arrow-down" /></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="vld-parent">
                            <loading :active.sync="isLoading"
                                    :can-cancel="false"
                                    :is-full-page="true"/>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="form-control-label" for="text-input">Reporte a Generar:</label>
                                <select class="form-select" v-model="eleccion">
                                    <option value=0 selected disabled>Seleccione una opción</option>
                                    <option value=1>Cursos Impartidos</option>
                                    <option value=2>Solicitud de Sala por Área</option>
                                    <option value=3>Concentrado por Curso</option>
                                </select>
                            </div>
                            <div class="col-md-3" v-if="mostrarElementoArea">
                                <label class="form-control-label" for="text-input">Área/Facultad/Institución</label>
                                <select class="form-select" v-model="idArea">
                                    <option value="0" selected disabled>Seleccione un Área/Facultad</option>
                                    <option :value="area.idArea" v-text="area.nomArea" v-for="area in areas" :key="area.idArea"></option>
                                </select>
                            </div>
                            <div class="col-md-3" v-if="mostrarElementoCurso">
                                <label class="form-control-label" for="text-input">Curso</label>
                                <select class="form-select" v-model="idCurso">
                                    <option value="0" selected disabled>Seleccione un Curso</option>
                                    <option :value="curso.idCur" v-text="curso.nomCur" v-for="curso in cursos" :key="curso.idCur"></option>
                                </select>
                            </div>
                        </div>
                        <div class="row" v-if="mostrarElementoTablaConcentradoCurso">
                            <TablaConcentradoCurso :encabezados='encabezados' :arrayData='arrayData' ></TablaConcentradoCurso>
                        </div>
                        <div class="row" v-if="mostrarElementoTablaCursosImpartidos">
                            <TablaCursosImpartidos :encabezados='encabezados' :arrayData='arrayData' ></TablaCursosImpartidos>
                        </div>
                        <div class="row" v-if="mostrarElementoTablaSolicitudes">
                            <TablaAreaSolicitudes :encabezados='encabezados' :arrayData='arrayData' ></TablaAreaSolicitudes>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import TablaConcentradoCurso from '../TablasReportes/TablaConcentradoCurso.vue';
import TablaCursosImpartidos from '../TablasReportes/TablaCursosImpartidos.vue';
import TablaAreaSolicitudes from '../TablasReportes/TablaAreaSolicitudesDetalle.vue';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    components: {
        TablaConcentradoCurso,
        TablaCursosImpartidos,
        TablaAreaSolicitudes,
        Loading
    },
    data(){
        return {
            cursos: [],
            areas: [],
            errores: [],
            encabezados: [],
            arrayData: [],
            mostrarElementoArea: false,
            mostrarElementoCurso: false,
            mostrarElementoTablaConcentradoCurso: false,
            mostrarElementoTablaCursosImpartidos: false,
            mostrarElementoTablaSolicitudes: false,
            btnDescargarInfo: false,
            eleccion: 0,
            idCurso: 0,
            idArea: 0,
            ruta: '',
            id: '',
            isLoading: false
        }
    },
    methods: {
        getCursos() {
            let me = this;
            me.isLoading = true;
            axios.get('/catalogo_curso').then(function (response) {
                me.cursos = response.data.cursos;
                me.mostrarElementoCurso = true;
                me.isLoading = false;
            }).catch(function (error) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Fallo en el sistema.',
                    button: 'Entendido'
                });
            });
        },
        getAreas() {
            let me = this;
            me.isLoading = true;
            axios.get('/catalogo_area').then(function (response) {
                me.areas = response.data.areas;
                me.mostrarElementoArea = true;
                me.isLoading = false;
            }).catch(function (error) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Fallo en el sistema.',
                    button: 'Entendido'
                });
            });
        },
        concentradoCurso(idCurso){
            let me = this;
            me.isLoading = true;
            axios.get('/concentrado_curso/' + idCurso).then(function (response) {
                me.id = idCurso;
                me.ruta = 'concentrado_curso_pdf';
                me.arrayData = response.data.personas;
                me.encabezados = [
                    {'id':1,'nombre':'Nombre completo'},
                    {'id':2,'nombre':'Área/Facultad/Institución'}
                ];
                me.btnDescargarInfo = true;
                me.mostrarElementoTablaConcentradoCurso = true;
                me.isLoading = false;
            }).catch(function (error) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Fallo en el sistema.',
                    button: 'Entendido'
                });
            });
        },
        getCursosImpartidos(){
            let me = this;
            me.isLoading = true;
            axios.get('/cursos_impartidos').then(function (response) {
                me.id = 0;
                me.ruta = 'cursos_impartidos_pdf';
                me.arrayData = response.data.cursos;
                me.encabezados = [
                    {'id':1,'nombre':'Nombre de curso'},
                    {'id':2,'nombre':'Fecha de inicio'},
                    {'id':3,'nombre':'Fecha de termino'},
                    {'id':4,'nombre':'Cupo'},
                    {'id':5,'nombre':'Sala'}
                ];
                me.mostrarElementoTablaCursosImpartidos = true;
                me.btnDescargarInfo = true;
                me.isLoading = false;
            }).catch(function (error) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Fallo en el sistema.',
                    button: 'Entendido'
                });
            });
        },
        concentradoSolicitudes(idArea){
            let me = this;
            me.isLoading = true;
            axios.get('/area_solicitudes_detalle/' + idArea).then(function (response) {
                me.id = idArea;
                me.ruta = 'area_solicitudes_detalle_pdf';
                me.arrayData = response.data.solicitudes;
                me.encabezados = [
                    {'id':1,'nombre':'Nombre completo'},
                    {'id':2,'nombre':'Estado'},
                    {'id':3,'nombre':'Nombre de sala'}
                ];
                me.btnDescargarInfo = true;
                me.mostrarElementoTablaSolicitudes = true;
                me.isLoading = false;
            }).catch(function (error) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Fallo en el sistema.',
                    button: 'Entendido'
                });
            });
        },
        descargarInfo(ruta, id){
            window.open('/'+ruta+'/'+id, '_blank');
        }
    },
    watch: {
        eleccion: function (val) {
            this.btnDescargarInfo = false;
            if(val == 1) {
                //Cursos impartidos
                this.mostrarElementoTablaConcentradoCurso = false;
                this.mostrarElementoTablaSolicitudes = false;
                this.mostrarElementoArea = false;
                this.mostrarElementoCurso = false;
                this.idCurso = 0;
                this.idArea = 0;
                this.id = 0;
                this.getCursosImpartidos();
            }else if(val == 2) {
                //Solicitudes por area
                this.mostrarElementoTablaConcentradoCurso = false;
                this.mostrarElementoTablaCursosImpartidos = false;
                this.mostrarElementoCurso = false;
                this.mostrarElementoCurso = false;
                this.idCurso = 0;
                this.id = 0;
                this.getAreas();
            }else if(val == 3) {
                //Concentrado por curso
                this.mostrarElementoTablaCursosImpartidos = false;
                this.mostrarElementoTablaSolicitudes = false;
                this.mostrarElementoArea = false;
                this.idArea = 0;
                this.id = 0;
                this.getCursos();
            }else {
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'No puede seleccionar esta opción',
                    button: 'Entendido'
                });
            }
        },
        idCurso: function (val) {
            if(val > 0){
                this.concentradoCurso(val);
            }
        },
        idArea: function (val) {
            if(val > 0){
                this.concentradoSolicitudes(val);
            }
        }
    }
}
</script>