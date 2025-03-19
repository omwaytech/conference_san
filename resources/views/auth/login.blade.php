<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | SANCON - ASPA 2025</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('backend') }}/dist-assets/css/themes/lite-purple.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend') }}/dist-assets/css/plugins/toastr.css" />
    <style>
        @keyframes blink {
            0% {
                opacity: 1;
            }

            /* Start with fully visible */
            50% {
                opacity: 0;
            }

            /* Blink to invisible */
            100% {
                opacity: 1;
            }

            /* Back to fully visible */
        }

        .blinking-text {
            animation: blink 1s infinite;
            /* Change '1s' to adjust the blink speed */
        }
    </style>
</head>

<body>
    <div class="auth-layout-wrap"
        style="background-image: url({{ asset('backend') }}/dist-assets/images/conference-background.jpg)">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-4">
                            <div class="auth-logo text-center mb-4">
                                <a href="{{ route('front.index') }}">
                                    {{-- <img src="{{ asset('backend') }}/dist-assets/images/logo.png" alt=""
                                        height="200" width="200"> --}}
                                    <h2>SANCON - ASPA 2025</h2>
                                </a>
                            </div>
                            <h1 class="mb-3 text-18">Sign In</h1>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input
                                        class="form-control form-control-rounded @error('email') is-invalid @enderror"
                                        id="email" type="email" name="email" value="{{ old('email') }}"
                                        required autocomplete="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input
                                        class="form-control form-control-rounded @error('password') is-invalid @enderror"
                                        id="password" type="password" name="password" required
                                        autocomplete="current-password">
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-rounded btn-primary btn-block mt-2 col-4 mx-auto"
                                        type="submit">Sign
                                        In</button>
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                    <p>Not Signed Up Yet? Create Account</p>
                                    <a href="{{ route('front.index') }}#signUpSection"
                                        class="btn btn-rounded btn-info btn-block col-4 mx-auto">Sign Up</a>
                                </div>
                            </form> 
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="{{ asset('backend') }}/dist-assets/images/san-login.jpeg" height="100%">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('backend') }}/dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/plugins/toastr.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/scripts/toastr.script.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/plugins/bootstrap.bundle.min.js"></script>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error('{{ $error }}');
            </script>
        @endforeach
    @endif

    <script>
        $(document).ready(function() {
            $("#goToSignUp").click(function(e) {
                e.preventDefault();
                $(this).attr('disabled', true);
                $("#checkMemberForm").submit();
            });
        });
    </script>

    @if (Session::has('status'))
        <script>
            toastr.success("{!! Session::get('status') !!}");
        </script>
    @endif

    @if (Session::has('delete'))
        <script>
            toastr.error("{!! Session::get('delete') !!}");
        </script>
    @endif
</body>
