@extends('layouts.menu')


@section('content')
<!-- название и адрес -->
<div class="intro">
	<div class="container">
		<div class="intro_inner">
			<h1 class="intro_title">{{ $menu['name'] }}</h1>
			<h2 class="intro_suptitle">{{ $menu['address'] }}</h2>
		</div>																
	</div>
</div>

<!-- "Меню" / поисковый запрос -->
<div style="padding-top: 40px;"class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4" style="display: inline;" id="menuHead">Меню</h1>
			<h1 class="display-4" style="display: none;" id="searchResult">
				Результаты поиска: <span id="searchString"></span>
				<button style="padding: 10px; display: inline;" type="button" class="close" aria-label="Close" id="closeSearch">
					<span aria-hidden="true">&times;</span>
				</button>
			</h1>
		</div>
	</div>
</div>

<!-- "ничего не найдено" -->
<div style="padding-top: 40px; display: none;"class="container-fluid padding" id="notFound">
	<div class="row welcome text-center">
		<div class="col-12">
			<h2>Ничего не найдено</h2>
		</div>
	</div>
</div>

<!-- секции с блюдами -->
<div class="accordion" id="productsList"></div>
@endsection


@section('modal')
<!-- корзина -->
<div class="modal fade" id="cartModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="cartBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
		<div style="padding-bottom: 0; border-bottom: none;" class="modal-header">
			<h3 class="modal-title" id="cartBackdropLabel">Корзина</h3>
			<button style="padding: 10px" type="button" class="close" data-dismiss="modal" aria-label="Close">
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
					<h5 style="margin:0; text-align: right;" class="card-text">Итог: <span id="orderSum">0</span> р.</h5>
					<hr>
					<div>
						<p style="margin: 10px 0;" class="card-text food-stats">Где будете есть?</p>
						<div style="padding: 0" class="col-12">
							<div class="list-group" id="list-tab" role="tablist">
								<a style="border-top-right-radius: 20px; border-top-left-radius: 20px;" class="list-group-item list-group-item-action active" data-toggle="list" role="tab" aria-controls="Inside">В ресторане</a>
								<a style="border-bottom-right-radius: 20px; border-bottom-left-radius: 20px;" class="list-group-item list-group-item-action" id="takeAway" data-toggle="list" role="tab" aria-controls="On-The-Go">Заберу с собой</a>
							</div>
						</div>
					</div>
					<hr>
					<label for="guestNameField">Ваше имя</label>
					<input type="text" style="border-color: #f36223; border-radius: 20px; box-shadow:none" class="form-control" id="guestNameField">
					<hr>
					<label for="orderComment">Комментарий к заказу</label>
					<textarea style="border-color: #f36223; border-radius: 20px; box-shadow:none" class="form-control" id="orderComment" rows="3"></textarea>
					<hr>
					<div style="max-width: 100%; overflow: hidden;">
						<div style="margin: 10px 0; white-space:nowrap">
							<p style="width: 45%;vertical-align: middle;margin: 0;display:inline-block;" class="card-text">Кол-во гостей</p>
							<div style="padding: 0; display: inline-block;" class="btn-group col-12" role="group" aria-label="Basic example">
										<button style="box-shadow:none;border-radius: 20px" type="button" class="col-2 btn btn-carrot" id="guestMinus">-</button>
										<button style="background-color: #fff; color: #000; padding: 0; border-color: #fff; box-shadow: none" id="guestCounter" type="button" class="col-2 btn btn-primary">1</button>
										<button style="box-shadow:none;border-radius: 20px" type="button" class="col-2 btn btn-carrot" id="guestPlus">+</button>
							</div>
						</div>
					</div>
					<hr>
					<div>
						<p style="margin: 10px 0;" class="card-text food-stats">Выберите способ оплаты</p>
						<div style="padding: 0;" class="col-12">
							<div class="list-group" id="list-tab" role="tablist">
								<a style="border-top-right-radius: 20px; border-top-left-radius: 20px;" class="list-group-item list-group-item-action active" data-toggle="list" role="tab" aria-controls="By cash">Наличными</a>
								<a style="border-bottom-right-radius: 20px; border-bottom-left-radius: 20px;" class="list-group-item list-group-item-action" id="payByCard" data-toggle="list" role="tab" aria-controls="By card">Картой</a>
							</div>
						</div>
					</div>
					<hr>
					<button style="box-shadow: none" class="btn btn-carrot col-12" id="makeOrder">Сделать заказ</button>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
@endsection


