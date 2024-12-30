<div>
    <h3 class="text-lg font-bold mb-4">Appointment Details</h3>
    <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST">
        @csrf

        <div class="mt-3">
            <strong class="mb-3">Contact Details:</strong><br>
            <span>Name : {{ $appointment->name }}</span><br>
            <span>Mobile : {{ $appointment->mobile }}</span>
        </div>
        <div class="mt-3">
            <strong class="mb-3">Message:</strong><br>
            <span>{{ $appointment->notes }}</span>
        </div>

        <div class="mt-4">
            <strong class="mb-3">Appointment For:</strong>
            <span>{{ $appointment->doctor_id ? 'Doctor' : 'Service' }}</span><br>
            @if($appointment->doctor_id)
                <span class="fw-bold mt-3">{{ $appointment->doctor->name  }}</span>
            @else
                <span class="fw-bold mt-3">{{ $appointment->service->name  }}</span>
            @endif
            

        </div>

        <div class="mt-4">
            <strong class="mb-3">Status:</strong>

            <div class="form-check">
                <input type="radio" id="statusUnread" name="status" value="0" class="form-check-input"
                    {{ $appointment->status === 0 ? 'checked' : '' }}>
                <label for="statusUnread" class="form-check-label">Unread</label>
            </div>
            <div class="form-check">
                <input type="radio" id="statusAttended" name="status" value="1" class="form-check-input"
                    {{ $appointment->status === 1 ? 'checked' : '' }}>
                <label for="statusAttended" class="form-check-label">Attended</label>
            </div>

        </div>

        <div class="mt-4 text-right">
            <button type="submit" class="bg-success text-white px-4 py-2 rounded">Save</button>
            <button type="button" class="bg-red text-white px-4 py-2 rounded"
                onclick="document.getElementById('appointment-modal').classList.add('hidden')">Cancel</button>
        </div>
    </form>
</div>
