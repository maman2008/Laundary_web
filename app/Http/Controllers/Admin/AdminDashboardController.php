<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\EmployeeRequest;
use App\Models\Payroll;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalAttendancesToday = Attendance::whereDate('check_in_at', now()->toDateString())->count();
        $lateToday = Attendance::whereDate('check_in_at', now()->toDateString())->where('is_late', true)->count();
        $pendingRequests = EmployeeRequest::where('status', 'pending')->count();
        $pendingPayrolls = Payroll::where('status', 'pending')->count();

        return view('admin.dashboard', compact('totalAttendancesToday', 'lateToday', 'pendingRequests', 'pendingPayrolls'));
    }
}
