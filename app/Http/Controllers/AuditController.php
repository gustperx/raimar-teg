<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Audit;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Audit::class);

        $startDate = Carbon::now();
        $endDate = Carbon::now()->addDays(7);
        if (!empty($request->only('by_range')) && !empty($request->only('by_range')['by_range'])) {
            $range = $request->only('by_range')['by_range'];
            $startDate = Carbon::parse($range['startDate']);
            $endDate = Carbon::parse($range['endDate']);
        }

        $items = Audit::with('user.department')
            ->byUser($request->only('by_user'))
            ->byModule($request->only('by_module'))
            ->byMonthYear($request->only('by_month'))
            ->byRange($request->only('by_range'))
            ->orderBy('id', 'desc')
            ->paginate()->through(function ($item) {
                return [
                    'id' => $item->id,
                    'module' => $item->module,
                    'event' => $item->event,
                    'user' => $item->user->name ?? null,
                    'department' => $item->user->department->name ?? null,
                    'created_at' => $item->created_at->format('d/m/Y H:i'),
                ];
            });

        $users = User::getDepartmentList();

        return Inertia::render('Audits/Index', [
            'items' => $items,
            'filters' => [
                'by_user'   => $request->only('by_user'),
                'by_module' => $request->only('by_module'),
                'by_month'  => $request->only('by_month'),
                'by_range'  => json_encode([
                    'startDate' => $startDate->format('d/m/Y'), 
                    'endDate'   => $endDate->format('d/m/Y'),
                ])
            ],
            'users'   => $users,
            'modules' => Audit::getModules(),
        ]);
    }

}
