@extends('layouts.auth')

@section('metadata')
<title>Registrate - {{ env('APP_NAME') }}</title>
@endsection

@section('content')
<!-- register area start -->
<div class="login-area login-bg">
    <div class="container">
        <div class="login-box ptb--100">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="login-form-head text-center" style="background: #083e69;">
                    <img src="{{ asset('assets/img/logo-light.png') }}" alt="Logo" style="max-height: 80px;" class="mb-2">
                    <p>Crea tu cuenta para comenzar a gestionar tu riesgo y efectividad en opciones binarias</p>
                </div>

                <div class="login-form-body">
                    <div class="form-gp">
                        <label for="name">Nombre completo</label>
                        <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        <i class="ti-user"></i>
                        <div class="text-danger">@error('name') {{ $message }} @enderror</div>
                    </div>

                    <div class="form-gp">
                        <label for="email">Correo electrónico</label>
                        <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        <i class="ti-email"></i>
                        <div class="text-danger">@error('email') {{ $message }} @enderror</div>
                    </div>

                    <div class="form-gp">
                        <label for="password">Contraseña</label>
                        <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        <i class="ti-lock"></i>
                        <div class="text-danger">@error('password') {{ $message }} @enderror</div>
                    </div>

                    <div class="form-gp">
                        <label for="password-confirm">Confirmar contraseña</label>
                        <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
                        <i class="ti-lock"></i>
                    </div>

                    <div class="submit-btn-area">
                        <button type="submit">Registrarse <i class="ti-arrow-right"></i></button>
                    </div>

                    <div class="form-footer text-center mt-5">
                        <p class="text-muted">¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- register area end -->
@endsection
