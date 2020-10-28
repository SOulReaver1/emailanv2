<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Argon Dashboard') }}</title>
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.ico" rel="icon">
        <!-- Fonts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/zf/dt-1.10.21/datatables.min.css"/>
        @yield('js')


    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('layouts.navbars.sidebar')
        @endauth

        <div class="main-content">
            @auth
                @include('layouts.navbars.navs.auth')
                @include('users.partials.header', [
                    'title' => __('Hello') . ' '. auth()->user()->name,
                    'description' => $headerDesc ?? '',
                    'img' => 'prospect-create-cover.jpg'
                ]) 
                <div class="container-fluid mt--7">
                    <div class="row">
                        <div class="col order-xl-1">
                            <div class="card bg-secondary shadow">
                                <div class="card-header bg-white border-0">
                                    <div class="align-items-center">
                                        @if (\Session::has("success"))
                                            <div class="alert alert-success" role="alert">
                                                {!! \Session::get("success") !!}
                                            </div>
                                        @elseif(\Session::has("error"))
                                            <div class="alert alert-danger" role="alert">
                                                {!! \Session::get("error") !!}
                                            </div>
                                        @endif
                                        @if ($errors->any())
                                            <ul class="alert alert-danger" id="errors-danger">
                                                @foreach($errors->all() as $error)
                                                    <li>{{$error}}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        <div id="alert-info" class="alert alert-info" role="alert" style="display: none"></div>
                                        <div id="alert-success" class="alert alert-success" role="alert" style="display: none"></div>
                                        <div id="alert-danger" class="alert alert-danger" role="alert" style="display: none"></div>
                                        @yield('card-header')
                                        @if (isset($title))
                                            <h1 class="text-underline">{{$title}}</h1>
                                        @endif
                                        @if (isset($require))
                                            <small class="mb-5"><span class="text-danger">*</span> champs obligatoires</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">                            
                                    @yield('card-body')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('layouts.footers.auth')
            @endauth
        </div>

        @guest()
            @yield('content')
            @include('layouts.footers.guest')
        @endguest


        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/zf/dt-1.10.21/datatables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        @yield('scripts')
    </body>
</html>
