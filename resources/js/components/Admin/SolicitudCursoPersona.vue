<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header">Solicitudes para Enrolarse a Cursos</h4>
                    <div class="card-body">
                    <div class="vld-parent">
                        <loading :active.sync="isLoading"
                                :can-cancel="false"
                                :is-full-page="true"/>
                    </div>
                        <table class="table">
                            <thead class="h5"> 
                                <tr>
                                    <th style="text-align: center" scope="col">Nombre</th>
                                    <th style="text-align: center" scope="col">Área/Facultad/Institución</th>
                                    <th style="text-align: center" scope="col">Contacto</th>
                                    <th style="text-align: center" scope="col">Curso</th>
                                    <th style="text-align: center" scope="col">Estado</th>
                                    <th style="text-align: center" scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="h5">
                                <tr v-for="curso_persona in lista_cursos_persona" :key="curso_persona.idPer.toString() + curso_persona.idCur.toString()"> 
                                    <td align="center" v-text="curso_persona.nombre"></td>
                                    <td align="center" v-text="curso_persona.nomArea"></td>
                                    <td align="center" v-text="curso_persona.telPer"></td>
                                    <td align="center" v-text="curso_persona.nomCur"></td>
                                    <td align="center" v-text="curso_persona.estatus"></td>
                                    <td align="center" v-if="curso_persona.estatus == 'En proceso'">
                                        <button class="btn btn-success" v-on:click="aceptarUsuario(curso_persona.idPer, curso_persona.idCur)">Aceptar <font-awesome-icon icon="fa-solid fa-check" /></button>
                                        <button class="btn btn-danger" v-on:click="rechazarUsuario(curso_persona.idPer, curso_persona.idCur)">Rechazar <font-awesome-icon icon="fa-solid fa-ban" /></button>
                                    </td>
                                    <td align="center" v-else>
                                        <label class="form-control-label">Sin acción disponible</label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
</template>
<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    data() {
        return {
            lista_cursos_persona: [],
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
            me.getListaCursoPersona(page);
        },
        getListaCursoPersona(page) {
            let me = this;
            axios.get('/lista_curso_persona?page=' + page).then(function (response) {
                me.lista_cursos_persona = response.data.lista_cursos_persona.data;
                me.pagination = response.data.pagination;
                me.isLoading = false;
            }).catch(function (error) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Fallo en el sistema.'
                });
            });
        },
        aceptarUsuario(idPer, idCur){
            let me = this;
            me.isLoading = true;
            axios.put('/aceptar_persona_curso',{
                    'idPer': idPer,
                    'idCur': idCur
                }).then(function (response) {
                    if(response.data.code == 1) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'El usuario ha sido aceptado',
                            showConfirmButton: false,
                            timer: 1200
                        });
                        me.getListaCursoPersona(1);
                    }else{
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: 'El cupo del curso ha sido alcanzado.'
                        });
                        me.isLoading = false;
                    }
                }).catch( function (error) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Fallo en el sistema.'
                    });
            });
        },
        rechazarUsuario(idPer, idCur){
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Una vez rechazado no se podrán revertir los cambios!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, rechazar registro!'
                }).then((result) => {
                if (result.isConfirmed) {
                    // Petición para eliminar el registro
                    let me = this;
                    me.isLoading = true;
                    axios.put('/rechazar_persona_curso',{
                            'idPer': idPer,
                            'idCur': idCur,
                        }).then(function (response) {
                            me.getListaCursoPersona(1);
                             //Mensaje de eliminación 
                            Swal.fire(
                                'Rechazado!',
                                'El registro ha sido rechazado correctamente.',
                                'success'
                            )
                        }).catch( function (error) {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Fallo en el sistema.'
                            });
                        })
                        .catch(error=>{
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Fallo en el sistema.'
                            });
                        })
                }
            })
        }
    },
    mounted() {
        this.getListaCursoPersona(1);
        
    }
}
</script>