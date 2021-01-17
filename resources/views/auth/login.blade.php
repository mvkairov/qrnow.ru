@extends('layouts.auth')

@section('content')
<div class="row">
    <div class="col">
        <h4 style="text-align: center;">Авторизация</h4>
        <hr>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>E-mail</label>
                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Пароль</label>
                <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Войти</button>
            <button class="btn btn-primary m-1">
                <a href="{{ route('register') }}"
                        style="text-decoration: none; color: inherit;">
                        Нет аккаунта?</a>
            </button>
            @if (Route::has('password.request'))
                <button class="btn btn-primary m-1">
                    <a href="{{ route('password.request') }}"
                        style="text-decoration: none; color: inherit;">
                        {{ __('Забыли пароль?') }}</a>
                </button>
            @endif
        </form>
    </div>
</div>
@endsection