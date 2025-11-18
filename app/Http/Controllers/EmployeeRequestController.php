<?php

namespace App\Http\Controllers;

use App\Models\EmployeeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployeeRequestController extends Controller
{
    public function index()
    {
        $requests = EmployeeRequest::where('user_id', Auth::id())
            ->latest()->paginate(10);
        return view('requests.index', compact('requests'));
    }

    public function create()
    {
        return view('requests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:kerusakan_barang,kekurangan_barang'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'attachment' => ['nullable', 'file', 'max:5120'],
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('employee_requests', 'public');
        }

        EmployeeRequest::create([
            'user_id' => Auth::id(),
            'type' => $validated['type'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'attachment_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('requests.index')->with('status', 'Pengajuan berhasil dibuat.');
    }

    public function edit(int $id)
    {
        $req = EmployeeRequest::where('user_id', Auth::id())->findOrFail($id);
        return view('requests.edit', compact('req'));
    }

    public function update(Request $request, int $id)
    {
        $req = EmployeeRequest::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'type' => ['required', 'in:kerusakan_barang,kekurangan_barang'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'attachment' => ['nullable', 'file', 'max:5120'],
        ]);

        if ($request->hasFile('attachment')) {
            if ($req->attachment_path) {
                Storage::disk('public')->delete($req->attachment_path);
            }
            $req->attachment_path = $request->file('attachment')->store('employee_requests', 'public');
        }

        $req->type = $validated['type'];
        $req->title = $validated['title'];
        $req->description = $validated['description'] ?? null;
        $req->save();

        return redirect()->route('requests.index')->with('status', 'Pengajuan berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $req = EmployeeRequest::where('user_id', Auth::id())->findOrFail($id);
        if ($req->attachment_path) {
            Storage::disk('public')->delete($req->attachment_path);
        }
        $req->delete();
        return back()->with('status', 'Pengajuan berhasil dihapus.');
    }
}

