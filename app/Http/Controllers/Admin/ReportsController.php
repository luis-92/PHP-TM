<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;   // ⬅️ IMPORTANTE
use App\Models\Member;
use App\Models\Club;
use App\Models\ClubSession;
use App\Models\Speech;
use App\Models\Attendance;

class ReportsController extends Controller
{
    public function overview()
    {
        $totalMembers     = Member::count();
        $totalClubs       = Club::count();
        $upcomingSessions = ClubSession::whereDate('session_date', '>=', now()->toDateString())->count();
        $totalSpeeches    = Speech::count();
        $totalAttendances = Attendance::count();

        return view('admin.reports.overview', compact(
            'totalMembers','totalClubs','upcomingSessions','totalSpeeches','totalAttendances'
        ));
    }
}
