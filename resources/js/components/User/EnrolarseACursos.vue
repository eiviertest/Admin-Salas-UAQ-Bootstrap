<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card text-center">
                    <h4 class="card-header">Enrolarse a Cursos</h4>
                        <div class="card-body">
                            <div class="vld-parent">
                                <loading :active.sync="isLoading"
                                        :can-cancel="false"
                                        :is-full-page="true"/>
                            </div>
                            <div class="row">
                                <div class="card col-md-3 m-5 border-info text-white bg-dark" v-for="curso in listaCursos" :key="curso.idCur" >
                                        <div class="card-header"><h5>{{curso.nomCur}}</h5> </div>
                                        <div class="card-body"> 
                                            <label> Requisitos: </label> 
                                            <h6>{{curso.reqCur}} </h6>
                                            <label>Fecha Inicio: </label>
                                            <h6>{{curso.fecInCur}}</h6>
                                            <label> Fecha Termino: </label>
                                            <h6>{{curso.fecFinCur}}</h6>
                                        </div>
                                        <div class="card-footer" ><button class="btn btn-primary" @click="enrolarseCurso(curso.idCur)"> Enrolarse a Curso </button></div>
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
            listaCursos: [],
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
            me.getCursos(page);
        },
        getCursos(page) {
            let me = this;
            axios.get('/curso?page=' + page).then(function (response) {
                me.listaCursos = response.data.cursos.data;
                me.pagination = response.data.pagination;
                me.isLoading = false;
            }).catch(function (error) {
                me.errores = error.data;
            });
        },
        enrolarseCurso(idCur){
            let me = this;
            me.isLoading = true;
            axios.post('/enrolarse',{'idCur':idCur}).then(function (response){
                if(response.data.code==2){
                    console.log('usted ya está enrolado');
                }
                else{
                    console.log('usted se enrolo');
                    me.getCursos(1);
                }
            }).catch(function (error){
                me.errores = error.data;
            })
        }
    },
    mounted() {
        this.getCursos(1);
    }
}
</script>