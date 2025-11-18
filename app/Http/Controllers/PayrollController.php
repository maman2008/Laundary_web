<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::where('user_id', Auth::id())
            ->orderByDesc('period_year')
            ->orderByDesc('period_month')
            ->paginate(12);

        return view('payrolls.index', compact('payrolls'));
    }
}
