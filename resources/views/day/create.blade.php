@extends('layout')

@section('content')
    <div class="container vh-100">
        <h1>Create Days Field</h1>

        <form action="{{route('store-day')}}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>

            <div class="mb-3">
                <label for="field_id" class="form-label">Field</label>
                <select class="form-select" id="field_id" name="field_id" required>
                    <option value="">Select Field</option>
                    @foreach ($fields as $field)
                        <option value="{{ $field->id }}">{{ $field->name_field }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Create</button>
        </form>
    </div>
@endsection
