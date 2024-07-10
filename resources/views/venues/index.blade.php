@extends('layout')

@section('content')
    <section id="card-venue">
        <div class="container">
            <h2 class="mt-5 mb-5">Pilih Venue</h2>
            <!-- Add the filter form -->
            <form action="{{ route('search-fields') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_filter">Filter lapangan berdasarkan Tanggal:</label>
                            <input type="date" name="date" id="date_filter" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="time_filter">Filter Waktu:</label>
                            <input type="time" name="time" id="time_filter" class="form-control">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Filter</button>
            </form>

            <div class="row">
                @foreach ($venues as $venue)
                    <div class="col-md-3">
                        <div class="card" style="width: 17rem;">
                            <img src="{{ asset('/storage/venues/'.$venue->image_venue) }}" class="card-img-top" style="height: 200px;" alt="...">
                            <div class="card-body">
                                <h5 class="text-secondary">Venue</h5>
                                <h3 class="card-title">{{ $venue->name_venue }}</h3>
                                <p class="card-text"><i class="fa-solid fa-location-arrow"></i>{{ $venue->address_venue }}</p>

                                <h4 class="text-secondary">mulai dari</h4>
                                <h2>Rp{{ $venue->lowest_price_venue }}/Jam</h2>

                                <a href="{{ route('venues.show', $venue->id) }}" class="btn btn-success">Lihat Venue</a>
                                {{-- <a href="{{ route('venues.edit', $venue->id) }}" class="btn btn-success">Edit Venue</a>

                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('venues.destroy', $venue->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                </form> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row mt-5">
            <div class="col-12 justify-content-center d-flex">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
