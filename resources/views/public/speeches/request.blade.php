@extends('layouts.app')
@section('content')
<div class="container">
  <h1 class="mb-1">Solicitar discurso – {{ $session->club->name }}</h1>
  <div class="text-muted mb-3">{{ \Carbon\Carbon::parse($session->date)->isoFormat('DD MMM YYYY') }}</div>

  <form method="POST" action="{{ route('public.speech.request.store', $session) }}">
    @csrf

    {{-- Honeypot (anti-spam) --}}
    <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off">

    <div class="mb-3">
      <label class="form-label">Tu nombre *</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
      @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Email (opcional)</label>
      <input type="email" name="email" value="{{ old('email') }}" class="form-control">
      @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Título del discurso *</label>
      <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
      @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Proyecto (opcional)</label>
      <input type="text" name="project" value="{{ old('project') }}" class="form-control">
    </div>

    <div class="mb-3">
      <label class="form-label">Notas (opcional)</label>
      <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
    </div>

    <button class="btn btn-success">Enviar solicitud</button>
    <a href="{{ route('public.sessions.show', $session) }}" class="btn btn-link">Volver</a>
  </form>
</div>
@endsection
