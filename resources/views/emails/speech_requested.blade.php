<h3>Nueva solicitud de discurso</h3>
<p>Sesión: {{ $session->club->name }} – {{ $session->date }}</p>
<ul>
  <li>Nombre: {{ $payload['name'] }}</li>
  <li>Email: {{ $payload['email'] ?? '—' }}</li>
  <li>Título: {{ $payload['title'] }}</li>
  <li>Proyecto: {{ $payload['project'] ?? '—' }}</li>
  <li>Notas: {{ $payload['notes'] ?? '—' }}</li>
</ul>
