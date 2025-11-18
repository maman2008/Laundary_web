<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
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
