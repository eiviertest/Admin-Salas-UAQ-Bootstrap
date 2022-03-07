<template>
    <div class="modal" id="myModalUpdate" style="display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{accion}}</h4>
                    <button type="button" class="close btn btn-danger" @click="closeModal()" data-dismiss="modal">X</button>
                </div>
                <div class="modal-body">
                    <form method="put">
                    </form> 
                </div>
                <div class="modal-footer">
                    <button type="button" @click="closeModal()" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>  
</template>

<script>

export default({
    name:"RU-Cuso",
    props: { 
        accion: String,
        idCurso: Number
    },
    data(){
        return{
            curso: {},
        }
    },
    methods:{
        getDataCurso(idCurso){
            let me = this;
            axios.get('/getDataCurso/' + idCurso).then(response=>{
                me.curso = response.data.curso;
            })
        },
        closeModal(){
            this.$emit('closeModal')
        }
    },
    mounted() {
        this.getDataCurso(this.idCurso);
    }
})
</script>