<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header">Crear Cursos</h4>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="form-control-label" for="text-input">Cantidad de Cursos:</label>
                                <select class="form-select" v-model="eleccion">
                                    <option value=0 selected disabled>Seleccione una opción...</option>
                                    <option value=1>Crear Un Curso</option>
                                    <option value=2>Crear Varios Cursos</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <br>
                <div class="card" v-if="mostrarElementoUnCurso">
                    <h4 class="card-header">Crear Un Curso</h4>

                    <div class="card-body">
                        Aqui aparecera el Formulario para Crear Un Curso!
                    </div>
                </div>
                <div class="card" v-if="mostrarElementoVariosCursos">
                    <h4 class="card-header">Crear Varios Cursos</h4>

                    <div class="card-body">
                        Aqui aparecera el Formulario para Crear Varios Cursos!
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    data(){
        return {
            mostrarElementoUnCurso: false,
            mostrarElementoVariosCursos: false,
            eleccion: 0
        }
    },
    watch: {
        eleccion: function (val) {
            if(val == 1) {
                //Crear Un Curso
                this.mostrarElementoUnCurso = true;
                this.mostrarElementoVariosCursos = false;
            }else if(val == 2) {
                //Crear Varios Cursos
                this.mostrarElementoUnCurso = false;
                this.mostrarElementoVariosCursos = true;
            } {
                console.log('Sin elección.')
            }
        },
    }
}
</script>