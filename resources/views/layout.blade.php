<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boking-Lap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href={{ asset('style.css') }}>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.com/libraries/Chart.js">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css">
    <style>
        .rating {
    color: orange;
    font-size: 20px;
}

.fa-star.checked {
    color: yellow;
}


        .hero {
            background-image: url('{{ asset('img/abigail-keenan-8-s5QuUBtyM-unsplash.jpg') }}');
            background-size: cover;
            background-position: center;
            height: 100vh;
            position: relative;
        }

        .hero-content {
            text-align: center;
            padding-top: 100px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 3em;
            color: #fff;
        }

        .hero-content p {
            font-size: 1.5em;
            color: #fff;
        }

        .footer {
            background-color: #157146;
            color: white;
        }

        .round-image {
            border-radius: 50%;
            overflow: hidden;
            width: 150px;
            height: 150px;
        }

        .daftar-venue {
            background-image: url('{{ asset('img/4795933.jpg') }}');
            background-size: cover;
            background-position: center;
            height: 100vh;
            position: relative;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid  ">
            <a class="navbar-brand ms-3" href="#">
                <img src="{{asset('img/light.png')}}" alt="Logo" class="img-fluid rounded" width="50" height="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{route('dashboard.index')}}">Home</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('venues.index')}}">Venue Lapangan</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('about.index')}}">about us</a>
                    </li>
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{route('contacts.store')}}">contact</a>
                    </li>
                </ul>
                <div class="d-flex">
                    @auth
                    <div class="btn-group">
                        <button type="button" class="btn btn-success">
                            <i class="fa-solid fa-user"></i> {{ auth()->user()->name }}
                        </button>
                        <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('profil.index', ['id' => auth()->user()->id]) }}">Profil</a>
                            </li>
                            {{-- <li>
                                <a class="dropdown-item" href="#">Keranjang</a>
                            </li> --}}
                            @if (count(auth()->user()->venues) > 0)
                                <li>
                                    <a class="dropdown-item" href="{{ route('Dashboard-owner') }}">Manage Venue</a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item" href="{{ route('venues.create') }}">Create Venue</a>
                                </li>
                            @endif
                            @if (auth()->user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.index') }}">Admin</a>
                                </li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                            </li>
                        </ul>
                    </div>
                        @else
                        <a class="btn btn-success" href="{{ route('login') }}">Login</a>
                        @endauth
                        {{-- @auth
                            <p>Welcome, {{ auth()->user()->name }}</p>
                            <a class="btn btn-success" href="{{ route('logout') }}">Logout</a>
                            @else
                            <a class="btn btn-success" href="{{ route('login') }}">Login</a>
                            @endauth --}}
                        </div>
                    </div>
                </div>
  </nav>
  <div class="content">
    <!-- Konten halaman yang diperpanjang -->
    @yield('content')
</div>
    <section class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3 class="mt-4">Booking-lap</h3>
                    <p> &#169; 2023</p>
                    <p>Privacy - terms</p>
                </div>
                {{-- <div class="col-md-8">
                    <ul class="list-unstyled d-flex justify-content-around mt-4">
                        <li>
                            Home
                        </li>
                        <li>
                            Sewa lapangan
                        </li>
                        <li>
                            Sparring
                        </li>
                        <li>
                            Kontak
                        </li>
                    </ul>
                </div> --}}
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    <script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script>
    </script>
     {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
     <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
     <script>
         CKEDITOR.replace('content');
     </script>

    <script>
        $(function() {
            $('select').multipleSelect()
        })
    </script>
</body>

</html>
