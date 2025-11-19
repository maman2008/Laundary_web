<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminIzinController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $requests = EmployeeRequest::with('user')
            ->where('type', 'izin_tidak_masuk')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.izin-tidak-masuk.index', compact('requests', 'status'));
    }

    public function accept(int $id): RedirectResponse
    {
        $req = EmployeeRequest::where('type', 'izin_tidak_masuk')->findOrFail($id);
        $req->status = 'accepted';
        $req->reviewed_by = Auth::id();
        $req->reviewed_at = now();
        $req->save();

        return back()->with('status', 'Izin diterima.');
    }

    public function reject(int $id): RedirectResponse
    {
        $req = EmployeeRequest::where('type', 'izin_tidak_masuk')->findOrFail($id);
        $req->status = 'rejected';
        $req->reviewed_by = Auth::id();
        $req->reviewed_at = now();
        $req->save();

        return back()->with('status', 'Izin ditolak.');
    }
}
