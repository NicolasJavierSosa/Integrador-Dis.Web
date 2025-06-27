@extends('app')
@section('tittle', 'AureaCursos - Inicio')
@push('css')
    <link rel="stylesheet" href="{{asset('css/inicios.css')}}" />
@endpush

@section('contenido')
    <!-- aca el contenido para agregar -->
@endsection

@push('scripts')
    <script src="{{asset('js/scripts.js')}}"></script>
@endpush