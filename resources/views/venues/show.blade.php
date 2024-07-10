@extends('layout')

@section('content')
    <div class="container w-30 ">
        <div id="carouselExampleControls" class="carousel slide mt-4" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('storage/venues/' . $venue->image_venue) }}" class="d-block w-100"
                        style="
                            background-size: cover;
                            background-position: center;
                            border-radius: 60px;
                            weight: 500px;
                            height: 500px;
                        "
                        alt="..." />
                </div>
            </div>
        </div>
        <div class="container">
            <h3 class="mt-3">{{ $venue->name_venue }}</h3>
            <p>
                {{ $venue->address_venue }}
            </p>
            <hr />
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card pb-5">
                        <div class="card-body">
                            <h3>Deskripsi</h3>
                            <p>{{ $venue->description_venue }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-secondary">Mulai dari</h5>
                                <h2>Rp.{{ $venue->lowest_price_venue }}/Jam</h2>
                            </div>
                        </div>
                        <div class="card mt-4">
                            <div class="card-body">
                                <h3>Fasilitas</h3>
                                <p>{{ $venue->facility_venue }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
        </div>
        <div class="container">
            <div class="venue-profile">
            </div>
            <h2>Daftar Lapangan</h2>
            <div class="row">
                @foreach ($dayFields as $dayField)
                    <div class="col-md-4 mb-5">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $dayField->date)->isoFormat('DD MMMM YYYY') }}</h4>
                            </div>
                            <div class="card-body">
                                <img src="{{ asset('storage/fields/' . $dayField->field->image_field) }}" width="100px" alt="">
                                <h5>Lapangan: {{ $dayField->field->name_field }}</h5>
                                <h6>Jadwal: </h6>
                                @if (count($dayField->schedules) > 0)
                                    <form action="{{ route('bookings.show', ['venueId' => $venue->id]) }}" method="GET">
                                        @foreach ($dayField->schedules as $schedule)
                                            <li>
                                                <label>
                                                    <input type="checkbox" name="schedules[]" value="{{ $schedule->id }}">
                                                    {{ $schedule->start_time }} - {{ $schedule->end_time }} -
                                                    Rp.{{ $schedule->price }}
                                                </label>
                                            </li>
                                        @endforeach
                                        <button type="submit" class="btn btn-primary">Booking</button>
                                    </form>
                                @else
                                    <p>Jadwal tidak tersedia</p>
                                @endif
                                <h6>Rating:</h6>
                                @php
                                    $rating = $averageRatings->where('field_id', $dayField->field->id)->first();
                                    $averageRating = $rating ? intval($rating->average_rating) : 0;
                                @endphp
                                <div class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $averageRating)
                                            <span class="fa fa-star checked"></span>
                                        @else
                                            <span class="fa fa-star"></span>
                                        @endif
                                    @endfor
                                </div>
                                <p>Average Rating: {{ $averageRating }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
