<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\DeviceScan;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DeviceScanController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:list histories', only: ['index']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole(['super-admin', 'admin']);

        $q = $request->get('q');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $scanType = $request->get('scan_type');
        $result = $request->get('result');

        $query = DeviceScan::with(['employee', 'organization']);

        // Scope to user's organization if not super-admin or admin
        if (!$isAdmin) {
            $query->where('org_id', $user->org_id);
        }

        // Search filter
        if ($q) {
            $query->where(function ($query) use ($q) {
                $query->where('device_id', 'like', "%$q%")
                    ->orWhereHas('employee', function ($query) use ($q) {
                        $query->where('first_name', 'like', "%$q%")
                            ->orWhere('last_name', 'like', "%$q%")
                            ->orWhere('emp_id', 'like', "%$q%");
                    });
            });
        }

        // Date filters
        if ($dateFrom) {
            $query->whereDate('scanned_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('scanned_at', '<=', $dateTo);
        }

        // Scan Type filter
        if ($scanType) {
            $query->where('scan_type', $scanType);
        }

        // Result filter
        if ($result) {
            $query->where('result', $result);
        }

        $scans = $query->orderByDesc('scanned_at')
            ->paginate(15)
            ->withQueryString();

        return view('devicescans.index', compact(
            'scans',
            'q',
            'dateFrom',
            'dateTo',
            'scanType',
            'result'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Reserved for future use
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Reserved for future use
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Reserved for future use
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Reserved for future use
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Reserved for future use
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Reserved for future use
    }
}
