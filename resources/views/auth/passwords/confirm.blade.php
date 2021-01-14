@extends('layouts.auth')

@section('content')
<div class="row">
    <div class="col">
		<h4 style="text-center">Подтверждение пароля</h4>
		<h5 class="text-center">Перед тем, как продолжить, пожалуйста, подтвердите свой пароль</h5>
        <hr>
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <div class="form-group">
                <label>E-mail</label>
                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Пароль</label>
                <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Войти</button>
            @if (Route::has('password.request'))
                <button class="btn btn-primary">
                    <a href="{{ route('password.request') }}"
                        style="text-decoration: none; color: inherit;">
                        {{ __('Забыли пароль?') }}</a>
                </button>
			@endif
        </form>
    </div>
</div>
@endsection