@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('New Appointment') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="border-2 border-black rounded-xl p-6">
                <form method="POST" action="{{ route('appointments.store') }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="label">Patient</label>
                            <input type="hidden" name="patient_id" value="{{ auth()->user()->patient->id }}">
                            <div class="input-field bg-gray-100">
                                {{ $patient->first_name }} {{ $patient->last_name }} ({{ $patient->patient_code }})
                            </div>
                        </div>
                        
                        <div>
                            <label class="label">Doctor</label>
                            <select name="doctor_id" id="doctor_id" class="input-field" required>
                                <option value="">Select Doctor</option>
                                @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="label">Appointment Date</label>
                            <input type="date" name="appointment_date" id="appointment_date" class="input-field" required min="{{ date('Y-m-d') }}">
                        </div>
                        
                        <div>
                            <label class="label">Appointment Type</label>
                            <select name="type" class="input-field" required>
                                <option value="consultation">Consultation</option>
                                <option value="followup">Follow-up</option>
                                <option value="procedure">Procedure</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="label">Start Time</label>
                            <select name="start_time" id="start_time" class="input-field" required>
                                <option value="">Select Time</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="label">End Time</label>
                            <input type="text" id="end_time_display" class="input-field" readonly placeholder="Auto calculated">
                            <input type="hidden" name="end_time" id="end_time">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="label">Notes</label>
                            <textarea name="notes" class="input-field" rows="3"></textarea>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-6">
                        <a href="{{ route('appointments.index') }}" class="btn-secondary mr-4">Cancel</a>
                        <button type="submit" class="btn-primary">Create Appointment</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const doctorSelect = document.getElementById('doctor_id');
    const dateInput = document.getElementById('appointment_date');
    const startTimeSelect = document.getElementById('start_time');
    const endTimeDisplay = document.getElementById('end_time_display');
    const endTimeInput = document.getElementById('end_time');

    function fetchSlots() {
        const doctorId = doctorSelect.value;
        const date = dateInput.value;

        if (!doctorId || !date) {
            startTimeSelect.innerHTML = '<option value="">Select Time</option>';
            endTimeDisplay.value = '';
            endTimeInput.value = '';
            return;
        }

        fetch(`/appointments/available-slots?doctor_id=${doctorId}&date=${date}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                startTimeSelect.innerHTML = '<option value="">Select Time</option>';
                
                if (data.error) {
                    alert(data.error);
                    return;
                }

                data.forEach(slot => {
                    const option = document.createElement('option');
                    option.value = slot.start;
                    option.textContent = slot.start + ' - ' + slot.end;
                    startTimeSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    doctorSelect.addEventListener('change', fetchSlots);
    dateInput.addEventListener('change', fetchSlots);

    startTimeSelect.addEventListener('change', function() {
        const selectedOption = startTimeSelect.options[startTimeSelect.selectedIndex];
        if (selectedOption.value) {
            const times = selectedOption.textContent.split(' - ');
            endTimeDisplay.value = times[1] || '';
            endTimeInput.value = times[1] || '';
        } else {
            endTimeDisplay.value = '';
            endTimeInput.value = '';
        }
    });
});
</script>
@endpush
@endsection
