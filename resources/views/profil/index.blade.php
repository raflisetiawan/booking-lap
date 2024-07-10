@extends('layout')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Data Diri</h5>
                        <div class="profile-picture">
                            <img src="{{ Storage::url('users/user.png') }}" width="200px" alt="Profile Picture">
                        </div>
                        <p class="card-text">Nama: {{ $user->name }}</p>
                        <p class="card-text">Email: {{ $user->email }}</p>
                        <p class="card-text">Total pesanan: {{ $bookingCount }}</p>

                        <!-- tambahkan data diri lainnya sesuai kebutuhan -->

                        {{-- <a href="{{ route('profil.edit', ['id' => $user->id]) }}" class="btn btn-primary">Edit Profil</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">History Booking</h5>
                        <ul class="list-group">
                            @forelse ($bookings as $booking)
                                <li class="list-group-item">
                                    <p>Booking ID: {{ $booking->id }}</p>
                                    <p>Nama Venue: {{ $booking->schedule->daysField->venue->name_venue }}</p>
                                    <p>Nama Field: {{ $booking->schedule->daysField->field->name_field }}</p>
                                    <p>Tanggal: {{ $booking->schedule->daysField->date }}</p>
                                    <p>Jam: {{ $booking->schedule->start_time }} - {{ $booking->schedule->end_time }}</p>
                                    @if ($booking->status=='pending')
                                    <p>Status: <span class="badge bg-warning text-dark">pending</span></p>
                                    @elseif ($booking->status=='approved')
                                    <p>Status: <span class="badge bg-success">approved</span></p>
                                    @else
                                    <p>Status: <span class="badge bg-danger">rejected</span></p>
                                    @endif
                                    {{-- <p>Status: {{ $booking->status }}</p> --}}
                                    <!-- Button trigger modal -->
                                    @if ($booking->status== 'approved')

                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#rating{{ $booking->id }}">
                                    Berikan Rating dan Komentar
                                </button>
                                @endif

                                    <!-- Modal -->
                                    <div class="modal fade" id="rating{{ $booking->id }}" tabindex="-1"
                                        aria-labelledby="ratingModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="ratingModalLabel">Rating dan Komentar</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('ratings.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="field_id"
                                                            value="{{ $booking->schedule->daysField->field_id }}">
                                                        <div class="mb-3">
                                                            <label for="rating" class="form-label">Rating</label>
                                                            <select class="form-select" id="rating" name="nilai">
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="comment" class="form-label">Komentar</label>
                                                            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- tambahkan informasi lainnya seperti tanggal, lapangan, harga, dll -->
                                </li>
                            @empty
                                <li class="list-group-item">Belum ada history booking.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
