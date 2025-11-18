<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminRequestController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $requests = EmployeeRequest::with('user')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.pengajuan.index', compact('requests', 'status'));
    }

    public function accept(int $id): RedirectResponse
    {
        $req = EmployeeRequest::findOrFail($id);
        $req->status = 'accepted';
        $req->reviewed_by = Auth::id();
        $req->reviewed_at = now();
        $req->save();

        return back()->with('status', 'Pengajuan diterima.');
    }

    public function reject(int $id): RedirectResponse
    {
        $req = EmployeeRequest::findOrFail($id);
        $req->status = 'rejected';
        $req->reviewed_by = Auth::id();
        $req->reviewed_at = now();
        $req->save();

        return back()->with('status', 'Pengajuan ditolak.');
    }
}
