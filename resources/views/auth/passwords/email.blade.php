@extends('layouts.auth')

@section('content')
<div class="row">
    <div class="col">
        <h4 style="text-align: center;">Сброс пароля</h4>
        <hr>
        <form method="POST" action="{{ route('password.email') }}">
			@csrf
			<div class="form-group">
				@if (session('status'))
					<div class="alert alert-success" role="alert">
						{{ session('status') }}
					</div>
				@endif
			</div>
            <div class="form-group">
                <label>E-mail</label>
                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Отправить ссылку для сброса пароля</button>
        </form>
    </div>
</div>
@endsection