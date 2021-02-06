<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="{{ url('/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ url('css/admin.css')}} ">
	<link rel="stylesheet" href="{{ url('css/fonts.css') }}">
	<link rel="icon" type="image/png" href="{{ URL::to('/') }}/favicon.ico"/>
	<style>
		.custom-file-input ~ .custom-file-label::after {
			content: "Поиск" !important;
		}
	</style>

    <!-- внешние скрипты -->
	<script src="{{ url('/js/jquery-3.5.1.min.js') }}"></script>
	<script src="{{ url('/js/handlebars-v4.7.6.js') }}"></script>
	<script src="{{ url('/js/templates/admin.js') }}"></script>
	<script src="{{ url('/js/popper.min.js') }}"></script>
	<script src="{{ url('/js/bootstrap.min.js') }}"></script>
    <!-- подготовка ajax -- необходимо для отправки форм -->
	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>

	<title>@yield('title')</title>
</head>
<body>
	<!-- навбар -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<!-- статичная часть -->
		<a class="navbar-brand"><img src="{{ URL::to('/') }}/images/favicon.png" width="35" height="35" alt="" loading="lazy"></a>
		<a class="navbar-brand">QRnow</a>
		<ul class="navbar-nav mr-auto d-none d-md-block pl-1" style="border-left: 1px solid LightGray;">
			<li class="nav-item active">
				<a class="nav-link">Здравствуйте, {{ Auth::user()->name }}! <span class="sr-only">(current)</span></a>
			</li>
		</ul>

		<!-- ссылки -->
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			@if(isset($menu))
				<a class="ml-auto" href="{{ url('/start') }}">
					<button type="button" class="btn btn-md btn-dark m-1" style="margin-right: 5px;">
						Главная
					</button>
				</a>
				<a href="{{ url('/menu/' . $menu['id'] . '/orders') }}">
					<button type="button" class="btn btn-md btn-secondary m-1" style="margin-right: 5px;">
						Заказы
					</button>
				</a>
				<a href="{{ url('/menu/' . $menu['id'] . '/edit') }}">
					<button type="button" class="btn btn-md btn-secondary m-1" style="margin-right: 5px;">
						Редактировать
					</button>
				</a>
				<a href="{{ url('/menu/' . $menu['id'] . '/places') }}">
					<button type="button" class="btn btn-md btn-secondary m-1" style="margin-right: 5px;">
						QR-коды
					</button>
				</a>
			@endif
			<span class="@if(!isset($menu)) ml-auto @endif">
				@if (!isset($menu) and Auth::user()->hasVerifiedEmail() != 1)
					<a href="{{ url('/email/verify') }}">
						<button type="button" class="btn btn-md btn-primary m-1">
							Подтвердите ваш e-mail
						</button>
					</a>
				@endif
				<button type="button" 
						class="btn btn-md btn-danger m-1" 
						onclick="event.preventDefault();
								document.getElementById('logout-form').submit();">
						Выйти</button>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
					@csrf
				</form>
			</span>
		</div>
	</nav>

	<!-- контент -->
	<div style="margin-top: 10px" class="container">
		@yield('content')
	</div>
	

	<!-- модальные окна -->
	@yield('modal')
	

	<!-- основной скрипт -->
	@yield('script')
</body>
</html>