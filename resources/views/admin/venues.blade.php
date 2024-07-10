@extends('layout')

@section('content')
<div class="container">
    <h1>Daftar Venue</h1>

    @if($venues->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Venue</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($venues as $venue)
                    <tr>
                        <td>{{ $venue->name_venue }}</td>
                        <td>{{ $venue->is_approve ? 'Disetujui' : 'Belum Disetujui' }}</td>
                        <td>
                            @if(!$venue->is_approve)
                                <form action="{{ route('venues.updateApprove', $venue->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success">Setujui</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada venue yang mendaftar.</p>
    @endif
</div>
@endsection
