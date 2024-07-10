@extends('layout')

@section('content')
<div class="container">
    @if ($isApproved)
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Menu</h5>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href="{{ route('index-field') }}">List Lapangan</a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('index-day') }}">Buat Jadwal</a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('bookings.all') }}">List Booking</a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('venues.edit', $venue->id) }}" class="">Edit Venue</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Pemesanan per Lapangan</h5>
                                <canvas id="chartBookingCounts"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Pendapatan Bulan Ini</h5>
                                <canvas id="chartMonthlyRevenue"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Rata-rata Rating Lapangan</h5>
                                <canvas id="chartRatings"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lapangan yang Dipakai Hari Ini</h5>

                        @if ($bookedFields->isEmpty())
                        <p>Tidak ada lapangan yang dipakai hari ini.</p>
                        @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Lapangan</th>
                                    <th scope="col">Venue</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($bookedFields as $field)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $field->name_field }}</td>
                                        <td>{{ $field->venue->name_venue }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                <div class="container vh-100">
                    <div class="row">

                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Pemberitahuan</h5>
                                    <p class="card-text">Venue Anda masih dalam proses persetujuan oleh admin. Mohon menunggu hingga proses persetujuan selesai.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Bantuan dan Dukungan</h5>
                                    <p class="card-text">Jika Anda memiliki pertanyaan atau membutuhkan bantuan terkait venue Anda, silakan hubungi tim dukungan kami melalui email atau nomor telepon yang tercantum di bawah ini:</p>
                                    <ul class="list-unstyled">
                                        <li><a href="{{route('contact.create')}}" class="btn btn-success">contact admin</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
        </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var fields = @json($fields);
        var bookingCounts = @json($bookingCounts);
        var monthlyRevenue = @json($monthlyRevenue);
        var ratings = @json($ratings);

        var chartBookingCounts = document.getElementById('chartBookingCounts').getContext('2d');
        new Chart(chartBookingCounts, {
            type: 'bar',
            data: {
                labels: fields.map(field => field.name_field),
                datasets: [{
                    label: 'Total Pemesanan',
                    data: Object.values(bookingCounts),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });

        var chartMonthlyRevenue = document.getElementById('chartMonthlyRevenue').getContext('2d');
        new Chart(chartMonthlyRevenue, {
            type: 'bar',
            data: {
                labels: ['Bulan Ini'],
                datasets: [{
                    label: 'Total Pendapatan',
                    data: [monthlyRevenue],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });

        var chartRatings = document.getElementById('chartRatings').getContext('2d');
        new Chart(chartRatings, {
            type: 'bar',
            data: {
                labels: fields.map(field => field.name_field),
                datasets: [{
                    label: 'Rata-rata Rating',
                    data: Object.values(ratings.map(rating => rating.average_rating)),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>
@endsection
