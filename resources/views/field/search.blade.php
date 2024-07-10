@extends('layout')

@section('content')
<div class="container">
<h2>Daftar Lapangan</h2>
<div class="row">
    @foreach ($daysFields as $dayField)
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $dayField->date)->isoFormat('DD MMMM YYYY') }}</h4>
            </div>
            <div class="card-body">
                <h5>Lapangan: {{ $dayField->field->name_field }}</h5>
                <h6>Jadwal:</h6>
                <form action="{{ route('bookings.show', ['venueId' => $dayField->venue->id]) }}" method="GET">
                    @foreach ($dayField->schedules as $schedule)
                        <li>
                            <label>
                                <input type="checkbox" name="schedules[]" value="{{ $schedule->id }}">
                                {{ $schedule->start_time }} - {{ $schedule->end_time }} - Rp.{{ $schedule->price }}
                            </label>
                        </li>
                    @endforeach
                    <button type="submit" class="btn btn-success">Booking</button>
                </form>
            </div>
        </div>
    </div>
@endforeach
</div>
</div>
@endsection

