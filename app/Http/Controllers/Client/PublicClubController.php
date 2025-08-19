<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Club;

class PublicClubController extends Controller
{
    public function index()
    {
        $clubs = Club::orderBy('name')->paginate(12);
        return view('public.clubs.index', compact('clubs'));
    }

    public function show(Club $club)
    {
        return view('public.clubs.show', compact('club'));
    }
}
