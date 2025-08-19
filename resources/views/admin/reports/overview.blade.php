@extends(backpack_view('blank'))

@section('content')
<div class="container-fluid">
  <h3>Resumen del Club</h3>
  <div class="row">
    <div class="col-md-3">
      <div class="card"><div class="card-body">
        <h5>Total de miembros</h5>
        <p class="card-text">{{ $totalMembers }}</p>
      </div></div>
    </div>
    <div class="col-md-3">
      <div class="card"><div class="card-body">
        <h5>Sesiones este mes</h5>
        <p class="card-text">{{ $sessionsThisMonth }}</p>
      </div></div>
    </div>
    <div class="col-md-3">
      <div class="card"><div class="card-body">
        <h5>Discursos este mes</h5>
        <p class="card-text">{{ $speechesThisMonth }}</p>
      </div></div>
    </div>
    <div class="col-md-3">
      <div class="card"><div class="card-body">
        <h5>Asistencia promedio</h5>
        <p class="card-text">{{ number_format(($avgAttendance ?? 0) * 100, 1) }}%</p>
      </div></div>
    </div>
  </div>
</div>
@endsection
