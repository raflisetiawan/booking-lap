<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Boking-Lap</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css">
</head>

<body style="background: lightgray">


    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('venues.store') }}" method="POST" enctype="multipart/form-data">

                            @csrf
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
                                    name="name_venue" value="{{ old('name_venue') }}" placeholder="Masukkan nama venue">

                                <!-- error message untuk name_venue -->
                                @error('name_venue')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Nomer Rekening</label>
                                <input type="text" class="form-control @error('contact_venue') is-invalid @enderror"
                                    name="contact_venue" value="{{ old('contact_venue') }}"
                                    placeholder="Masukkan nomer rekening anda">

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
                                    placeholder="Masukkan Konten Post">{{ old('address_venue') }}</textarea>

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
                                    placeholder="Masukkan deskripsi tentang venue anda">{{ old('description_venue') }}</textarea>

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
                                    placeholder="Masukkan fasilitas apa aja">{{ old('facility_venue') }}</textarea>

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
                                    rows="5" placeholder="Masukkan harga lapangan terendah">{{ old('lowest_price_venue') }}</textarea>

                                <!-- error message untuk lowest_price_venue -->
                                @error('lowest_price_venue')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">kategori</label>

                                <select style="width: 300px" name="categories[]" multiple="multiple">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                {{-- <label class="font-weight-bold">kategori</label>
                                    <select name="lapangan" id="lapangan">
                                        <option value="Futsal">Futsal</option>
                                        <option value="Voli">Voli</option>
                                        <option value="Badminton">Badminton</option>
                                        <option value="Basket">Basket</option>
                                        <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                                    </select> --}}

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script>
    <script>
        CKEDITOR.replace('content');

    </script>
     <script>
        $(function () {
          $('select').multipleSelect()
        })
      </script>
</body>

</html>
