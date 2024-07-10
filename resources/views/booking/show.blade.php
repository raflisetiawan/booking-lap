@extends('layout')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Detail Booking:</h2>
                {{-- <p class="card-text">Booking ID: {{ $bookings->pluck('id')->implode(', ') }}</p> --}}
                <br>
                <div class="mb-4">
                    <h4 class="card-subtitle">Schedules:</h4>
                    <ul class="list-group">
                        @foreach ($schedules as $schedule)
                            <li class="list-group-item">
                                {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                <span class="float-end">Rp.{{ $schedule->price }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
<br>
                <div class="mb-4">
                    <h4 class="card-subtitle">Field:</h4>
                    <p>{{ $fields->pluck('name_field')->implode(', ') }}</p>
                </div>
<br>
                <div class="mb-4">
                    <h4 class="card-subtitle">Venue:</h4>
                    <p>{{ $venue->name_venue }}</p>
                </div>
<br>
                <form action="{{ route('bookings.store', ['venueId' => $venue->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h4 class="card-subtitle">Select Schedules:</h4>
                    @foreach ($schedules as $schedule)
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" name="schedules[]" value="{{ $schedule->id }}" id="schedule{{ $schedule->id }}">
                            <label class="form-check-label" for="schedule{{ $schedule->id }}">
                                {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                <span class="float-end">Rp.{{ $schedule->price }}</span>
                            </label>
                        </div>
                    @endforeach
                    <br>
                    <div class="mb-4">
                        <h4 class="card-subtitle">Noner Rekening:</h4>
                        <p>{{ $venue->contact_venue }}</p>
                        <p>Silahkan transfer ke rekening tersebut terlebih dahulu</p>
                    </div>
                    <div class="mb-3">
                        <label for="payment_proof" class="form-label">Upload bukti pembayaran:</label>
                        <input type="file" class="form-control" id="payment_proof" name="payment_proof">
                    </div>
                    <button type="submit" class="btn btn-success mt-4">Booking</button>
                </form>
            </div>
        </div>
    </div>
@endsection
