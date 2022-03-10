<template>
    <!-- The Modal -->
<div class="modal" id="myModalUpdate" style="display: block;">
<div class="modal-dialog">
<div class="modal-content">
    <!-- Modal Header -->
    <div class="modal-header">
    <h4 class="modal-title">Editar Registro</h4>
    <button type="button" class="close btn btn-danger" @click="closeModelUpdate()" data-dismiss="modal">X</button>
    </div>
    <!-- Modal body -->
    <div class="modal-body">
        <form method="put" @submit.prevent="editarRegistro">
                    <div class="row">
                    <div class="col-12 mb-2">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" v-model="dataArea.nombre"> 
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
    <button type="button" @click="closeModelUpdate()" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</div>
</div>
</div>
    
</template>

<script>

export default({
    name:"actualizar-Registro",
    props: { 
        dataArea: Object,
    },
    data(){
        return{
            showModelUpdate: false,
        }
    },
    methods:{
        editarRegistro(){
        let me = this;
        axios.put('/area',{"nomArea":this.dataArea.nombre, "id":this.dataArea.ide})
                .then(response=>{
                    me.$emit('sucessUpdate');
                    this.closeModelUpdate();
                    // Alerta que notifica que todo salio correcto
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'El registro se ah actualizado con éxito',
                    showConfirmButton: false,
                    timer: 1200
                    });
                })
                .catch(error=>{
                    console.log(error);
                })
        },
        closeModelUpdate(){
            this.closeModelUpdate = false;
            this.$emit('close')
        }
    }
})
</script>