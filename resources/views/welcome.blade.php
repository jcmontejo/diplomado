@extends('layouts.login')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="login-form-head">
    <img src="{{asset('assets/images/icon/logo_ser.png')}}" alt="" style="width:250px;">
        {{-- <h4>Inicia Sesión</h4> --}}
        {{-- <p>Hola, inicia sesión y comienza a administrar tu sistema.</p> --}}
    </div>
    <div class="login-form-body">
        <div class="form-gp">
            <label for="exampleInputEmail1">Correo Electrónico</label>
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                value="{{ old('email') }}" required autofocus>
            @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
            <i class="ti-email"></i>
        </div>
        <div class="form-gp">
            <label for="exampleInputPassword1">Contraseña</label>
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                name="password" required>
            <i class="ti-lock"></i>
            @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>
        {{-- <div class="row mb-4 rmber-area">
            <div class="col-6">
                <div class="custom-control custom-checkbox mr-sm-2">
                    <input type="checkbox" name="remember" id="remember" class="custom-control-input" id="customControlAutosizing"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="customControlAutosizing">Recordar</label>
                </div>
            </div>
        </div> --}}
        <div class="submit-btn-area">
            <button id="form_submit" type="submit">Entrar <i class="ti-arrow-right"></i></button>
        </div>
    </div>
</form>
@endsection
