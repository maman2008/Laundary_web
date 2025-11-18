<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminAttendanceController extends Controller
{
    public function index(Request $request): View
    {
        $from = $request->string('from')->toString();
        $until = $request->string('until')->toString();
        $hanyaTelat = $request->boolean('hanya_telat');

        $query = Attendance::query()->with('user')->orderByDesc('check_in_at');

        $query->when($from, fn (Builder $q) => $q->whereDate('check_in_at', '>=', $from));
        $query->when($until, fn (Builder $q) => $q->whereDate('check_in_at', '<=', $until));
        $query->when($hanyaTelat, fn (Builder $q) => $q->where('is_late', true));

        /** @var LengthAwarePaginator $attendances */
        $attendances = $query->paginate(15)->withQueryString();

        return view('admin.absensi.index', compact('attendances', 'from', 'until', 'hanyaTelat'));
    }
}
