@extends('layouts.app')
@section('contenido')
    <!-- Views Admin -->
    <template v-if="menu == 0">
        @can('Admin_Home')
            <solicitudes-admin/>
        @elsecan('User_Home')
            <solicitar-sala/>
        @endcan
        <!--<inicio/>-->
    </template>
    <template v-if="menu == 1">
        <reportes/>
    </template>
    <template v-if="menu == 2">
        <ver-cursos/>
    </template>
    <template v-if="menu == 3">
        <crear-curso/>
    </template>
    <template v-if="menu == 4">
        <solicitudes-admin/>
    </template>
    <!-- Fin Views Admin -->
    <!-- Views User -->
    <template v-if="menu == 5">
        <ver-cursos-user/>
    </template>
    <template v-if="menu == 6">
        <mis-solicitudes/>
    </template>
    <template v-if="menu == 7">
        <solicitar-sala/>
    </template>
    <!-- Fin Views User -->
@endsection