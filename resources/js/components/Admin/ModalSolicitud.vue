<template>
    <div class="modal" id="myModalUpdate" style="display: block;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detalles de la Solicitud - {{idSolicitud}}</h4>
                    <button type="button" class="close btn btn-danger" @click="closeModal()" data-dismiss="modal">X</button>
                </div>
                <div class="modal-body">
                    <div class="vld-parent">
                        <loading :active.sync="isLoading"
                                :can-cancel="false"
                                :is-full-page="true"/>
                    </div>
                    <form>
                        <div class="form-group row">
                            <div class="col-md-6" align="center">
                                <h5><font-awesome-icon icon="fa-solid fa-hashtag" /><strong> Solicitud: </strong>{{idSolicitud}}</h5>
                                <h5><font-awesome-icon icon="fa-solid fa-location-dot" /><strong> Sala: </strong>{{solicitud.sala}}</h5>
                                <h5><font-awesome-icon icon="fa-regular fa-calendar" /><strong> Fecha: </strong>{{solicitud.fecha}} </h5>
                                <h5><font-awesome-icon icon="fa-regular fa-clock" /><strong> Hora de Inicio: </strong>{{solicitud.horaIni}}</h5>
                                <h5><font-awesome-icon icon="fa-regular fa-clock" /><strong> Hora de Fin: </strong>{{solicitud.horaFin}}</h5>
                                <h5>
                                    <font-awesome-icon icon="fa-solid fa-layer-group" />
                                    <strong> Estado: </strong>
                                    <button v-if="solicitud.estado == 'Aceptada'" class="btn btn-success">{{solicitud.estado}} <font-awesome-icon icon="fa-solid fa-circle-check" /></button>
                                    <button v-if="solicitud.estado == 'En proceso'" class="btn btn-warning">{{solicitud.estado}} <font-awesome-icon icon="fa-solid fa-hourglass" /></button>
                                    <button v-if="solicitud.estado == 'Rechazada'" class="btn btn-danger">{{solicitud.estado}} <font-awesome-icon icon="fa-solid fa-circle-xmark" /></button>
                                </h5>
                            </div>
                            <div class="col-md-6" align="center">
                                <h5><font-awesome-icon icon="fa-solid fa-user" /><strong> Nombre: </strong>{{solicitud.nombre}}</h5>
                                <h5><font-awesome-icon icon="fa-regular fa-envelope" /><strong> Email: </strong>{{solicitud.email}}</h5>
                                <h5><font-awesome-icon icon="fa-solid fa-phone" /><strong> Telefono: </strong>{{solicitud.telefono}}</h5>
                                <h5 v-if="solicitud.tipoTel == 2">
                                    <font-awesome-icon icon="fa-solid fa-plus" />
                                    <strong> Extensión: </strong>{{solicitud.extension}}
                                </h5>
                                <h5><font-awesome-icon icon="fa-solid fa-flag" /><strong> Área: </strong>{{solicitud.area}}</h5>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="closeModal()" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>  
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default({
    components: {
        Loading
    },
    name:"Modal-Solicitud",
    props: { 
        idSolicitud: Number,
    },
    data(){
        return{
            solicitud:{
                'sala': '',
                'fecha': '',
                'horaIni': '',
                'horaFin': '',
                'nombre': '',
                'email' : '',
                'area' : '',
                'estado' : '',
                'telefono' : '',
                'tipoTel' : 0,
                'extension' : '',
            },
            errores: [],
            isLoading: true
        }
    },
    methods:{
        getDataSolicitud(idSolicitud){
            let me = this;
            axios.get('/getDataSolicitud/' + idSolicitud).then(response=>{
                me.solicitud = {
                    'sala': response.data[0].sala,
                    'fecha': response.data[0].fecha,
                    'horaIni': response.data[0].horaIni,
                    'horaFin': response.data[0].horaFin,
                    'nombre': response.data[0].nombre,
                    'email' : response.data[0].email,
                    'area' : response.data[0].nomArea,
                    'estado' : response.data[0].estado,
                    'telefono' : response.data[0].telPer,
                    'tipoTel' : response.data[0].tipoTel,
                    'extension' : response.data[0].extension,
                };
                me.isLoading = false;
            })
        },
        closeModal(){
            this.$emit('closeModal')
        }
    },
    mounted() {
        this.getDataSolicitud(this.idSolicitud);
    }
})
</script>