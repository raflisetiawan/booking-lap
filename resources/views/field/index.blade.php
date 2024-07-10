@extends('layout')

@section('content')
    <div class="container vh-100 mt-3">
        <a href="{{route('create-field')}}" class="btn btn-success">Tambah Lapangan</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">no</th>
                    <th scope="col">Nama Lapangan</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fields as $field)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td>{{ $field->name_field }}</td>
                        <td>
                            <a href="{{ route('edit-field', ['id' => $field->id]) }}" class="btn btn-success">Edit</a>
                            <a href="{{ route('show-field', ['id' => $field->id]) }}" class="btn btn-success">Detail</a>
                            {{-- <a href="{{route('create-day')}}" class="btn btn-success" >Tambah Hari</a> --}}
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $field->id }}">Hapus</button>

                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal{{ $field->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $field->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id2deleteModalLabel{{ $field->id }}">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus field ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('delete-field', ['id' => $field->id]) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
