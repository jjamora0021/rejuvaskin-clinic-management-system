<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Rejuvaskin Clinic Management System</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

     <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ url('images/logo-green.png') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome-5.11.2-all.min.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">

    @yield('page-css')
</head>
<body>
    <div id="app">
        <div class="d-flex" id="wrapper">
            {{-- Sidebar --}}
            <div id="sidebar-wrapper">
                <div class="sidebar-heading text-center font-weight-bold">Rejuvaskin</div>

                <div id="sidebar-menu" class="list-group list-group-flush">
                        {{-- DASHBOARD --}}
                        <a href="#dashboardSubmenu" id="dashboard-dropdown" data-toggle="collapse" aria-haspopup="true" aria-expanded="false" class="pt-3 dropdown-toggle list-group-item list-group-item-action text-white"><i class="fas fa-tachometer-alt"></i>&nbsp;&nbsp;&nbsp;Dashboard <i class="caret-icon fas fa-angle-down float-right"></i></a>
                        <ul class="collapse list-unstyled mb-0" id="dashboardSubmenu">
                            <li class="list-group-item" id="time-keeping-link">
                                <a href="{{ url('time-keeping') }}"><i class="fas fa-stopwatch"></i>&nbsp;&nbsp;&nbsp;Time Keeping</a>
                            </li>
                            <li class="list-group-item" id="schedules-link">
                                <a href="{{ url('schedules') }}"><i class="fas fa-calendar-alt"></i>&nbsp;&nbsp;&nbsp;Schedules</a>
                            </li>
                        </ul>

                        {{-- USERS --}}
                        <a href="#userSubmenu" id="staff-dropdown" data-toggle="collapse" aria-haspopup="true" aria-expanded="false" class="pt-3 dropdown-toggle list-group-item list-group-item-action text-white"><i class="fas fa-user"></i>&nbsp;&nbsp;&nbsp;Staffs <i class="caret-icon fas fa-angle-down float-right"></i></a>
                        <ul class="collapse list-unstyled mb-0" id="userSubmenu">
                            <li class="list-group-item" id="view-staff-link">
                                <a href="{{ url('view-staff') }}"><i class="fas fa-eye"></i>&nbsp;&nbsp;&nbsp;View Staff</a>
                            </li>
                            <li class="list-group-item"  id="create-staff-profile-link">
                                <a href="{{ url('create-staff-profile') }}"><i class="fas fa-user-plus"></i>&nbsp;&nbsp;&nbsp;Create Staff Profile</a>
                            </li>
                        </ul>
                    
                </div>
            </div>
            {{-- /#sidebar-wrapper --}}

            {{-- Page Content --}}
            <div id="page-content-wrapper">

                <nav class="navbar navbar-expand-lg border-bottom">
                    <div id="menu-toggle" class="text-dark">
                        <i class="fas fa-bars fa-1x"></i>
                    </div>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                            <li class="nav-item dropdown d-flex">
                                <i class="fas fa-user-circle fa-2x mr-2"></i>
                                <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="user-name">{{ Session::get('user')[0]['first_name'] }}</span>
                                </a>
                                <div class="dropdown-menu pt-0 pb-0 mt-0" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="{{ url('profile') }}">Profile</a>
                                    <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                
                @yield('content')
            </div>
            {{-- /#page-content-wrapper --}}
        </div>
    </div>
    @include('pages.includes.generic-modal')
    @yield('page-js')
</body>
</html>