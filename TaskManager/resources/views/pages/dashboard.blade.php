@extends('layouts.app')

@section('content')
<div class="header">
    <div>
        <span>👤 Зашел: {{ Auth::user()->name }}</span>
    </div>
    {{-- <a href="{{ route('profile.edit') }}" class="btn btn-primary">Редактировать аккаунт</a> --}}
    <a href="{{ route('logout') }}" class="btn btn-secondary">Выход</a>
    <a class="btn btn-secondary"></a>
    <a class="btn btn-secondary"></a>
    <a class="btn btn-secondary"></a>
</div>
