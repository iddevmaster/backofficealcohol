<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\AnonymousTest;
use Carbon\Carbon;
use App\Models\Organization;
use App\Models\Device;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use App\Helpers\HashidsHelper;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AnonymousTestController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:list anonymous-tests', only: ['index', 'show', 'receipt']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $q = $request->get('q');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $status = $request->get('status');

        $query = AnonymousTest::with(['organization', 'device']);

        if ($q) {
            $query->where(function ($query) use ($q) {
                $query->where('user_id', 'like', "%$q%")
                    ->orWhere('scan_type', 'like', "%$q%")
                    ->orWhereHas('device', function ($query) use ($q) {
                        $query->where('serial_num', 'like', "%$q%")
                            ->orWhere('model', 'like', "%$q%");
                    });
            });
        }

        if ($dateFrom) {
            $query->whereDate('scanned_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('scanned_at', '<=', $dateTo);
        }

        if ($status) {
            if ($status === 'pass') {
                $query->where('result', 'pass');
            } elseif ($status === 'fail') {
                $query->where('result', 'fail');
            }
        }

        $test = $query->orderByDesc('scanned_at')->paginate(15)->withQueryString();

        return view('anonymoustests.index', compact(
            'test',
            'q',
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $decryptedId = HashidsHelper::decode($id);
        if ($decryptedId === null) {
            abort(404, 'Invalid anonymous test record identifier.');
        }

        $history = AnonymousTest::with([
            'organization',
            'device'
        ])->findOrFail($decryptedId);

        return view('anonymoustests.show', compact('history'));
    }

    /**
     * Display the receipt page for an anonymous test record (route: anonymous-test/receipt/{id}).
     */
    public function receipt(string $id): View
    {
        return $this->show($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $decryptedId = HashidsHelper::decode($id);
        if ($decryptedId === null) {
            abort(404, 'Invalid anonymous test record identifier.');
        }

        $test = AnonymousTest::findOrFail($decryptedId);
        $test->delete();

        return redirect()->route('anonymous-tests.index')
            ->with('success', 'ลบข้อมูลสำเร็จ');
    }
}
