<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Device;
use App\Models\TestHistory;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $user = auth()->user();
        $orgId = $user ? $user->org_id : null;

        // Base Queries
        $employeeQuery = Employee::where('status', true);
        $deviceQuery = Device::query();
        $testHistoryQuery = TestHistory::query();

        // Apply Org Filter if applicable
        if ($orgId) {
            $employeeQuery->where('org_id', $orgId);
            
            // Devices don't have org_id directly, we map via OrgDevice
            $orgSerialNums = \App\Models\OrgDevice::where('org_id', $orgId)->pluck('serial_num');
            $deviceQuery->whereIn('serial_num', $orgSerialNums);
            
            $testHistoryQuery->where('org_id', $orgId);
        }

        // Summary Metrics
        $totalEmployees = $employeeQuery->count();
        
        // Active Devices (assume status = 1 means active)
        $activeDevices = (clone $deviceQuery)->where('status', 1)->count();
        
        // Total Tests Today
        $totalTestsToday = (clone $testHistoryQuery)->whereDate('testing_date', $today)->count();
        
        // Failed Tests Today (alcohol level > 0)
        $failedTestsToday = (clone $testHistoryQuery)->whereDate('testing_date', $today)
            ->where('alcohol_level', '>', 0)
            ->count();

        // Trends (Tests Volume over last 7 days)
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            
            $last7Days->push([
                'date' => $date->format('Y-m-d'),
                'label' => $date->locale('th')->minDayName,
                'tests' => (clone $testHistoryQuery)->whereDate('testing_date', $date)->count(),
                'fails' => (clone $testHistoryQuery)->whereDate('testing_date', $date)->where('alcohol_level', '>', 0)->count(),
            ]);
        }

        // Monitoring
        // Recent Infractions
        $recentInfractions = (clone $testHistoryQuery)->with('employee')
            ->where('alcohol_level', '>', 0)
            ->orderBy('testing_date', 'desc')
            ->take(5)
            ->get();

        // Device Health
        $deviceHealth = (clone $deviceQuery)->orderBy('lastseen_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalEmployees',
            'activeDevices',
            'totalTestsToday',
            'failedTestsToday',
            'last7Days',
            'recentInfractions',
            'deviceHealth'
        ));
    }
}
