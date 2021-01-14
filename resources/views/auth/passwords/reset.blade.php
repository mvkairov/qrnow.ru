@extends('layouts.auth')

@section('content')
<div class="row">
    <div class="col">
        <h4 style="text-align: center;">Сброс пароля</h4>
        <hr>
        <form method="POST" action="{{ route('password.update') }}">
			@csrf
			<input type="hidden" name="token" value="{{ $token }}">
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
                <label>Новый пароль</label>
                <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
			</div>
			<div class="form-group">
                <label>Подтвердите пароль</label>
                <input class="form-control @error('password') is-invalid @enderror" type="password" id="password-confirmation" name="password_confirmation" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary">Сбросить пароль</button>
        </form>
    </div>
</div>
@endsection