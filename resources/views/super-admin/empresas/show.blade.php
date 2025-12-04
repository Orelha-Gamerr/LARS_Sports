@extends('layouts.super-admin')

@section('page-title', 'Empresas')

@section('super-admin-content')


<div class="p-6 mt-10 items-center justify-center flex flex-col gap-4">
    <i class="fa-solid fa-spinner spin" style="font-size: 4rem;"></i>
    <h1>Funcionalidade em andamento</h1>
</div>

<style>
.spin {
    animation: spin 2s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>

@endsection
