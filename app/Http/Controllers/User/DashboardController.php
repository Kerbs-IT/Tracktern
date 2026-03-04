<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function index(){
        $user = auth()->user();
        $activeGoal = $user->activeGoal;
        $totalHours = $user->totalHoursLogged();
        $recentRecords = $user->timeRecords()->latest()->take(5)->get();

        $todayRecord = $user->timeRecords()
            ->whereDate('date', today())
            ->first();

        $thisWeekHours = $user->timeRecords()
            ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('total_hours');

        $thisMonthHours = $user->timeRecords()
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('total_hours');

        return view('user.dashboard', compact(
            'activeGoal',
            'totalHours',
            'recentRecords',
            'todayRecord',
            'thisWeekHours',
            'thisMonthHours'
        ));
    }
}
