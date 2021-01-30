@extends('layouts.admin')

@section('title')
QR-коды в {{ $menu['name'] }}
@endsection

@section('content')
<div class="row">
	<!-- форма нового места -->
	<div class="col text-center mt-1">
		<h4 class="text-center">Создайте</h4>
		<hr>
		<div class="modal-dialog">
			<div style="border-color: #f36223" class="modal-content">
				<div style="border: none;" class="modal-header text-center">
					<h3 class="modal-title w-100">Добавьте QR-код</h3>
				</div>
				<div style="padding: 20px; background-color: #fff; border-radius: 20px;" class="col-12">
					<form action="/addPlace" enctype="multipart/form-data" method="POST" class="addPlace">
						{{ csrf_field() }}
						<div class="modal-body">
							<label>Введите название или номер места</label>
							<input style="border-color: #f36223; border-radius: 20px; box-shadow: none" type="text" class="form-control" name="name">
						</div>
						<input type="hidden" name="menuId" value="{{ $menu['id'] }}">
						<div style="border: none" class="modal-footer">
							<button type="button" class="btn btn-carrot w-100 submitPlace" data-dismiss="modal">Добавить</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- список кодов -->
	<div class="col text-center mt-1">
		<h4>Ваши QR-коды</h4>
		<hr>
		<div style="border: none;" class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content" style="border-color: #f36223">
				<div class="modal-body" style="height: 70vh">
					<ul class="list-group" id="places">
						
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- div с qr кодом для загрузки -->
<div id="qr" style="display: none;"></div>
@endsection


@section('modal')
	<!-- карточка удаления места -->
<div class="modal fade" id="deletePlaceCard" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Вы хотите удалить "<span id="deletePlaceName"></span>"?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" id="deletePlace">Да</button>
				<button type="button" class="btn btn-success" data-dismiss="modal">Нет</button>
			</div>
		</div>
	</div>
</div>
@endsection


@section('script')
<script src="{{ url('/js/jquery.qrcode.min.js') }}"></script>
<script>
	let places = [],		// список мест/qr-кодов
		cur_place = {};		// место для удаления

	// загрузка мест
	$(document).ready(function () {
		$.ajax({
			url: '{{ url("/getPlaces/" . $menu["id"]) }}',
			type: 'get',
			cache: false,
			contentType: false,
			processData: false,
			data: '', 
			success: function(data) {
				let places_data = JSON.parse(data);
				for (let place of places_data) {
					add_place(place);
					places.push(place);
				}
			}
		});
	});

	// добавление места на страницу
	function add_place(place_data) {
		let place = new_list_place(place_data);
		$('#places').append(place);
	}

	// скачать qr-код
	download_img = function(el) {
		let id = el.getAttribute('data-place');
		let name = el.getAttribute('data-name');
		$('#qr').qrcode({
			text: '{{ url("/menu/" . $menu["id"]) }}?t=' + id,
			background: '#fff'
		});
		var canvas = document.querySelector("#qr canvas");
		var img = canvas.toDataURL("image/png");
		var dl = document.createElement('a');
		dl.setAttribute('href', img);
		dl.setAttribute('download', name + ' в {{ $menu["name"] }}.png');
		dl.click();
	};
	
	// добавить место
	$(document).on('click', '.submitPlace', function(e) {
		e.preventDefault();
		let name = $('.addPlace').find('input[name="name"]').val();
		if (places.filter(p => p.name == name).length > 0) {
			alert('Место "' + name + '" уже существует!');
			return false;
		}
		if (name == '') {
			alert('Введите название!');
			return false;
		}
		$.ajax({
			url: '{{ url("addPlace") }}',
			type: 'post',
			data: $('.addPlace').serialize(),
			success: function(data) {
				let place = JSON.parse(data);
				add_place(place);
				places.push(place);
				$('.addPlace').trigger("reset");
			}
		});
	});

	// обновление удаляемого места
	$(document).on('click', '.deletePlaceBtn', function(e) {
		let placeId = $(this).parents('.place:first').attr('data-place');
		cur_place = places.filter(p => p.id == placeId)[0];
		$('#deletePlaceName').html(cur_place['name']);
	});
	// удаление места
	$(document).on('click', '#deletePlace', function(e) {
		let form_data = new FormData();
		form_data.append('placeId', cur_place['id']);
		form_data.append('_token', $('meta[name="csrf-token"]').attr('content'));
		$.ajax({
			url: '{{ url("/deletePlace") }}',
			type: 'post',
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			success: function() {
				let place = $(`[data-place="${cur_place['id']}"]`);
				place.remove();
				places = places.filter(p => p.id != cur_place['id']);
			}
		});
	});
</script>
@endsection
