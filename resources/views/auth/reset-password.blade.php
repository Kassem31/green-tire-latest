<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Green Tire</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('src/assets/img/logo/logo.jpg') }}" />
    <link href="{{ asset('layouts/collapsible-menu/css/light/loader.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('layouts/collapsible-menu/css/dark/loader.css') }}" rel="stylesheet" type="text/css" />

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('layouts/collapsible-menu/css/light/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('src/assets/css/light/authentication/auth-boxed.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('layouts/collapsible-menu/css/dark/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('src/assets/css/dark/authentication/auth-boxed.css') }}" rel="stylesheet" type="text/css" />

    <style>
        body.form {
            background-image: url('{{ asset('src/assets/img/background.jpeg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
    
</head>

<body class="form">

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="auth-container d-flex">

            <div class="container mx-auto align-self-center">

                <div class="row">

                    <div
                        class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                        <div class="card mt-3 mb-3" style="background-color: #9ccb9c; opacity: 0.85">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12 mb-3">

                                        <h2>Reset Password</h2>
                                        <p>Enter your email and new password to reset your account password.</p>

                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: #ff0000"/>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input id="password" name="password" type="password" class="form-control" required autocomplete="new-password">
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: #ff0000" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label class="form-label">Confirm Password</label>
                                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required autocomplete="new-password">
                                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" style="color: #ff0000" />
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-4">
                                            <button class="btn btn-primary w-100">RESET PASSWORD</button>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="text-center">
                                            <a href="{{ route('login') }}" class="text-primary">
                                                Back to login
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </form>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    {{-- <script src="{{ asset('src/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    <!-- END GLOBAL MANDATORY SCRIPTS -->

</body>

</html>
