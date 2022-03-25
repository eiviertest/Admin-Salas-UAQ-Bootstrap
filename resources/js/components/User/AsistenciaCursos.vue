<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card text-center">
                    <h4 class="card-header">Mis Asistencias</h4>
                    <div class="card-body">
                        <div class="vld-parent">
                            <loading :active.sync="isLoading"
                                    :can-cancel="false"
                                    :is-full-page="true"/>
                        </div>
                        <div class="row">
                                <div class="card col-md-3 m-5 text-dark bg-light" v-for="lista in listaCursosEnrolado" :key="lista.nomCur">
                                        <div class="card-header bg-success text-white"><h5>{{lista.nomCur}}</h5></div>
                                        <div class="card-body text-white bg-dark">
                                            <label>Estado: </label>
                                            <h6>{{lista.estatus}}</h6>
                                            <div v-if="lista.estatus=='Aceptado'"> 
                                                <label>Fecha Inicio:</label>
                                                <h6>{{lista.fecInCur}}</h6>
                                                <label>Fecha Termino:</label>
                                                <h6>{{lista.fecFinCur}}</h6>
                                                <label>Hora Inicio:</label>
                                                <h6>{{lista.horIn}}</h6>
                                                <label>Hora Termino:</label>
                                                <h6>{{lista.horFin}}</h6>
                                            </div>
                                        </div> 
                                        <div class="card-footer text-white bg-dark">Todos los datos presentados son informativos</div>
                                </div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    data() {
        return {
            listaCursosEnrolado: [],
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
        }
    },
    components: {
        Loading
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
            me.getCursosEnrolados(page);
        },
        getCursosEnrolados(page) {
            let me = this;
            axios.get('/mis_cursos_persona?page='+ page).then(function (response) {
                me.listaCursosEnrolado = response.data.mis_cursos_persona.data;
                me.pagination = response.data.pagination;
                me.isLoading = false;
            }).catch(function (error) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Fallo en el sistema.'
                });
            });
        }
    },
    mounted() {
        this.getCursosEnrolados(1);
    }
}
</script>