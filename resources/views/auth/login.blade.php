<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link href="https://unpkg.com/ionicons@4.5.9-1/dist/css/ionicons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet" />
    
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    @if($isLocal)
    <!-- <link rel="short icon" type="image/png" sizes="16x16" href="{{ asset('img/lucid-logo.svg') }}"> -->
    <link rel="stylesheet" href="{{ asset('css/main-style.css') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('favicon/safari-pinned-tab.svg') }}" color="#b805fc"> 
   
    @else
    <!-- <link rel="short icon" type="image/png" sizes="16x16" href="{{ secure_asset('img/lucid-logo.svg') }}"> -->
    <link rel="stylesheet" href="{{ secure_asset('css/main-style.css') }}" />
    <link rel="stylesheet" href="{{ secure_asset('css/main-style.css') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ secure_asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ secure_asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ secure_asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ secure_asset('favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ secure_asset('favicon/safari-pinned-tab.svg') }}" color="#b805fc">
    @endif
    <title>Login</title>
</head>

<body>
    <div class="container text-center mt-5 justify-content-center">
        <div class="my-5">
            <a href="/" class="navbar-brand"><img alt="Lucid" src="@if($isLocal) {{ asset('img/logo.svg') }} @else {{ secure_asset('img/logo.svg') }}@endif" class="img-fluid" /></a>
        </div>
        <div class="my-3">
            <h4>Welcome back!</h4>
            <p class="text-muted my-4">New to Lucid? <a href="/register" class="text-secondary font-weight-bold">Sign Up</a></p>
        </div>
        
        <div class="d-inline-block w-custom">
            @if(session('success'))
            <div class="border-main text-main  my-3 w-100">{{session('success')}}</div>
            @endif
            <a href="@if($isLocal) {{ url('/login/google') }} @else {{ secure_url('/login/google') }} @endif" class="btn border-main text-main my-3 w-100"><i class="icon ion-logo-google p-1"></i> Continue with Google</a>
            <form class="mt-3" method="post" action="{{ route('sendMagicLink') }}">
            @csrf
                <div class="form-group">
                    <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Your email address">
                @if($errors->has('email'))
                    <span class="text-danger" style="font-size:12px;">{{ $errors->first('email') }}</span>
                @endif
                </div>
                
                <button type="submit" class="btn bg-alt text-white w-100">Continue with Email</button>
            </form>
        </div>

    </div>
</body>

</html>