@section('script')
<script>
	let products = [],		// список блюд
		sections = [],		// список секций
		sum = 0;			// сумма заказа

	// загрузка секций/блюд
	$(document).ready(function () {
		$.ajax({
			url: '{{ url("/getProducts/" . $menu["id"]) }}',
			type: 'get',
			cache: false,
			contentType: false,
			processData: false,
			data: '', 
			success: function(data) {
				let menu = JSON.parse(data);
				for (let section of menu) 
					if (section['available'] && section['products'].length > 0) {
						section['img'] = "{{ URL::asset('storage/menus/' . $menu['id']) }}/" + section['id'] + '/' + section['img'];
						add_section(section);
						sections.push(section);
						for (let product of section['products']) 
							if (product['available']) {
								product['img'] = "{{ URL::asset('storage/menus/' . $menu['id']) }}/" + product['sectionId'] + '/products/' + product['img'];
								product['counter'] = 0;
								add_product(product);
								products.push(product);
							}
					}
			}
		});
	});

	// добавление блюда на страницу
	function add_product(product_data) {
		let product = new_usermenu_product(product_data);
		$(`[data-section="${product_data['sectionId']}"]`).find('.productWrap:first').append(product);
	}
	// добавление секции на страницу
	function add_section(section_data) {
		let section = new_usermenu_section(section_data);
		$('#productsList').append(section);
	}

	// найти блюдо по названию
	$(document).on('click', '#search', function() {
		let search_str = $('#searchBar').val().toLowerCase();
		$('#productsList').empty();
		if (search_str == '') {
			$('#menuHead').css('display', 'inline');
			$('#searchResult').css('display', 'none');
			$('#notFound').css('display', 'none');
			for (let section of sections) {
				add_section(section);
				for (let product of section['products'])
					add_product(product);
			}
		} else {
			$('#menuHead').css('display', 'none');
			$('#searchResult').css('display', 'inline');
			$('#searchString').html(search_str);
			let search_products = products.filter(p => p.name.toLowerCase().includes(search_str));
			if (search_products.length == 0) 
				$('#notFound').css('display', 'inline');
			else {
				$('#notFound').css('display', 'none');
				for (let section of sections) {
					let section_added = false;
					for (let product of section['products'])
						if (search_products.includes(product)) {
							if (!section_added) {
								add_section(section);
								section_added = true;
							}
							add_product(product);
						}
				}
			}
		}
	});
	// отменить поиск
	$(document).on('click', '#closeSearch', function() {
		$('#searchBar').val('');
		$('#search').click();
	});

	// добавить блюдо в корзину
	$(document).on('click', '.plus', function() {
		let productNode = $(this).parents('.product:first');
		let product = products.filter(p => p.id == productNode.attr('data-product'))[0];
		product['counter'] += 1;
		sum += Number(product['price']);
		recount_order_sum();
		$(`[data-product="${product['id']}"]`).find('.counter').html(product['counter']);
		$('#cartProductCount').html(products.filter(p => p.counter > 0).length);
	});
	// убрать блюдо из корзины
	$(document).on('click', '.minus', function() {
		let productNode = $(this).parents('.product:first');
		let product = products.filter(p => p.id == productNode.attr('data-product'))[0];
		if (product['counter'] > 0) {
			product['counter'] -= 1;
			sum -= Number(product['price']);
			recount_order_sum();
			$(`[data-product="${product['id']}"]`).find('.counter').html(product['counter']);
			$('#cartProductCount').html(products.filter(p => p.counter > 0).length);
		}
	});
	// пересчёт суммы заказа
	function recount_order_sum() {
		$('#orderSum').html(sum);
		if (sum > 0) {
			$('#cartLink').attr('data-target', '#cartModal');
			$('#cartSVG').attr('fill', 'currentColor');
		} else {
			$('#cartLink').attr('data-target', '');
			$('#cartSVG').attr('fill', '#888');
		}
	}

	// увеличить число гостей
	$(document).on('click', '#guestPlus', function() {
		let guests = Number($('#guestCounter').html());
		$('#guestCounter').html(guests + 1);
	});
	// уменьшить число гостей
	$(document).on('click', '#guestMinus', function() {
		let guests = $('#guestCounter').html();
		if (guests > 1)
			$('#guestCounter').html(guests - 1);
	});

	// сделать заказ
	$(document).on('click', '#makeOrder', function() {
		let cart = {};
		for (let product of products) 
			if (product['counter'] > 0)
				cart[product['id']] = product['counter'];
		let cartData = new FormData();
		cartData.append('products', JSON.stringify(cart));
		cartData.append('paymentMethod', $('#payByCard').hasClass('active')? 'card': 'cash');
		cartData.append('takeAway', $('#takeAway').hasClass('active')? 1: 0);
		cartData.append('guestName', $('#guestNameField').val());
		cartData.append('comment', $('#orderComment').val());
		cartData.append('guestNumber', $('#guestCounter').html());
		cartData.append('menuId', {{ $menu['id'] }});
		cartData.append('placeId', {{ $place['id'] }});
		cartData.append('_token', $('meta[name="csrf-token"]').attr('content'));
		$.ajax({
			url: '{{ url("/addOrder") }}',
			type: 'post',
			cache: false,
			contentType: false,
			processData: false,
			data: cartData,
			success: function(data) {
				document.location.replace("{{ url('/menu/' . $menu['id'] . '/wait?t=' . $place['id']) }}&o=" + data);
			}
		});
	});
</script>
@endsection