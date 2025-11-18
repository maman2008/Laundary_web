<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji {{ $user->name }} - {{ sprintf('%04d-%02d', $record->period_year, $record->period_month) }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; color: #111827; }
        .container { padding: 16px; }
        .header { display:flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .brand { font-size: 18px; font-weight: bold; color: #111827; }
        .muted { color: #6b7280; }
        .card { border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; margin-bottom: 10px; }
        .row { display:flex; justify-content: space-between; margin: 4px 0; }
        .label { color: #6b7280; }
        .value { font-weight: 600; }
        .total { font-size: 16px; font-weight: 700; }
        .footer { margin-top: 16px; font-size: 11px; color: #6b7280; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="brand">Laundry HR</div>
        <div class="muted">Slip Gaji • Periode {{ sprintf('%04d-%02d', $record->period_year, $record->period_month) }}</div>
    </div>

    <div class="card">
        <div class="row"><div class="label">Nama</div><div class="value">{{ $user->name }}</div></div>
        <div class="row"><div class="label">Username</div><div class="value">{{ $user->username ?? '-' }}</div></div>
        <div class="row"><div class="label">Email</div><div class="value">{{ $user->email }}</div></div>
    </div>

    <div class="card">
        <div class="row"><div class="label">Periode</div><div class="value">{{ sprintf('%04d-%02d', $record->period_year, $record->period_month) }}</div></div>
        <div class="row"><div class="label">Status</div><div class="value">{{ ucfirst($record->status) }}</div></div>
        <div class="row"><div class="label">Dibayar</div><div class="value">{{ $record->paid_at ? $record->paid_at->format('Y-m-d H:i') : '-' }}</div></div>
    </div>

    <div class="card">
        <div class="row"><div class="label">Nominal</div><div class="total">Rp {{ number_format($record->amount, 0, ',', '.') }}</div></div>
        @if(!empty($record->notes))
            <div class="row" style="margin-top:8px"><div class="label">Catatan</div><div class="value">{{ $record->notes }}</div></div>
        @endif
    </div>

    <div class="footer">
        Dokumen ini dihasilkan otomatis oleh sistem Laundry HR.
    </div>
</div>
</body>
</html>
