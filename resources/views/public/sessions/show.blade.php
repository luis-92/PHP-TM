@extends('layouts.app')
@section('content')
<div class="container">
  <h1 class="mb-1">Agenda – {{ $session->club->name }}</h1>
  <div class="text-muted mb-3">{{ \Carbon\Carbon::parse($session->date)->isoFormat('DD MMM YYYY') }}</div>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <h4 class="mt-4">Discursos</h4>
  <ul>
    @forelse($session->speeches as $sp)
      <li>
        <strong>{{ $sp->title ?? 'Discurso' }}</strong>
        @if($sp->member) por {{ $sp->member->name }} @endif
        @if($sp->project) <small> ({{ $sp->project }})</small>@endif
      </li>
    @empty
      <li>No hay discursos programados aún.</li>
    @endforelse
  </ul>

  <h4 class="mt-3">Table Topics</h4>
  <ul>
    @forelse($session->tableTopics as $tt)
      <li>@if($tt->member) {{ $tt->member->name }} @else Participante @endif</li>
    @empty
      <li>No hay participaciones aún.</li>
    @endforelse
  </ul>

  <h4 class="mt-3">Roles de función</h4>
  <ul>
    @forelse($session->sessionFunctionaryRoleAssignments as $ra)
      <li><strong>{{ $ra->role_name ?? ($ra->functionaryRole->name ?? 'Rol') }}</strong>:
        @if($ra->member) {{ $ra->member->name }} @else (vacante) @endif
      </li>
    @empty
      <li>Aún no hay roles asignados.</li>
    @endforelse
  </ul>

  <a href="{{ route('public.speech.request.create', $session) }}" class="btn btn-primary mt-3">
    Quiero dar un discurso
  </a>
</div>
@endsection
