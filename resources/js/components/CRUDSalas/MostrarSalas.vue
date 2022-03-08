<template>
    <div class="container">
        <div class="row">
            <div class="vld-parent">
                        <loading :active.sync="isLoading"
                                :can-cancel="false"
                                :is-full-page="true"/>      
            </div> 
            <!-- TABLA PARA MOSTRAR LOS REGISTROS -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="cabecera"> 
                            <tr>
                            <th> Identificador </th>
                            <th> Nombre </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="dato in salas" :key="dato.id"> 
                                <td v-text="dato.ide">  </td>
                                <td v-text="dato.nombre">  </td> 
                            </tr>
                        </tbody>
                    </table>
                </div>            
        </div>
    </div>
</template>



<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css'

export default({
    name: "mostrarSalas",
    data (){
        return {
            salas: [],
            isLoading : true,
        }
    },
    components: {
        Loading
    },
    methods:{
        getSalas(){
            let me = this;
            axios.get('sala').then(function(response){
                console.log(response.data.salas.data);
                me.salas=response.data.salas.data;
                me.isLoading = false;
            }).catch(function(error){
                this.arrayErrores = error.data;
            });
        }
    },
    mounted(){
        this.getSalas();
    }
})
</script>
