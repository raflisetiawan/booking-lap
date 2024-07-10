@extends('layout')

@section('content')
    <div class="container">
        <h2>Edit Profil</h2>
        <form action="{{ route('profil.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Tambahkan input untuk mengedit data profil pengguna -->
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" value="{{ $user->name }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="profil_picture">Foto Profil</label>
                <input type="file" name="profile_picture" class="form-control-file">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection

