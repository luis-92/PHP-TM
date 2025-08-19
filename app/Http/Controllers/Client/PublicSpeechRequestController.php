<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClubSession;
use App\Models\Speech;

class PublicSpeechRequestController extends Controller
{
    public function create(ClubSession $session)
    {
        return view('public.speeches.request', compact('session'));
    }

    public function store(Request $request, ClubSession $session)
    {
        // Honeypot anti-spam
        if ($request->filled('website')) {
            return back()->withErrors(['name' => 'Error de validación.'])->withInput();
        }

        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'nullable|email|max:255',
            'title'  => 'required|string|max:255',
            'project'=> 'nullable|string|max:255',
            'notes'  => 'nullable|string|max:500',
        ]);

        // IMPORTANTE: asegúrate que Speech permita asignación masiva de estos campos.
        // En App\Models\Speech agrega: protected $guarded = [];
        Speech::create([
            'club_session_id' => $session->id,
            'title'   => $data['title'],
            'project' => $data['project'] ?? null,
            'notes'   => "Solicitado por: {$data['name']}"
                . (!empty($data['email']) ? " ({$data['email']})" : "")
                . (!empty($data['notes']) ? " | Notas: {$data['notes']}" : ""),
        ]);

        // (Opcional) Enviar correo al VP-Education
        // \Mail::to(config('mail.to_vpe', 'admin@example.com'))
        //   ->send(new \App\Mail\SpeechRequested($session, $data));

        return redirect()->route('public.sessions.show', $session)
            ->with('status', '¡Solicitud enviada! El comité confirmará tu turno.');
    }
}
