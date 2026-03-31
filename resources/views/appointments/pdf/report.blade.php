<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; }
        .header { background: #2563eb; color: white; padding: 25px 30px; }
        .header h1 { font-size: 20px; font-weight: bold; }
        .header p { font-size: 12px; opacity: 0.85; margin-top: 4px; }
        .filters { padding: 12px 30px; background: #f3f4f6; font-size: 11px; color: #6b7280; border-bottom: 1px solid #e5e7eb; }
        .content { padding: 20px 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f9fafb; padding: 10px 12px; text-align: left; font-size: 11px; color: #6b7280; text-transform: uppercase; border-bottom: 2px solid #e5e7eb; }
        td { padding: 10px 12px; border-bottom: 1px solid #f3f4f6; font-size: 12px; }
        tr:nth-child(even) td { background: #f9fafb; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: bold; }
        .badge-confirmed { background: #d1fae5; color: #065f46; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
        .badge-completed { background: #dbeafe; color: #1e40af; }
        .summary { display: table; width: 100%; margin-bottom: 20px; }
        .summary-cell { display: table-cell; text-align: center; padding: 15px; background: #f9fafb; border: 1px solid #e5e7eb; }
        .summary-num { font-size: 22px; font-weight: bold; color: #2563eb; }
        .summary-label { font-size: 11px; color: #6b7280; margin-top: 4px; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏥 Appointments Report</h1>
        <p>Generated on {{ now()->format('F j, Y \a\t H:i') }}</p>
    </div>

@if($request->date || $request->date_from || $request->date_to || $request->status)
<div class="filters">
    Filters:
    @if($request->date) Date: {{ $request->date }} @endif
    @if($request->date_from) From: {{ $request->date_from }} @endif
    @if($request->date_to) To: {{ $request->date_to }} @endif
    @if($request->status) Status: {{ ucfirst($request->status) }} @endif
</div>
@endif

    <div class="content">
        {{-- Summary --}}
        <div class="summary">
            <div class="summary-cell">
                <div class="summary-num">{{ $appointments->count() }}</div>
                <div class="summary-label">Total</div>
            </div>
            <div class="summary-cell">
                <div class="summary-num">{{ $appointments->where('status', 'confirmed')->count() }}</div>
                <div class="summary-label">Confirmed</div>
            </div>
            <div class="summary-cell">
                <div class="summary-num">{{ $appointments->where('status', 'pending')->count() }}</div>
                <div class="summary-label">Pending</div>
            </div>
            <div class="summary-cell">
                <div class="summary-num">{{ $appointments->where('status', 'completed')->count() }}</div>
                <div class="summary-label">Completed</div>
            </div>
            <div class="summary-cell">
                <div class="summary-num">{{ $appointments->where('status', 'cancelled')->count() }}</div>
                <div class="summary-label">Cancelled</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->id }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>{{ $appointment->start_time }}</td>
                    <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                    <td>Dr. {{ $appointment->doctor->user->name }}</td>
                    <td>{{ ucfirst($appointment->type) }}</td>
                    <td><span class="badge badge-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span></td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center; color:#9ca3af; padding:20px;">No appointments found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">Clinic Booking System — Confidential Report</div>
    </div>
</body>
</html>