<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\ClubSession;

class PublicSessionController extends Controller
{
    public function index(Club $club)
    {
        $sessions = $club->clubSessions()
            ->whereDate('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->paginate(10);

        return view('public.sessions.index', compact('club','sessions'));
    }

    public function show(ClubSession $session)
    {
        $session->load([
            'club',
            'speeches.member',
            'tableTopics.member',
            'sessionFunctionaryRoleAssignments.member',
        ]);

        return view('public.sessions.show', compact('session'));
    }
}
