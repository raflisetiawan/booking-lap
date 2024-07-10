@extends('layout')
@section('content')
    <div class="container mt-5 mb-5 ">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-2 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('venues.update', $venue->id) }}" method="POST" enctype="multipart/form-data">

                            @csrf
                            @method('PUT')
                            <input type="hidden" name="user_id" value="1">
                            <div class="form-group">
                                <label class="font-weight-bold">GAMBAR</label>
                                <input type="file" class="form-control @error('image_venue') is-invalid @enderror"
                                    name="image_venue">

                                <!-- error message untuk title -->
                                @error('image_venue')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Name Venue</label>
                                <input type="text" class="form-control @error('name_venue') is-invalid @enderror"
                                    name="name_venue" value="{{ old('name_velue', $venue->name_venue) }}" placeholder="Masukkan Judul Post">

                                <!-- error message untuk name_venue -->
                                @error('name_venue')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Nomer rekening</label>
                                <input type="text" class="form-control @error('contact_venue') is-invalid @enderror"
                                    name="contact_venue" value="{{ old('contact_venue', $venue->contact_venue) }}"
                                    placeholder="ex: 10054004530 (bca)">

                                <!-- error message untuk contact_venue -->
                                @error('contact_venue')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Alamat Venue</label>
                                <textarea class="form-control @error('address_venue') is-invalid @enderror" name="address_venue" rows="5"
                                    placeholder="Masukkan Konten Post">{{ old('address_venue',$venue->address_venue) }}</textarea>

                                <!-- error message untuk address_venue -->
                                @error('address_venue')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Deskripsi</label>
                                <textarea class="form-control @error('description_venue') is-invalid @enderror" name="description_venue" rows="5"
                                    placeholder="Masukkan Konten Post">{{ old('description_venue',$venue->description_venue) }}</textarea>

                                <!-- error message untuk description_venue -->
                                @error('description_venue')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Fasilitas Venue</label>
                                <textarea class="form-control @error('facility_venue') is-invalid @enderror" name="facility_venue" rows="5"
                                    placeholder="Masukkan Konten Post">{{ old('facility_venue',$venue->facility_venue) }}</textarea>

                                <!-- error message untuk facility_venue -->
                                @error('facility_venue')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Harga mulai dari</label>
                                <textarea class="form-control @error('lowest_price_venue') is-invalid @enderror" name="lowest_price_venue"
                                    rows="5" placeholder="Masukkan Konten Post">{{ old('lowest_price_venue',$venue->lowest_price_venue) }}</textarea>

                                <!-- error message untuk lowest_price_venue -->
                                @error('lowest_price_venue')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">kategori</label>
                                <select class="form-select form-control" name="categories[]" multiple>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                <!-- error message untuk lowest_price_venue -->
                                {{-- @error('lowest_price_venue')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror --}}
                            </div>



                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
