<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\ClubSession;
use App\Models\Speech;
use App\Models\Attendance;

class ReportsController extends Controller
{
    public function overview()
    {
        $totalMembers = Member::count();
        $sessionsThisMonth = ClubSession::whereMonth('date', now()->month)->whereYear('date', now()->year)->count();
        $speechesThisMonth = Speech::whereMonth('date', now()->month)->whereYear('date', now()->year)->count();
        $avgAttendance = Attendance::whereMonth('date', now()->month)->whereYear('date', now()->year)->avg('present');

        return view('admin.reports.overview', compact('totalMembers', 'sessionsThisMonth', 'speechesThisMonth', 'avgAttendance'));
    }
}
