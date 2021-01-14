@extends('layouts.auth')

@section('content')
<div class="row">
    <div class="col">
		<h4 class="text-center">Подтвердите свой e-mail</h4>
        <hr>
		@if (session('resent'))
			<div class="alert alert-success" role="alert">
				Вам должно прийти письмо с ссылкой-подтверждением
			</div>
		@endif
		<h5 class="text-center">
			Перед тем, как продолжить, проверьте свою электронную почту (и папку "Спам"). <br>
			Если вы не получили письмо,
		</h5>
		<form method="POST" action="{{ route('verification.resend') }}" class="text-center">
			@csrf
            <button type="submit" class="btn btn-primary">нажмите здесь, чтобы отправить его снова</button>
        </form>
	</div>
</div>
@endsection