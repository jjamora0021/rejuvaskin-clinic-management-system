<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

     <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ url('images/logo-green.png') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome-5.11.2-all.min.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="login-container">
        <div class="container text-center" id="logo-container">
            <img src="{{ asset('images/logo-white.png') }}" width="25%">
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center text-font-weight-bold">Login</h5>
                <form method="POST" action="{{ route('login') }}" class="container">
                    @csrf

                    <div class="form-group row">
                        <label for="username" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('Username') }}</label>

                        <div class="col-md-6">
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <hr>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4 d-flex">
                            <button type="submit" class="btn btn-success font-weight-bold">
                                {{ __('Login') }}
                            </button>
                        </div>
                        <div class="col-md-6 offset-md-4 text-center">
                             @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>