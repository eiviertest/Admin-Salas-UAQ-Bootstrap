<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-2">
                <button type="button" class="btn btn-info" @click="mostrarModalCreate()"> Nuevo Registro </button>
                <crear v-if="showModelCreate" @close="closeModalCreate()" @sucessCreate="getArea(1);closeModalCreate()"> </crear>
            </div> 
            <div class="vld-parent">
                        <loading :active.sync="isLoading"
                                :can-cancel="false"
                                :is-full-page="true"/>      
            </div> 
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="cabecera"> 
                            <tr>
                            <th> Identificador </th>
                            <th> Nombre </th>
                            <th> Acciones </th>
                            </tr>
                        </thead>
                        <tbody class="cuerpo">
                            <tr v-for="dato in areas" :key="dato.id"> 
                                <td v-text="dato.ide">  </td>
                                <td v-text="dato.nombre">  </td> 
                                <td>
                                    <a type="button" v-on:click="editarRegistro(dato)" class="btn btn-primary"> Actualizar </a>
                                    <a type="button" v-on:click="borrarRegistro(dato.ide)" class="btn btn-danger"> Eliminar </a>
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
            <editar :dataArea="dataArea" v-if="showModelUpdate" @close="closeModalUpdate();getArea()" @sucessUpdate="getArea(1)"> </editar>          
        </div>
    </div>
</template>



<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default({
    name: "mostrarAreas",
    data (){
        return {
            areas: [],
            showModelCreate: false,
            showModelUpdate: false,
            pagination: {
                'total': 0, 
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0
            },
            offset: 2,
            dataArea: {},
            isLoading : true,
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
    methods:{
        cambiarPagina(page){
            let me = this;
            me.pagination.current_page = page;
            me.isLoading = true;
            me.getArea(page);
        },
        getArea(page) {
            let me = this;
            axios.get('/area?page=' + page).then(function (response) {
                me.areas = response.data.areas.data;
                me.pagination = response.data.pagination;
                me.isLoading = false;
            }).catch(function (error) {
                me.errores = error.data;
            });
        },
        borrarRegistro(ide){
            Swal.fire({
                title: 'Estas seguro?',
                text: "Una vez borrado no se podrán revertir los cambios!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, borrar registro!'
                }).then((result) => {
                if (result.isConfirmed) {
                    // Petición para eliminar el registro
                    let  me = this;
                    me.isLoading = true;
                    axios.delete('/area/'+ide)
                        .then(response=>{
                                me.getArea(1);
                                //Mensaje de eliminación 
                                Swal.fire(
                                'Borrado!',
                                'El registro ha sido eliminado exitosamente.',
                                'success'
                                )
                            })
                        .catch(error=>{
                            console.log(error)
                            // Alerta que notifica que hay un error
                            Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'El area que intentar borras está utilizada por un usuario',
                            showConfirmButton: false,
                            timer: 1500
                            })
                            me.isLoading = false;
                        })
                }
            })
            /*
            this.$swal({
                title: 'Estás seguro?',
                text: "Uná vez borrado no se podrán revertir los cambios!",
                icon: 'warning',
                buttons: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                
                // Petición para eliminar el registro
                let  me = this;
                me.isLoading = true;
                axios.delete('/area/'+ide)
                    .then(response=>{
                            me.getArea(1);
                        })
                    .catch(error=>{
                        console.log(error)
                    })
                    // Mensaje de confirmación
                    swal("!Eliminado exitosamente¡",{
                        icon: "success",
                    });
                } else {
                    //Mensaje de cancelación
                    swal ('Operación cancelada')
                }
            }) */
        },
        mostrarModalCreate(){
            this.showModelCreate = true;
        },
        mostrarModalUpdate(){
            this.showModelUpdate = true; 
        },
        closeModalCreate(){
            this.showModelCreate = false;
        },
         closeModalUpdate(){
            this.showModelUpdate = false;
        },
        editarRegistro(datos){
            let me = this;
            me.dataArea = datos;
            this.mostrarModalUpdate();
        }
    },
    mounted(){
        this.getArea(1);
    }
})
</script>
