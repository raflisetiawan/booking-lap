@extends('layout')
@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-2 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{route('update-field',$field->id)}}" method="POST" enctype="multipart/form-data">

                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label class="font-weight-bold">GAMBAR</label>
                                <input type="file" class="form-control @error('image_field') is-invalid @enderror"
                                    name="image_field">

                                <!-- error message untuk title -->
                                @error('image_field')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold mt-3">Name lapangan</label>
                                <input type="text" class="form-control @error('name_field') is-invalid @enderror"
                                    name="name_field" value="{{ old('name_field', $field->name_field) }}" placeholder="Masukkan nama lapangan">

                                <!-- error message untuk name_venue -->
                                @error('name_field')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">kategori</label>
                                <select style="width: 300px" name="category" class="mb-3 mt-3">
                                    @foreach($categories as $category)
                                    <option value="{{ $category->name }}" @if($field->categories == $category->name) selected @endif>{{ $category->name }}</option>
                                @endforeach
                                </select>

                                <!-- error message untuk lowest_price_venue -->
                                {{-- @error('lowest_price_venue')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror --}}
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">jenis lapangan</label>
                                <input type="text" class="form-control @error('type_field') is-invalid @enderror"
                                    name="type_field" value="{{ old('type_field', $field->type_field) }}"
                                    placeholder="Masukkan jenis lapangan anda">

                                <!-- error message untuk contact_venue -->
                                @error('type_field')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-md btn-success mt-3">SIMPAN</button>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
