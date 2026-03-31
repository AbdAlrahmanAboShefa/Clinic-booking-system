<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #1f2937; background: #fff; }
        .header { background: #2563eb; color: white; padding: 30px 40px; }
        .header h1 { font-size: 24px; font-weight: bold; }
        .header p { font-size: 13px; opacity: 0.85; margin-top: 4px; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .badge-confirmed { background: #d1fae5; color: #065f46; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
        .badge-completed { background: #dbeafe; color: #1e40af; }
        .content { padding: 30px 40px; }
        .section { margin-bottom: 24px; }
        .section-title { font-size: 14px; font-weight: bold; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e5e7eb; padding-bottom: 8px; margin-bottom: 14px; }
        .grid { display: table; width: 100%; }
        .row { display: table-row; }
        .cell { display: table-cell; padding: 6px 0; width: 50%; }
        .label { color: #6b7280; font-size: 12px; }
        .value { font-weight: bold; color: #111827; }
        .footer { margin-top: 40px; padding: 20px 40px; background: #f9fafb; border-top: 1px solid #e5e7eb; text-align: center; font-size: 11px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏥 Clinic Booking System</h1>
        <p>Appointment Receipt — #{{ $appointment->id }}</p>
    </div>

    <div class="content">
        <div class="section">
            <div class="section-title">Appointment Details</div>
            <div class="grid">
                <div class="row">
                    <div class="cell"><span class="label">Date</span><br><span class="value">{{ $appointment->appointment_date }}</span></div>
                    <div class="cell"><span class="label">Time</span><br><span class="value">{{ $appointment->start_time }} - {{ $appointment->end_time }}</span></div>
                </div>
                <div class="row">
                    <div class="cell"><span class="label">Type</span><br><span class="value">{{ ucfirst($appointment->type) }}</span></div>
                    <div class="cell"><span class="label">Status</span><br>
                        <span class="badge badge-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Patient Information</div>
            <div class="grid">
                <div class="row">
                    <div class="cell"><span class="label">Name</span><br><span class="value">{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</span></div>
                    <div class="cell"><span class="label">Code</span><br><span class="value">{{ $appointment->patient->patient_code }}</span></div>
                </div>
                <div class="row">
                    <div class="cell"><span class="label">Phone</span><br><span class="value">{{ $appointment->patient->phone }}</span></div>
                    <div class="cell"><span class="label">Email</span><br><span class="value">{{ $appointment->patient->email ?? 'N/A' }}</span></div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Doctor Information</div>
            <div class="grid">
                <div class="row">
                    <div class="cell"><span class="label">Name</span><br><span class="value">Dr. {{ $appointment->doctor->user->name }}</span></div>
                    <div class="cell"><span class="label">Specialization</span><br><span class="value">{{ $appointment->doctor->specialization->name ?? 'General' }}</span></div>
                </div>
            </div>
        </div>

        @if($appointment->notes)
        <div class="section">
            <div class="section-title">Notes</div>
            <p>{{ $appointment->notes }}</p>
        </div>
        @endif
    </div>

    <div class="footer">
        Generated on {{ now()->format('F j, Y \a\t H:i') }} — Clinic Booking System
    </div>
</body>
</html>