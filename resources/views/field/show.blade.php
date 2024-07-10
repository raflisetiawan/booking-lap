@extends('layout')

@section('content')
    <div class="container vh-100">
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Detail Field</h5>
                <ul class="list-group">
                    <li class="list-group-item">Field ID: {{ $field->id }}</li>
                    <li class="list-group-item">Name: {{ $field->name_field }}</li>
                    <li class="list-group-item">Category: {{ $field->category }}</li>
                    <li class="list-group-item">Type: {{ $field->type_field }}</li>

                </ul>
            </div>
        </div>
    </div>
@endsection
