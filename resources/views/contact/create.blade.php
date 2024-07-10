@extends('layout')

@section('content')
<div class="container vh-100 mt-3">
    @if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
    @endif

    <h2>Kontak Kami</h2>
    <p>Jika Anda memiliki pertanyaan atau masukan, silakan hubungi kami melalui formulir di bawah ini.</p>

    <form action="{{ route('contacts.store') }}" method="POST" class="mt-5">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Pesan</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Kirim</button>
    </form>
</div>

@endsection
