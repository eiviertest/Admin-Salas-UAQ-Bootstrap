@extends('layouts.app')
@section('contenido')
    <!-- Views Admin -->
    <template v-if="menu == 0">
        <inicio/>
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
        <crear-varios-cursos/>
    </template>
    <template v-if="menu == 5">
        <solicitudes-admin/>
    </template>
    <!-- Fin Views Admin -->
    <!-- Views User -->
    <template v-if="menu == 6">
        <ver-cursos-user/>
    </template>
    <template v-if="menu == 7">
        <mis-solicitudes/>
    </template>
    <template v-if="menu == 8">
        <solicitar-sala/>
    </template>
    <!-- Fin Views User -->
@endsection