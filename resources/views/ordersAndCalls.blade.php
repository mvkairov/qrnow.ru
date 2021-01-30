@extends('layouts.admin')

@section('title')
Заказы и вызовы в {{ $menu['name'] }}
@endsection

@section('content')
<div class="row">
	<!-- заказы -->
	<div style="text-align: center;" class="col">
		<h4>Заказы</h4>
		<hr>
		<div style="border: none;" class="modal-dialog modal-dialog-scrollable">
			<div style="border-color: #f36223" class="modal-content">
				<div class="modal-body" style="height: 70vh">
					<ul class="list-group" id="orders">
					
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- вызовы -->
	<div style="text-align: center;" class="col">
		<h4>Вызов персонала</h4>
		<hr>
		<div style="border: none;" class="modal-dialog modal-dialog-scrollable">
			<div style="border-color: #f36223" class="modal-content">
				<div class="modal-body" style="height: 70vh">
					<ul class="list-group" id="calls">
					
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection


@section('modal')
	<!-- карточка удаления заказа -->
<div class="modal fade" id="deleteOrderCard" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Заказ от <span id="deleteOrderTime"></span> выполнен и оплачен?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" id="deleteOrder">Да</button>
				<button type="button" class="btn btn-success" data-dismiss="modal">Нет</button>
			</div>
		</div>
	</div>
</div>

	<!-- карточка удаления вызова -->
<div class="modal fade" id="deleteCallCard" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Вызов от <span id="deleteCallTime"></span> выполнен?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" id="deleteCall">Да</button>
				<button type="button" class="btn btn-success" data-dismiss="modal">Нет</button>
			</div>
		</div>
	</div>
</div>
@endsection


@section('script')
<script>
	let orders = [],		// заказы
		calls = [],			// вызовы
		cur_order = {},		// удаляемый заказ
		cur_call = {};		// удаляемый вызов

	let refreshRate = setInterval(function() {		// обновление заказов/вызовов
		getOrders();
		getCalls();
	}, 25000);

	
	// загрузка заказов
	function getOrders() {
		$.ajax({
			url: '{{ url("/getOrders/" . $menu["id"]) }}',
			type: 'get',
			cache: false,
			contentType: false,
			processData: false,
			data: '', 
			success: function(data) {
				$('#orders').empty();
				let order_data = JSON.parse(data);
				for (let order of order_data) {
					let date = new Date(order['time'] * 1000);
					order['time'] = date.getHours() + ':' + date.getMinutes();
					order['token'] = $('meta[name="csrf-token"]').attr('content');
					order['payByCard'] = (order['paymentMethod'] == 'card');
					orders.push(order);
					add_order(order);
				}
			}
		});
	}
	// загрузка вызовов
	function getCalls() {
		$.ajax({
			url: '{{ url("/getCalls/" . $menu["id"]) }}',
			type: 'get',
			cache: false,
			contentType: false,
			processData: false,
			data: '', 
			success: function(data) {
				$('#calls').empty();
				let call_data = JSON.parse(data);
				for (let call of call_data) {
					let date = new Date(call['time'] * 1000);
					call['time'] = date.getHours() + ':' + date.getMinutes();
					call['token'] = $('meta[name="csrf-token"]').attr('content');
					call['garcon'] = (call['type'] == 'garcon');
					calls.push(call);
					add_call(call);
				}
			}
		});
	}

	// загрузка заказов/вызовов сразу после загрузки
	$(document).ready(function () {
		getOrders();
		getCalls();
	});

	// добавить заказ на страницу
	function add_order(order_data) {
		let order = new_list_order(order_data);
		$('#orders').append(order);
	}
	// добавить вызов на страницу
	function add_call(call_data) {
		let call = new_list_call(call_data);
		$('#calls').append(call);
	}

	// обновление удаляемого места
	$(document).on('click', '.deleteOrderBtn', function(e) {
		e.preventDefault();
		let orderId = $(this).parents('.order:first').attr('data-order');
		cur_order = orders.filter(o => o.id == orderId)[0];
		$('#deleteOrderTime').html(cur_order['time']);
	});
	// удалить место
	$(document).on('click', '#deleteOrder', function() {
		let form_data = new FormData();
		form_data.append('orderId', cur_order['id']);
		form_data.append('_token', $('meta[name="csrf-token"]').attr('content'));
		$.ajax({
			url: '{{ url("/deleteOrder") }}',
			type: 'post',
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			success: function() {
				let order = $(`[data-order="${cur_order['id']}"]`);
				order.remove();
				orders = orders.filter(o => o.id != cur_order['id']);
			}
		});
	});

	// обновление удаляемого вызова
	$(document).on('click', '.deleteCallBtn', function(e) {
		e.preventDefault();
		let callId = $(this).parents('.call:first').attr('data-call');
		cur_call = calls.filter(с => с.id == callId)[0];
		$('#deleteCallTime').html(cur_call['time']);
	});
	// удалить вызов
	$(document).on('click', '#deleteCall', function() {
		let form_data = new FormData();
		form_data.append('callId', cur_call['id']);
		form_data.append('_token', $('meta[name="csrf-token"]').attr('content'));
		$.ajax({
			url: '{{ url("/deleteCall") }}',
			type: 'post',
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			success: function() {
				let call = $(`[data-call="${cur_call['id']}"]`);
				call.remove();
				calls = calls.filter(c => c.id != cur_call['id']);
			}
		});
	});
</script>
@endsection