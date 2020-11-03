@extends('layouts.login_layout')
@section('content')
<div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <!-- <div>
                <h1 class="logo-name">IN+</h1>
            </div> -->
            <h3>Welcome to Wagler App</h3>
            <p>Login in. To see it in action.</p>
            <div id="errorSection" style="width:100% !important;">

            @if (session('session_error'))
            <div class="alert alert-danger">
                {{ session('session_error') }}
                <div class="pull-right closeIcon"><i class="fa fa-times" aria-hidden="true"></i></div>
            </div>
            @endif

            @if (session('session_success'))
            <div class="alert alert-success">
                {{ session('session_success') }}
                <div class="pull-right closeIcon"><i class="fa fa-times" aria-hidden="true"></i></div>
            </div>
            @endif

            @if (session('session_alert'))
            <div class="alert alert-warning">
                {{ session('session_alert') }}
                <div class="pull-right closeIcon"><i class="fa fa-times" aria-hidden="true"></i></div>
            </div>
            @endif
        </div>
            <form class="m-t" role="form" id="login" method="POST" action="{{ route('login') }}">
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="email" name="email" required="" autofocus>
                </div>
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                <a href="{{ route('forgot-password') }}"><small>Forgot password?</small></a>
                <!-- <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a> -->
            </form>
            <p class="m-t"> <small>Wagler App  &copy; {{ date('Y') }}</small> </p>
        </div>
    </div>
@endsection
