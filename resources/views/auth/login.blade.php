@extends('layouts.auth')

@section('metadata')
<title>Ingresar - {{ env('APP_NAME') }}</title>
@endsection

@section('content')
<!-- login area start -->
<div class="login-area login-bg">
    <div class="container">
        <div class="login-box ptb--100">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="login-form-head text-center" style="background: #083e69;">
                    <img src="{{ asset('assets/img/logo-light.png') }}" alt="Logo" style="max-height: 80px;" class="mb-2">
                    <p>Inicia sesión y comienza a gestionar tu riesgo y a medir tus resultados en las opciones binarias</p>
                </div>

                <div class="login-form-body">
                    <div class="form-gp">
                        <label for="exampleInputEmail1">Correo electrónico</label>
                        <input type="email" id="exampleInputEmail1" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <i class="ti-email"></i>
                        <div class="text-danger">@error('email') {{ $message }}  @enderror</div>
                    </div>

                    <div class="form-gp">
                        <label for="exampleInputPassword1">Contraseña</label>
                        <input type="password" id="exampleInputPassword1" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <i class="ti-lock"></i>
                        <div class="text-danger">@error('password') {{ $message }}  @enderror</div>
                    </div>

                    <div class="row mb-4 rmber-area">
                        <div class="col-6">
                            <div class="custom-control custom-checkbox mr-sm-2">
                                <input type="checkbox" class="custom-control-input" id="customControlAutosizing" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customControlAutosizing">Recuérdame</label>
                            </div>
                        </div>
                        <div class="col-6 text-right">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                            @endif
                        </div>
                    </div>

                    <div class="submit-btn-area">
                        <button id="form_submit" type="submit">Iniciar sesión <i class="ti-arrow-right"></i></button>
                    </div>

                    <div class="form-footer text-center mt-5">
                        <p class="text-muted">¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- login area end -->
@endsection
