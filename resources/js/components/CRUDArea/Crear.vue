<template>  
<!-- The Modal -->
<div class="modal" id="myModal" style="display: block;">
<div class="modal-dialog">
<div class="modal-content">
    <!-- Modal Header -->
    <div class="modal-header">
    <h4 class="modal-title">Crear Nuevo Registro</h4>
    <button type="button" class="close btn btn-danger" @click="closeModelCreate()" data-dismiss="modal">X</button>
    </div>
    <!-- Modal body -->
    <div class="modal-body">
        <form method="post" @submit.prevent="crear">
                    <div class="row">
                    <div class="col-12 mb-2">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" v-model="registro.nombre"> 
                    </div>
                    </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
        </form> 
    </div>
    <!-- Modal footer -->
    <div class="modal-footer">
    <button type="button" @click="closeModelCreate()" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</div>
</div>
</div>             
</template>

<script>

export default({
    name:"crear-Registro",
    data(){
        return{
            registro:{
                nombre:""
            },
            //showModel : false
        }
    },
    methods:{
        crear(){
        axios.post('/area',{"nomArea":this.registro.nombre})
            .then(response=>{
                this.$emit('sucessCreate');
                // Alerta que notifica que todo salio correcto
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'El registro se ah realizado con éxito',
                showConfirmButton: false,
                timer: 1200
                })
            })
            .catch(error=>{
                console.log(error)
            })
        },
        closeModelCreate(){
            this.showModel = false;
            this.$emit('close')
        }
    }
})
</script>
