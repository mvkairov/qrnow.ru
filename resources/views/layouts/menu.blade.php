<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="{{ url('/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ url('/css/usermenu.css') }}">
	<link rel="stylesheet" href="{{ url('/css/fonts.css') }}">
	<link rel="icon" type="image/png" href="{{ URL::to('/') }}/favicon.ico"/>
    <style>
        .intro {
            background: url("{{ URL::asset('storage/menus/' . $menu['id'] . '/' . $menu['img']) }}") center no-repeat;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #fff;
        }
    </style>

     <!-- внешние скрипты -->
	<script src="{{ url('/js/jquery-3.5.1.min.js') }}"></script>
	<script src="{{ url('/js/handlebars-v4.7.6.js') }}"></script>
	<script src="{{ url('/js/templates.js') }}"></script>
	<script src="{{ url('/js/popper.min.js') }}"></script>
	<script src="{{ url('/js/bootstrap.min.js') }}"></script>
	<script src="{{ url('/js/fontawesome.js') }}"></script>
    <!-- подготовка ajax -- необходимо для отправки форм -->
	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(71197969, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true,
                webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/71197969" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

	<title>{{ $menu['name'] }}</title>
</head>
<body>
	<!--- навбар --->
	<header class="header">
		<div class="container">
			<div class="header_inner">
				<!-- иконка официанта -->
				<nav class="nav">
					<button style="background: none; border:none; padding: 1px" class="dropdown-toggle nav_link" type="button" id="garconButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<!-- <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-bell" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						  <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2z"/>
						  <path fill-rule="evenodd" d="M8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
						</svg> -->
                        <object type="image/svg+xml" data="picture.svg">
						    <img style="width: 3em" src="{{ url('/images') }}/waiter.svg" alt="Fallback">
						</object>
					</button>
					<div class="dropdown-menu" aria-labelledby="garconButton">
						<button style="font-size: 17px; padding: 4px 4px;" class="dropdown-item" data-toggle="modal" data-target="#garconModal" id="garcon">Позвать официанта</button>
					</div>
				</nav>


                @if ($menu->hookah)
                    <!-- иконка кальянщика -->
                    <nav class="nav">
                        <button style="background: none; border: none; padding: 1px" class="dropdown-toggle nav_link" type="button" id="hookahButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <!-- <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-funnel" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/>
                            </svg> -->
                            <object type="image/svg+xml" data="picture.svg">
                                <img style="width: 3em" src="{{ url('/images') }}/hookah.svg" alt="Фолбэк">
                            </object>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="hookahButton">
                            <button style="font-size: 17px; padding: 4px 4px;" class="dropdown-item" data-toggle="modal" data-target="#hookahModal" id="hookah">Позвать кальянщика</button>
                        </div>
                    </nav>
                @endif

				<!-- лого -->
				<nav class="nav">
					<a class="nav_link"><img style="max-width: 3em; max-height: 3em;" src="{{ URL::to('/') }}/images/favicon.png" alt=""></a>
				</nav>

				<!-- иконка корзины -->
				<nav class="nav" id="cartButton">
                    <li style="display: block; position: relative; float: left;" data-toggle="modal" data-target="@if(isset($order)) #cartModal @endif" id="cartLink">
                        <a style="display: block;" class="nav_link"><svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-basket" fill="@if(isset($order))#currentColor @else #666 @endif" id="cartSVG" style="transition: 0.3s ease;" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z"/>
                        </svg></a>
                        <span id="cartProductCount"
                              style="right: -1px;
                                    bottom:-1px;
                                    position: absolute; 
                                    text-align: center; 
                                    color: #fff; 
                                    border-color: #f36223; 
                                    border-radius: 20px; 
                                    background-color: #f36223; 
                                    min-width: 25px; 
                                    padding: 0 4px; 
                                    border: 2px solid #fff;">0</span>
                    </li>
				</nav>
                

                @if (!isset($order))
                    <!-- иконка поиска -->
                    <nav class="nav">
                        <button style="background:none; border:none; padding: 1px" class="dropdown-toggle nav_link" type="button" id="searchButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                            </svg>
                        </button>
                        <div style="padding: 10px; padding-bottom: 0;" class="dropdown-menu" aria-labelledby="searchButton">
                            <div>
                                <div class="form-group">
                                    <label for="searchBar">Что вы хотите найти?</label>
                                    <input type="email" class="form-control" id="searchBar" aria-describedby="emailHelp">
                                </div>
                            </div>
                            <button style="font-size: 17px;" class="btn" id="search">Найти</button>
                        </div>
                    </nav>
                @endif
			</div>
		</div>
	</header>

    
    <!-- основная часть страницы -->
    @yield('content')


    <!-- футер -->
    <footer class="page-footer bg-dark">
		<div style="background-color: #f36223;">
			<div class="container">
				<div class="py-4 row d-flex align-items-center">
					<div class="col-md-12 text-center">
						<a style="margin: 0 15px"><i style="color:#fff; font-size: 2em;" class="fa fa-vk" aria-hidden="true"></i></a>
						<a style="margin: 0 15px"><i style="color: #fff; font-size: 2em;" class="fa fa-telegram" aria-hidden="true"></i></a>
					</div>
				</div>
			</div>
		</div>
		<div class="container text-center text-md-left mt-5">
			<div class="row">
				<div class="col-md-3 mx-auto mb-4">
					<h6 style="color:#fff" class="text-uppercase font-weight-bold">Авторы иконок</h6>
					<hr class="mb-4 mt-0 d-inline-block mx-auto" style="background-color: #f36223; width: 150px; height: 2px ">
					<div style="color: #fff;"><a href="https://www.flaticon.com/ru/authors/surang" title="surang">surang</a> from <a href="https://www.flaticon.com/ru/" title="Flaticon">www.flaticon.com</a></div>
					<div style="color: #fff;"><a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/ru/" title="Flaticon">www.flaticon.com</a></div>
				</div>
			</div>
		</div>
	</footer>

	<!-- модальные окна -->

    @yield('modal')

		<!-- вызов официанта -->
	<div class="modal fade" id="garconModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="garconBackdropLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 style="text-align: center;" class="modal-title" id="garconBackdropLabel">Вы позвали официанта!</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	    </div>
	  </div>
	</div>

		<!-- вызов кальянщика -->
	<div class="modal fade" id="hookahModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="hookahBackdropLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 style="text-align: center;" class="modal-title" id="hookahBackdropLabel">Вы позвали кальянщика!</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	    </div>
	  </div>
	</div>

		<!-- карточка блюда - одна для всех -->
    <div class="modal fade" id="productModalCard" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"> 
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div style="padding-bottom: 0; border-bottom: none;" class="modal-header">
                    <button style="padding: 10px" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="productModalContents" style="padding: 20px;" class="col-12">
                    
                </div>
            </div>
        </div>
    </div>


    <!-- общий скрипт -->
    <script>
        // вызов карточки блюда
        $(document).on('click', '.product', function() {
            let productId = $(this).attr('data-product');
            let cur_product = products.filter(p => p.id == productId)[0];
			update_modal(cur_product);
			// обновление корзины
			let cart_products = update_usermenu_cart({'products': products});
			$('#cartProducts').html(cart_products);
		});
		// обновление карточки блюда
        function update_modal(product_data) {
            let product_modal = update_usermenu_product_modal(product_data);
            $('#productModalContents').html(product_modal);
        }
        
        // позвать официанта
        $(document).on('click', '#garcon', function(e) {
            e.preventDefault();
            let call_data = new FormData();
            call_data.append('menuId', "{{ $menu['id'] }}");
            call_data.append('placeId', "{{ $place['id'] }}");
            call_data.append('type', 'garcon');
            $.ajax({
                url: '{{ url("/addCall") }}',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: call_data
            });
		});
		// позвать кальянщика
        $(document).on('click', '#hookah', function(e) {
            e.preventDefault();
            let call_data = new FormData();
            call_data.append('menuId', "{{ $menu['id'] }}");
            call_data.append('placeId', "{{ $place['id'] }}");
            call_data.append('type', 'hookah');
            $.ajax({
                url: '{{ url("/addCall") }}',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: call_data
            });
        });
    </script>
    <!-- основной скрипт -->
    @yield('script')
</body>
</html>
