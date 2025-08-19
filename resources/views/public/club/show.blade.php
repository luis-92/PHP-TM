@extends('layouts.app')
@section('content')
<div class="container">
  <h1 class="mb-3">{{ $club->name }}</h1>
  <p>
    @if($club->location) <strong>Ubicación:</strong> {{ $club->location }}<br>@endif
    @if($club->meeting_days) <strong>Días:</strong> {{ $club->meeting_days }}<br>@endif
    @if($club->schedule) <strong>Horario:</strong> {{ $club->schedule }}<br>@endif
    @if($club->language) <strong>Idioma:</strong> {{ $club->language }}<br>@endif
  </p>
  <a href="{{ route('public.sessions.index', $club) }}" class="btn btn-primary">Ver próximas sesiones</a>
</div>
@endsection
