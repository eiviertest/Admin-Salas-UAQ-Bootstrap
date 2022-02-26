<template>
    <div class="container">
        <table class="table">
            <thead> 
                <tr>
                    <th v-for="encabezado in encabezados" :key="encabezado.id">
                        {{ encabezado.nombre }}   
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in arrayData" :key="row.idSol"> 
                    <td v-text="row.nombre"></td>
                    <td v-text="row.nomEst"></td>
                    <td v-text="row.nomSala"></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        encabezados: Array,
        arrayData: Array,
    }
}
</script>