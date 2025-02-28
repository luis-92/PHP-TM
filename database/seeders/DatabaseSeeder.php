<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Club;
use App\Models\Member;
use App\Models\Session;
use App\Models\Speech;
use App\Models\SessionRole;
use App\Models\Evaluation;
use App\Models\Vote;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear un usuario administrador de prueba
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Cambia esto por una contraseña segura
        ]);

        // Crear un club de ejemplo
        $club = Club::create([
            'name' => 'Toastmasters Innovadores',
            'description' => 'Club de oratoria y liderazgo.',
            'location' => 'Ciudad de México',
            'contact_email' => 'contacto@toastmasters.com',
            'active' => true
        ]);

        // Crear miembros de prueba
        $member1 = Member::create([
            'club_id' => $club->id,
            'first_name' => 'Juan',
            'last_name' => 'Pérez',
            'email' => 'juan@example.com',
            'phone_number' => '5551234567',
            'role' => 'Presidente',
            'active' => true
        ]);

        $member2 = Member::create([
            'club_id' => $club->id,
            'first_name' => 'Ana',
            'last_name' => 'García',
            'email' => 'ana@example.com',
            'phone_number' => '5559876543',
            'role' => 'Evaluador Gramatical',
            'active' => true
        ]);

        // Crear una sesión de prueba
        $session = Session::create([
            'club_id' => $club->id,
            'session_date' => now(),
            'agenda' => 'Reunión semanal de Toastmasters',
            'notes' => 'Primera sesión del año',
            'status' => 'planned'
        ]);

        // Crear un discurso de prueba
        $speech = Speech::create([
            'member_id' => $member1->id,
            'session_id' => $session->id,
            'title' => 'Cómo mejorar tu oratoria',
            'content' => 'El discurso trata sobre las mejores prácticas para hablar en público...',
            'best_speech' => false
        ]);

        // Asignar roles en la sesión
        $sessionRole = SessionRole::create([
            'session_id' => $session->id,
            'member_id' => $member2->id,
            'role_type' => 'Evaluador Gramatical',
            'is_claimed' => true,
            'feedback' => 'Evaluación de gramática en la sesión.'
        ]);

        // Crear una evaluación para el Evaluador Gramatical
        Evaluation::create([
            'session_role_id' => $sessionRole->id,
            'clarity' => 5,
            'vocal_variety' => 4,
            'eye_contact' => 5,
            'gestures' => 3,
            'audience_awareness' => 5,
            'comfort_level' => 4,
            'interest' => 5,
            'content_delivery' => 4,
            'general_comments' => 'Muy buen análisis gramatical, pero mejorar los gestos.'
        ]);

        // Crear una votación para el mejor discurso
        Vote::create([
            'session_id' => $session->id,
            'member_id' => $member2->id, // Ana vota
            'category' => 'Mejor Discurso',
            'nominee_id' => $member1->id, // Juan es nominado
            'reason' => 'Su discurso fue claro y motivador.'
        ]);
    }
}
