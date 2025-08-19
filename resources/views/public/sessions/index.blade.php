@extends('layouts.app')
@section('content')
<div class="container">
  <h1 class="mb-3">Sesiones de {{ $club->name }}</h1>
  <ul class="list-group">
    @forelse($sessions as $s)
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <strong>{{ \Carbon\Carbon::parse($s->date)->isoFormat('DD MMM YYYY') }}</strong>
          @if($s->session_type) <span class="text-muted"> · {{ $s->session_type }}</span>@endif
          @if($s->location) <div><small>{{ $s->location }}</small></div>@endif
        </div>
        <a href="{{ route('public.sessions.show', $s) }}" class="btn btn-sm btn-outline-primary">Ver agenda</a>
      </li>
    @empty
      <li class="list-group-item">No hay sesiones próximas.</li>
    @endforelse
  </ul>
  <div class="mt-3">{{ $sessions->links() }}</div>
</div>
@endsection
