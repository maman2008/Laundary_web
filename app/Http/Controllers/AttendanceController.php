<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function create()
    {
        return view('attendance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo_data' => ['required', 'string'],
            'lat' => ['nullable', 'numeric'],
            'lng' => ['nullable', 'numeric'],
        ]);

        $user = Auth::user();

        // Decode and store photo
        $data = $validated['photo_data'];
        if (preg_match('/^data:image\/(png|jpeg);base64,/', $data, $matches)) {
            $extension = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
            $data = substr($data, strpos($data, ',') + 1);
            $binary = base64_decode($data);
            $path = 'attendance/'.date('Y/m/d').'/'.uniqid('absen_').'.'.$extension;
            Storage::disk('public')->put($path, $binary);
            $photoPath = 'storage/'.$path;
        } else {
            return back()->withErrors(['photo_data' => 'Invalid image data'])->withInput();
        }

        $now = Carbon::now();
        $workStart = Carbon::createFromTimeString('09:00:00');
        $isLate = $now->gt($workStart);

        Attendance::create([
            'user_id' => $user->id,
            'check_in_at' => $now,
            'photo_path' => $photoPath,
            'lat' => $validated['lat'] ?? null,
            'lng' => $validated['lng'] ?? null,
            'is_late' => $isLate,
        ]);

        return redirect()->route('dashboard')->with('status', 'Absen berhasil dicatat.');
    }

    public function checkout(Request $request)
    {
        $userId = Auth::id();
        $today = Carbon::today();
        $attendance = Attendance::where('user_id', $userId)
            ->whereDate('check_in_at', $today)
            ->whereNull('check_out_at')
            ->latest('check_in_at')
            ->first();

        if (! $attendance) {
            return back()->withErrors(['checkout' => 'Tidak menemukan data absen hari ini untuk checkout.']);
        }

        $attendance->check_out_at = Carbon::now();
        $attendance->save();

        return redirect()->route('dashboard')->with('status', 'Checkout berhasil dicatat.');
    }
}
