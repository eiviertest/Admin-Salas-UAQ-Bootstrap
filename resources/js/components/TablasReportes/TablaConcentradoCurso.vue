<template>
    <div class="container">
        <table class="table">
            <thead class="h5"> 
                <tr>
                    <th style="text-align: center" v-for="encabezado in encabezados" :key="encabezado.id">
                        {{ encabezado.nombre }}   
                    </th>
                </tr>
            </thead>
            <tbody class="h5">
                <tr v-for="row in arrayData" :key="row.id"> 
                    <td align="center" v-text="row.nombre"></td>
                    <td align="center" v-text="row.nomArea"></td>
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