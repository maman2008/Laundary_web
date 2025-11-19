<?php

namespace App\Http\Controllers;

use App\Models\EmployeeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $status = $request->string('status')->toString();

        $query = \App\Models\EmployeeRequest::where('user_id', Auth::id())
            ->where('type', 'izin_tidak_masuk');

        if ($status) {
            $query->where('status', $status);
        }

        $requests = $query->latest()->paginate(10)->withQueryString();

        return view('izin.index', compact('requests', 'status'));
    }

    public function create()
    {
        return view('izin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => ['required', 'in:sakit,pribadi,lainnya'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'description' => ['nullable', 'string'],
            'attachment' => ['nullable', 'file', 'max:5120'],
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('employee_requests', 'public');
        }

        EmployeeRequest::create([
            'user_id' => Auth::id(),
            'type' => 'izin_tidak_masuk',
            'title' => 'Izin Tidak Masuk - '.ucfirst($validated['kategori']),
            'description' => $validated['description'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'attachment_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('izin.index')->with('status', 'Izin tidak masuk berhasil diajukan.');
    }
}
