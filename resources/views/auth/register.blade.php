@extends('layouts.auth')

<!-- важное замечание: в App/Http/Controllers/Auth/RegisterController.php -->
<!-- нужно удалить выделенный код (после завершения ограниченного тестирования) -->
@section('content')
<div class="row">
    <div class="col">
        <h4 class="text-center">Регистрация</h4>
        <hr>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label>Ваше имя</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
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
                <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Подтвердите пароль</label>
                <input class="form-control" type="password" id="password-confirm" name="password_confirmation" autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary m-1">Зарегистрироваться</button>
            <button class="btn btn-primary m-1">
                <a href="{{ route('login') }}"
                        style="text-decoration: none; color: inherit;">
                        Уже есть аккаунт?</a>
            </button>
        </form>
    </div>
</div>
@endsection