@extends('layout')

@section('content')
    <div class="container mt-5 vh-100">

        <h4>Buat jadwal untuk lapangan: {{$dayField->field->name_field}} pada tanggal : {{$dayField->date}}</h4>
        <form action="{{route('store-schedule', ['id' => $dayField->id])}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" name="start_time" id="start_time" class="form-control">
            </div>
            <div class="mb-3">
                <label for="end_time" class="form-label">End Time</label>
                <input type="time" name="end_time" id="end_time" class="form-control">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" id="price" class="form-control" step="0.01">
            </div>
            <button type="submit" class="btn btn-success">Create</button>
        </form>
        
    </div>
@endsection
