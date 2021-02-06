@extends('layouts.admin')


@section('title')
Ваши меню
@endsection

@section('content')
<div class="row">
	<div style="text-align: center; margin-top: 10px;" class="col">
		<h4>Создание</h4>
		<hr>
		<div class="modal-dialog">
			<div class="modal-content" style="border-color: #f36223;">
				<div style="padding: 20px; background-color: #fff; border-radius: 20px; min-height: 70vh;" class="col-12">
					<form action="/addMenu" enctype="multipart/form-data" method="POST" class="menuForm">
						{{ csrf_field() }}
						<div class="form-group">
							<label style="font-size: 20px;">Название</label>
							<input style="border-radius: 20px; border-color: #e14223; box-shadow: none" type="email" class="form-control" name="name">
						</div>
						<div class="form-group">
							<label style="font-size: 20px;">Адрес</label>
							<input style="border-radius: 20px; border-color: #e14223; box-shadow: none" type="email" class="form-control" name="address">
						</div>
						<div class="form-group">
							<label style="font-size: 20px;">В вашем заведении есть кальяны?</label><br>
							<label><input type="radio" name="hookah" value="1"> Да</label>
							<label><input type="radio" name="hookah" value="0"> Нет</label>
						</div>
						<div class="form-group">
							<label style="font-size: 20px; margin-top: -8px;">Фоновое изображение меню</label>
							<div class="custom-file">
								<input type="file" class="custom-file-input" name="img" id="customFile">
								<label class="custom-file-label" for="customFile">Выберите фон</label>
							</div>
						</div>
						<button type="submit" class="btn btn-secondary col-12 submitMenu" style="margin-top: 10px;">Перейти к конструктору</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div style="text-align: center; margin-top: 10px;" class="col">
		<h4>Ваши меню</h4>
		<hr>
		<div style="border: none;" class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content" style=" border-color: #f36223">
				<div class="modal-body" style="height: 70vh">
					<ul class="list-group" id="menus">
					
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection


@section('modal')
<!-- карточка удаления меню -->
<div class="modal fade" id="deleteMenuCard" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Вы хотите удалить "<span id="deleteMenuName"></span>"? Это действие необратимо</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" id="deleteMenu">Да</button>
				<button type="button" class="btn btn-success" data-dismiss="modal">Нет</button>
			</div>
		</div>
	</div>
</div>
@endsection


@section('script')
<script>
	let menus = [],		// список меню
		cur_menu = {};	// удаляемое меню

	// загрузка меню
	$(document).ready(function () {
		$.ajax({
			url: '{{ url("/getMenus") }}',
			type: 'get',
			cache: false,
			contentType: false,
			processData: false,
			data: '', 
			success: function(data) {
				menus = JSON.parse(data);
				for (let menu of menus) {
					menu['url'] = '{{ url("menu") }}/' + menu['id'];
					add_menu(menu);
				}
			}
		});
	});
	// добавление меню на страницу
	function add_menu(menu_data) {
		let menu = new_list_menu(menu_data);
		$('#menus').append(menu);
	}

	// добавление меню
	$(document).on('click', '.submitMenu', function(e) {
		e.preventDefault();
		let form = $(this).parents('form:first');
		let form_data = new FormData();

		form_data.append('name', form.find('input[name="name"]').val());
		form_data.append('address', form.find('input[name="address"]').val());
		form_data.append('hookah', form.find('input[name="hookah"]').val());
		form_data.append('_token', form.find('input[name="_token"]').val());

		let img_data = form.find('input[name="img"]').prop('files');
		if (img_data[0])
			form_data.append('img', img_data[0]);
		else {
			alert('Выберите фоновое изображение!');
			return;
		}

		$.ajax({
			url: '{{ url("/addMenu") }}',
			type: 'post',
			cache: false,
			contentType: false,
			processData: false,
			data: form_data, 
			success: function(data) {
				let menu = JSON.parse(data);
				location.href = '{{ url("/menu") }}/' + menu['id'] + '/edit';
			}
		});
	});
	
	// обновление удаляемого меню
	$(document).on('click', '.deleteMenuBtn', function(e) {
		let menuId = $(this).parents('.menu:first').attr('data-menu');
		cur_menu = menus.filter(m => m.id == menuId)[0];
		$('#deleteMenuName').html(cur_menu['name']);
	});
	// удаление меню
	$(document).on('click', '#deleteMenu', function(e) {
		let form_data = new FormData();
		form_data.append('menuId', cur_menu['id']);
		form_data.append('_token', $('meta[name="csrf-token"]').attr('content'));
		$.ajax({
			url: '{{ url("/deleteMenu") }}',
			type: 'post',
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			success: function() {
				let menu = $(`[data-menu="${cur_menu['id']}"]`);
				menu.remove();
				menus = menus.filter(m => m.id != cur_menu['id']);
			}
		});
	});

	// обновление label выбора фона
	$(document).on('change', '#customFile', function() {
		let form = $(this).parents('form:first');
		let img_data = form.find('input[name="img"]').prop('files');
		if (img_data[0])
			$(this).siblings('label:first').html(img_data[0].name);
	});
</script>
@endsection