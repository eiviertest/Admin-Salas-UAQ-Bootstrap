<template>
    <div class="container">
        <div class="row">
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

export default({
    name: "mostrarSalas",
    data (){
        return {
            salas: []
        }
    },
    methods:{
        getSalas(){
            let me = this;
            axios.get('sala').then(function(response){
                console.log(response.data.salas.data);
                me.salas=response.data.salas.data;
                
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
