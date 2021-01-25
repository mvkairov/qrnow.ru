@extends('layouts.menu')


@section('content')
<div class="intro">
	<div class="container">
		<div class="intro_inner">
			<h1 class="intro_title">Спасибо! Ваш заказ скоро будет готов <br>
									вызовите официанта для оплаты</h1>
		</div>
		<button class="btn col-12 btn-carrot" onclick="location.href = '{{ url('/menu/' . $menu['id'] . '?t=' . $place['id']) }}';">Сделать новый заказ</button>								
	</div>
</div>
@endsection


@section('modal')
<!-- корзина -->
<div class="modal fade" id="cartModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="cartBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
		<div style="padding-bottom: 0; border-bottom: none;" class="modal-header">
			<h3 class="modal-title" id="cartBackdropLabel">Ваш заказ</h3>
			<button style="padding: 10px" type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeCartBtn">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div style="padding: 20px;" class="col-12">
			<div class="card" style="border-color: #fff">
				<div class="card-body">
					<hr>
					<span id="cartProducts">
						
					</span>
					<hr>
					<h5 style="text-align: right;" class="card-text">Итог: {{ $order['sum'] }}р.</h5>
					@if($order->comment)
						<h5 style="text-align: right;" class="card-text">Ваш комментарий: {{ $order->comment }}</h5>
					@endif
					<h5 style="text-align: right;" class="card-text">Время заказа {{ substr($order->updated_at, 11, 5) }}</h5>
					<hr>
					<h5 class="card-text text-center">Чтобы оплатить, вызовите официанта</h5>
					<button style="box-shadow: none" class="btn btn-carrot col-12" id="callFromCart" data-dismiss="modal">Вызвать</button>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
@endsection


@section('script')
<script>
	let products = [];  // список блюд

	// загрузка заказа
	$(document).ready(function () {
		$.ajax({
			url: '{{ url("/getOrder/" . $order["id"]) }}',
			type: 'get',
			cache: false,
			contentType: false,
			processData: false,
			data: '', 
			success: function(data) {
				let order = JSON.parse(data);
				for (let product of order) {
					product['img'] = "{{ URL::asset('storage/menus/' . $menu['id']) }}/" + product['sectionId'] + '/products/' + product['img'];
					product['sum'] = product['count'] * product['price'];
					products.push(product);
					add_product(product);
				}
				$('#cartProductCount').html(products.length);
			}
		});
	});
	// добавить блюдо в корзину
	function add_product(product_data) {
		let product = wait_cart_product(product_data);
		$('#cartProducts').append(product);
	}

	// вызов официанта кнопкой из корзины
	$(document).on('click', '#callFromCart', function() {
		$('#garcon').click();
	});
	// отрисовка корзины (из-за глюка)
	$(document).on('click', '.product', function() {
		for (let product of products)
			add_product(product);
	});

</script>
@endsection