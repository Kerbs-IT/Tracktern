<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    // app/Http/Controllers/Admin/DashboardController.php
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $activeUsers = User::where('role', 'user')
            ->where('is_active', true)
            ->count();

        $totalHoursLogged = TimeRecord::sum('total_hours');

        $usersNearingGoal = User::with('activeGoal')
            ->where('role', 'user')
            ->get()
            ->filter(function ($user) {
                $goal = $user->activeGoal;
                if (!$goal) return false;
                return $goal->progressPercentage() >= 80;
            });

        $recentActivity = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        $topPerformers = User::where('role', 'user')
            ->withSum('timeRecords', 'total_hours')
            ->orderByDesc('time_records_sum_total_hours')
            ->take(5)
            ->get();

        // Monthly trend data
        $monthlyTrend = TimeRecord::selectRaw('MONTH(date) as month, SUM(total_hours) as total')
            ->whereYear('date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'totalHoursLogged',
            'usersNearingGoal',
            'recentActivity',
            'topPerformers',
            'monthlyTrend'
        ));
    }
}
