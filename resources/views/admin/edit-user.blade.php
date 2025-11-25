@extends('layouts.accueil');
@section('content')
<form action="/user/{{ $user->id}}/update" method="POST">
@csrf
@method('patch')
@include('admin.register')
</form>
@endsection