<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-2">
                <button type="button" class="btn btn-outline-info" @click="mostrarModalCreate()"> Nuevo Registro </button>
                <crear v-if="showModelCreate" @close="closeModalCreate()" @sucessCreate="getArea(1);closeModalCreate()"> </crear>
            </div>  
            
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-primary text-white cabecera"> 
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
            dataArea: {}
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
    methods:{
        cambiarPagina(page){
            let me = this;
            me.pagination.current_page = page;
            me.getArea(page);
        },
        getArea(page) {
            let me = this;
            axios.get('/area?page=' + page).then(function (response) {
                me.areas = response.data.areas.data;
                me.pagination = response.data.pagination;
            }).catch(function (error) {
                me.errores = error.data;
            });
        },
        borrarRegistro(ide){
           let  me = this;
           if (confirm("¿Esta seguro de eliminar el registro?")){
               console.log(ide);
               axios.delete('/area/'+ide)
               .then(response=>{
                        me.getArea(1);
                    })
                    .catch(error=>{
                        console.log(error)
                    })
           }
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
