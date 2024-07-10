@extends('layout')

@section('content')
    <div class="container">
        <h2>All Bookings</h2>

        @if ($bookings->isEmpty())
            <p>No bookings found.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Schedule</th>
                        <th>User</th>
                        <th>Payment Proof</th>
                        <th>Status</th> <!-- tambahkan kolom status -->
                        <th>Actions</th> <!-- tambahkan kolom aksi -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->schedule->start_time }} - {{ $booking->schedule->end_time }}</td>
                            <td>{{ $booking->user->name }}</td>
                            <td>
                                @if ($booking->payment_proof)
                                    <img src="{{ Storage::url('bookings/').$booking->payment_proof }}" alt="Payment Proof" style="width: 100px;">
                                @else
                                    No payment proof provided.
                                @endif
                            </td>
                            <td>{{ $booking->status }}</td> <!-- tampilkan status -->
                            <td>
                                <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST"> <!-- tambahkan form untuk mengubah status -->
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select" onchange="this.form.submit()"> <!-- dropdown untuk memilih status baru -->
                                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $booking->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $booking->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
