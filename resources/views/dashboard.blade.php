@extends('layout')

@section('content')
    <section class="hero">
        <div class="hero-content">
            <h1>Booking lapangan dengan mudah tanpa ke lokasinya langsung</h1>
            @auth
            <a href="{{route('venues.index')}}"><button class="btn btn-success btn-lg mt-3">Cari Lapangan</button></a>
            @endauth
        </div>
    </section>
    <section class="post-section">
        <div class="container mb-3">
            <h3 class="text-center mt-5 mb-5">Berbagai pilihan Venue</h3>
            <div class="row">
                @foreach ($venues as $venue)
                    <div class="col-md-3">
                        <div class="card" style="width: 17rem;">
                            <img src="{{ asset('/storage/venues/' . $venue->image_venue) }}" class="card-img-top"
                                style="height: 200px;" alt="...">
                            <div class="card-body">
                                <h5 class="text-secondary">Venue</h5>
                                <h3 class="card-title">{{ $venue->name_venue }}</h3>
                                <p class="card-text"><i
                                        class="fa-solid fa-location-arrow"></i>{{ $venue->address_venue }}

                                <h4 class="text-secondary">mulai dari</h4>
                                <h2>Rp{{ $venue->lowest_price_venue }}/Jam</h2>
                                </p>

                                @auth

                                <a href="{{ route('venues.show', $venue->id) }}" class="btn btn-success">Lihat Venue</a>
                                @endauth

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
        </div>
    </section>
    {{-- <section class="social-prof">
        <div class="container mb-4">
            <h3 class="text text-center mt-5 mb-5">Berbagai pilihan Olahraga</h3>
            <div class="row">
                <div class="col-md-2">
                    <img src="{{asset('img/futsal.jpg')}}" class="img-thumbnail rounded" alt="...">
                    <h4 class="text-center mt-2">futsal</h4>
                </div>
                <div class="col-md-2">
                    <img src="futsal.jpg" class="img-thumbnail rounded" alt="...">
                    <h4 class="text-center mt-2">futsal</h4>
                </div>
                <div class="col-md-2">
                    <img src="futsal.jpg" class="img-thumbnail rounded" alt="...">
                    <h4 class="text-center mt-2">futsal</h4>
                </div>
                <div class="col-md-2">
                    <img src="futsal.jpg" class="img-thumbnail rounded" alt="...">
                    <h4 class="text-center mt-2">futsal</h4>
                </div>
                <div class="col-md-2">
                    <img src="futsal.jpg" class="img-thumbnail rounded" alt="...">
                    <h4 class="text-center mt-2">futsal</h4>
                </div>
                <div class="col-md-2">
                    <img src="futsal.jpg" class="img-thumbnail rounded" alt="...">
                    <h4 class="text-center mt-2">futsal</h4>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="daftar-venue">
        <div class="daftar-venue-content">
            <div class="hero-content">
                @auth
                @if(Auth::user()->role == 'owner_venue')
                <a href="{{route('Dashboard-owner')}}"><button class="btn btn-success btn-lg mt-3">Manage venue</button></a>
                @else
                <h1>Daftarkan venue anda sekarang</h1>
                <a href="{{route('venues.create')}}"><button class="btn btn-success btn-lg mt-3">Daftar venue</button></a>
                @endif
                @else
                <h1>Login dan daftarkan Venue anda sekarang</h1>
                <a href="{{route('login')}}"><button class="btn btn-success btn-lg mt-3">Login</button></a>

                @endauth
            </div>

        </div>

    </section>
@endsection
