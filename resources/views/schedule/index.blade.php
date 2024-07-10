@extends('layout')

@section('content')
    <div class="container vh-100 mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <a href="{{ route('create-day') }}" class="btn btn-success mb-4">Buat jadwal</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Jam Mulai</th>
                    <th scope="col">Jam Akhir</th>
                    {{-- <th scope="col">Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td>{{ $schedule->start_time }}</td>
                        <td>{{ $schedule->end_time }}</td>
                        {{-- <td>
                            <form action="{{ route('schedule.updateIsBooking', ['id' => $schedule->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">Atur sudah booking</button>
                            </form>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
