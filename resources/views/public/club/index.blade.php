@extends('layouts.app')
@section('content')
<div class="container">
  <h1 class="mb-3">Clubs</h1>
  <div class="row">
    @foreach($clubs as $club)
      <div class="col-md-4 mb-3">
        <div class="card h-100">
          <div class="card-body">
            <h5>{{ $club->name }}</h5>
            <p class="mb-2">
              @if($club->location) <small>{{ $club->location }}</small><br>@endif
              @if($club->meeting_days) <small>Días: {{ $club->meeting_days }}</small>@endif
            </p>
            <a href="{{ route('public.clubs.show', $club) }}" class="btn btn-primary btn-sm">Ver club</a>
            <a href="{{ route('public.sessions.index', $club) }}" class="btn btn-outline-secondary btn-sm">Próximas sesiones</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <div class="mt-3">{{ $clubs->links() }}</div>
</div>
@endsection
