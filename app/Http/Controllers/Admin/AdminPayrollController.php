<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminPayrollController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();
        $year = $request->integer('year');
        $month = $request->integer('month');

        $payrolls = Payroll::with('user')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($year, fn ($q) => $q->where('period_year', $year))
            ->when($month, fn ($q) => $q->where('period_month', $month))
            ->orderByDesc('period_year')->orderByDesc('period_month')
            ->paginate(15)->withQueryString();

        return view('admin.gaji.index', compact('payrolls', 'status', 'year', 'month'));
    }

    public function create(): View
    {
        $users = User::orderBy('name')->get(['id','name']);
        $currentYear = now()->year;
        $currentMonth = now()->month;
        return view('admin.gaji.create', compact('users', 'currentYear', 'currentMonth'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'period_year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'period_month' => ['required', 'integer', 'min:1', 'max:12'],
            'amount' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
            'transfer_proof' => ['required', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf'],
        ]);

        // Prevent duplicate payroll for same user and period
        $exists = Payroll::where('user_id', $validated['user_id'])
            ->where('period_year', $validated['period_year'])
            ->where('period_month', $validated['period_month'])
            ->exists();
        if ($exists) {
            return back()->withInput()->with('status', 'Payroll untuk periode tersebut sudah ada.');
        }

        $transferProofPath = null;
        if ($request->hasFile('transfer_proof')) {
            $transferProofPath = $request->file('transfer_proof')->store('transfer_proofs', 'public');
        }

        Payroll::create([
            'user_id' => $validated['user_id'],
            'period_year' => $validated['period_year'],
            'period_month' => $validated['period_month'],
            'amount' => $validated['amount'],
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
            'transfer_proof_path' => $transferProofPath,
        ]);

        return redirect()->route('admin.payroll.index')->with('status', 'Payroll berhasil dibuat.');
    }

    public function markPaid(int $id): RedirectResponse
    {
        $p = Payroll::findOrFail($id);
        $p->status = 'paid';
        $p->paid_at = now();
        $p->save();
        return back()->with('status', 'Berhasil menandai sebagai dibayar.');
    }

    public function uploadProof(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'transfer_proof' => ['required', 'image', 'max:5120'],
        ]);
        $p = Payroll::findOrFail($id);
        $path = $request->file('transfer_proof')->store('transfer_proofs', 'public');
        $p->transfer_proof_path = $path;
        $p->save();
        return back()->with('status', 'Bukti transfer berhasil diunggah.');
    }

    public function generateSlip(int $id): RedirectResponse
    {
        $p = Payroll::with('user')->findOrFail($id);
        $html = view('pdf.slip', ['record' => $p, 'user' => $p->user])->render();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
        $fileName = 'slips/'.date('Y/m').'/slip_'.($p->user->username ?? $p->user->id).'_'.sprintf('%04d%02d', $p->period_year, $p->period_month).'.pdf';
        Storage::disk('public')->put($fileName, $pdf->output());
        $p->slip_pdf_path = $fileName;
        $p->save();
        return back()->with('status', 'Slip gaji berhasil dibuat.');
    }
}
