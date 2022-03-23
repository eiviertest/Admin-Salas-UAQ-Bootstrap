@extends('layouts.app')
@section('contenido')
    <!-- Views Admin -->
    <template v-if="menu == 0">
        @can('Admin_Home')
            <solicitudes-admin/>
        @elsecan('User_Home')
            <solicitar-sala/>
        @endcan
    </template>
    <template v-if="menu == 1">
        <reportes/>
    </template>
    <template v-if="menu == 3">
        <crear-curso/>
    </template>
    <template v-if="menu == 4">
        <solicitud-curso-persona/>
    </template>
    <template v-if="menu == 5">
        <solicitudes-admin/>
    </template>
    <!-- Fin Views Admin -->
    <!-- Views User -->
    <template v-if="menu == 6">
        <solicitar-sala/>
    </template>
    <template v-if="menu == 7">
        <mis-solicitudes/>
    </template>
    <template v-if="menu == 8">
        <ver-cursos-user/>
    </template>
    <template v-if="menu == 9">
        <asistencia-cursos/>
    </template>
    <!-- Fin Views User -->
@endsection