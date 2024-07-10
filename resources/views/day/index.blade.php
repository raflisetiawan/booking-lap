@extends('layout')

@section('content')
    <div class="container mt-4 vh-100">
        <a href="{{route('create-day')}}" class="btn btn-success">Buat jadwal</a>
        <table class="table mt-3">
            <thead>
              <tr>
                <th scope="col">no</th>
                <th scope="col">Nama Lapangan</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($dayFields as $dayField)
                <tr>
                  <th scope="row">{{$i++}}</th>
                  <td>{{$dayField->field->name_field}}</td>
                  <td>{{$dayField->date}}</td>
                  <td>
                    <a href="{{route('create-schedule', ['id' => $dayField->id])}}" class="btn btn-success">Tambahkan jam</a>
                    <a href="{{route('index-schedule', ['id' => $dayField->id])}}" class="btn btn-success">Lihat Jadwal </a>
                  </td>
                </tr>
                @endforeach
              </tbody>

          </table>
    </div>
@endsection
