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
                <tr v-for="row in arrayData" :key="row.id"> 
                    <td v-text="row.nomCur"></td>
                    <td v-text="row.fecInCur"></td>
                    <td v-text="row.fecFinCur"></td>
                    <td v-text="row.cupCur"></td>
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