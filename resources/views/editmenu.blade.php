<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="stylesheet" href="{{ url('/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ url('/css/editmenu.css') }}">
	<link rel="stylesheet" href="{{ url('/css/fonts.css') }}">
	<link rel="icon" type="image/png" href="{{ URL::to('/') }}/images/favicon.png"/>

    <style>
        body {
            padding-right: 0 !important;
        }
        * {
            transition: 0.2s !important;
        }
    </style>	

    <!-- внешние скрипты -->
	<script src="{{ url('/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ url('/js/handlebars-v4.7.6.js') }}"></script>
    <script src="{{ url('/js/templates.js') }}"></script>
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

	<title>Редактировать {{ $menu['name'] }}</title>
</head>
<body>
	<!--- навбар --->
    <header style="margin: 0 auto" class="header col-xl-5 col-md-7 col-sm-11">
		<div class="container">
			<div class="header_inner">
                <nav class="nav">
                    <a href="{{ url('/start') }}">
                        <button class="btn btn-carrot nav_link text-white">Главная</button>
                    </a>
                </nav>
                <nav class="nav">
                    <a class="nav_link"><img style="max-width: 5em; max-height: 5em;" src="{{ URL::to('/') }}/images/favicon.png" alt=""></a>
                </nav>
                <nav class="nav">
                    <a href="{{ url('/menu/' . $menu['id'] . '/orders') }}">
                        <button class="btn btn-carrot nav_link text-white">Заказы</button>
                    </a>
                </nav>
			</div>
		</div>
	</header>

    <!-- редактор основной информации меню -->
	<div style="margin: 0 auto; background-color: #eee; background: url('{{ URL::asset('storage/menus/' . $menu['id'] . '/' . $menu['img']) }}') center no-repeat;" class="intro col-xl-5 col-md-7 col-sm-11">
		<div class="container">
			<div class="intro_inner">
				<h1 style="font-size: 50px;" class="intro_title">
                    {{ $menu['name'] }}
                </h1>
                <button class="btn btn-carrot updateMenuBtn" data-toggle="modal" data-target="#updateMenuCard">Обновить меню</button>
			</div>																
		</div>
	</div>
	<div style="padding-top: 40px;"class="container-fluid padding">
		<div class="row welcome text-center">
			<div class="col-12">
				<h1 class="display-4">Меню</h1>
			</div>
		</div>
	</div>


	<!-- секции с блюдами -->
	<div style="text-align: center;">
		<button class="btn btn-carrot col-xl-5 col-md-7 col-sm-11" data-toggle="modal" data-target="#addSectionCard">Добавить раздел</button>
	</div>
	
	<div class="accordion mb-2" id="productsList">
	  	
	</div>



	<!-- Модальные окна -->


        <!-- карточка просмотра блюда -->
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
        <!-- карточка добавления/изменения блюда -->
    <div class="modal fade" id="addProductCard" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"> 
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border-color: #f36223;">
                <div style="padding-bottom: 0; border-bottom: none;" class="modal-header">
                    <button style="padding: 10px" type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeProductCard">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div style="padding: 20px; background-color: #fff; border-radius: 20px; border-color: #f36223;" class="col-12">
                    <form action="/addSection" enctype="multipart/form-data" method="POST" id="addProductForm">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label style="font-size: 30px;">Введите название блюда</label>
                            <input style="border-radius: 20px; border-color: #f36223; box-shadow: none" type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 30px;">Выберите изображение блюда <span class="text-small" id="updateImgText">(оставьте поле пустым, если не хотите менять изображение)</span></label>
                            <input style="border-radius: 20px; border-color: #f36223; box-shadow: none" type="file" class="form-control-file" name="img" required>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 30px;">Укажите цену (в рублях)</label>
                            <input style="border-radius: 20px; border-color: #f36223; box-shadow: none" type="number" class="form-control" name="price" required>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 30px;">Добавьте краткое описание блюда</label>
                            <textarea style="border-radius: 20px; border-color: #f36223; box-shadow: none" class="form-control" rows="3" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 30px;">Ингредиенты</label>
                            <textarea style="border-radius: 20px; border-color: #f36223; box-shadow: none" class="form-control" rows="3" name="ingridients"></textarea>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 30px;">Время приготовления</label>
                            <input style="border-radius: 20px; border-color: #f36223; box-shadow: none" type="text" class="form-control" name="prepare_time">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 30px;">Укажите (при необходимости)</label>
                            <input style="border-radius: 20px; border-color: #f36223; box-shadow: none" type="number" class="form-control" placeholder="Вес блюда(г)" name="wt">
                            <hr>
                            <input style="border-radius: 20px; border-color: #f36223; box-shadow: none" type="number" class="form-control" placeholder="Калории(ккал)" name="cl">
                            <hr>
                            <input style="border-radius: 20px; border-color: #f36223; box-shadow: none" type="number" class="form-control" placeholder="Белки(г)" name="pr">
                            <hr>
                            <input style="border-radius: 20px; border-color: #f36223; box-shadow: none" type="number" class="form-control" placeholder="Жиры(г)" name="ft">
                            <hr>
                            <input style="border-radius: 20px; border-color: #f36223; box-shadow: none" type="number" class="form-control" placeholder="Углеводы(г)" name="ch">
                        </div>
                        <input type="number" name="sectionId" hidden>
                        <button type="submit" class="btn btn-carrot col-12 submitProduct">Добавить блюдо</button>
                        <button style="display: none;" type="submit" class="btn btn-carrot col-12 updateProduct">Внести изменения</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <!-- карточка удаления блюда -->
    <div class="modal fade" id="deleteProductCard" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Вы хотите удалить "<span id="deleteProductName"></span>"?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" style="border-radius: 30px; margin-top: 10px;" class="btn btn-danger col-12" data-dismiss="modal" id="deleteProduct">Да</button>
                    <button type="button" style="border-radius: 30px; margin-top: 10px;"class="btn btn-success" data-dismiss="modal">Нет</button>
                </div>
            </div>
        </div>
    </div>


        <!-- карточка добавления секции -->
    <div class="modal fade" id="addSectionCard" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"> 
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border-color: #f36223;">
                <div style="padding-bottom: 0; border-bottom: none;" class="modal-header">
                    <button style="padding: 10px" type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeSectionCard">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div style="padding: 20px; background-color: #fff; border-radius: 20px; border-color: #f36223;" class="col-12">
                    <form action="/addSection" enctype="multipart/form-data" method="POST">
                        {{ csrf_field() }}
                        <input type="number" value="{{ $menu['id'] }}" name="menuId" hidden>
                        <div class="form-group">
                            <label style="font-size: 30px;">Введите название раздела</label>
                            <input style="border-radius: 20px; border-color: #e14223; box-shadow: none" type="email" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 30px;">Выберите фоновое изображение раздела</label>
                            <input type="file" class="form-control-file" name="img">
                        </div>
                        <button type="submit" class="btn btn-carrot col-12 submitSection">Добавить раздел</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <!-- карточка удаления секции -->
    <div class="modal fade" id="deleteSectionCard" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Вы хотите удалить раздел "<span id="deleteSectionName"></span>"?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" style="border-radius: 30px; margin-top: 10px;" class="btn btn-danger col-12" data-dismiss="modal" id="deleteSection">Да</button>
                    <button type="button" style="border-radius: 30px; margin-top: 10px;" class="btn btn-success" data-dismiss="modal">Нет</button>
                </div>
            </div>
        </div>
    </div>


        <!-- карточка редактирования меню -->
    <div class="modal fade" id="updateMenuCard" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"> 
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border-color: #f36223;">
                <div style="padding-bottom: 0; border-bottom: none;" class="modal-header">
                    <button style="padding: 10px" type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeMenuCard">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div style="padding: 20px; background-color: #fff; border-radius: 20px; border-color: #f36223;" class="col-12">
                    <form action="/updateMenu" enctype="multipart/form-data" method="POST">
                        {{ csrf_field() }}
                        <input type="number" value="{{ $menu['id'] }}" name="id" hidden>
                        <div class="form-group">
                            <label style="font-size: 30px;">Введите новый адрес</label>
                            <input style="border-radius: 20px; border-color: #e14223; box-shadow: none" class="form-control" name="address">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 30px;">Выберите фоновое изображение <span class="text-small">(оставьте поле пустым, если не хотите менять изображение)</span></label>
                            <input type="file" class="form-control-file" name="img">
                        </div>
                        <button type="submit" class="btn btn-carrot col-12 updateMenu">Внести изменения</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- основной скрипт -->
    <script>
		let products = [],		// список блюд
			sections = [],		// список секций
            sum = 0,			// сумма заказа
            cur_section = {},   // изменяемая/удаляемая секция
            cur_product = {},   // изменяемое/удаляемое блюдо
            address = '{{ $menu["address"] }}';       // адрес

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
                    for (let section of menu) {
                        section['img'] = "{{ URL::asset('storage/menus/' . $menu['id']) }}/" + section['id'] + '/' + section['img'];
                        add_section(section);
                        sections.push(section);
                        for (let product of section['products']) {
                            product['img'] = "{{ URL::asset('storage/menus/' . $menu['id']) }}/" + product['sectionId'] + '/products/' + product['img'];
                            product['unavailable'] = !product['available'];
                            add_product(product);
							products.push(product);
                        }
					}
                }
            });
        });
		// добавление блюда на страницу
        function add_product(product_data) {
            let product = new_editmenu_product(product_data);
            $(`[data-section="${product_data['sectionId']}"]`).find('.productWrap:first').append(product);
        }
		// добавление секции на страницу
        function add_section(section_data) {
            let section = new_editmenu_section(section_data);
            $('#productsList').append(section);
		}

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
        
        // обновление карточки добавления блюда
        $(document).on('click', '.addProductBtn', function() {
            $('.submitProduct').parents('form:first').trigger("reset");
            $('.submitProduct').css('display', 'block');
            $('.updateProduct').css('display', 'none');
            $('#updateImgText').css('display', 'none');
            let curSection = $(this).parents('.section:first').attr('data-section');
            $('#addProductCard').find('input[name="sectionId"]').val(curSection);
        });
        // добавление блюда
        $(document).on('click', '.submitProduct', function(e) {
            if (!checkProductForm(true))
                return false;

            e.preventDefault();
            let form = $(this).parents('form:first');
            let form_data = new FormData();

            form_data.append('name', form.find('input[name="name"]').val());
            form_data.append('price', form.find('input[name="price"]').val());
            form_data.append('description', form.find('textarea[name="description"]').val());
            form_data.append('ingridients', form.find('textarea[name="ingridients"]').val());
            form_data.append('prepare_time', form.find('input[name="prepare_time"]').val());
            form_data.append('sectionId', form.find('input[name="sectionId"]').val());
            form_data.append('_token', form.find('input[name="_token"]').val());

            let img_data = form.find('input[name="img"]').prop('files')[0];
            form_data.append('img', img_data);
            let stats = make_stats(form.serializeArray());
            form_data.append('stats', stats);
            $.ajax({
                url: '{{ url("/addProduct") }}',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data, 
                success: function(data) {
                    form.trigger("reset");
                    $('#closeProductCard').click();
                    let product = JSON.parse(data);
                    product['img'] = "{{ URL::asset('storage/menus/' . $menu['id']) }}/" + product['sectionId'] + '/products/' + product['img'];
                    product['available'] = true;
                    add_product(product);
                    products.push(product);
                    sections.forEach(function(section, i) {
                        if (section['id'] == product['sectionId'])
                            sections[i]['products'].push(product);
                    });
                }
            });
        });
        // генерация поля с весом итп
        function make_stats(array_data) {
            data = {};
            for (let stat of array_data)
                data[stat.name] = stat.value;
            let stats = '';
            if (data['wt']) stats += data['wt'] + 'г\n';
            if (data['cl']) stats += data['cl'] + 'ккал\n';
            if (data['pr']) stats += 'Б ' + data['pr'] + 'г\n';
            if (data['ft']) stats += 'Ж ' + data['ft'] + 'г\n';
            if (data['ch']) stats += 'У ' + data['ch'] + 'г\n';
            return stats;
        }
        function checkProductForm(hasImg) {
            let ok = true,
                reqs = {
                'name': 'название',
                'description': 'описание',
                'price': 'цену',
            };
            if (hasImg)
                reqs['img'] = 'изображение';
            $('#addProductCard').find('input').each(function(key, el) {
                if (!el.value && (el.name in reqs)) {
                    alert('Вы не ввели ' + reqs[el.name] + ' блюда!');
                    ok = false;
                }
            });
            return ok;
        }

        // обновление карточки изменения блюда
        $(document).on('click', '.updateProductBtn', function() {
            let form = $('#addProductForm');
            $('.submitProduct').css('display', 'none');
            $('.updateProduct').css('display', 'block');
            $('#updateImgText').css('display', 'block');

            cur_product = products.filter(p => p.id == $(this).parents('.product:first').attr('data-product'))[0];
            form.find('input[name="price"]').val(cur_product['price']);
            form.find('input[name="name"]').val(cur_product['name']);
            form.find('input[name="sectionId"]').val(cur_product['sectionId']);
            form.find('textarea[name="description"]').val(cur_product['description']);
            form.find('input[name="prepare_time"]').val(cur_product['prepare_time']);
            form.find('textarea[name="ingridients"]').val(cur_product['ingridients']);
            if (cur_product['stats']) {
                let stats_arr = break_stats(cur_product['stats']);
                for (let stat in stats_arr) 
                    form.find(`input[name="${stat}"]`).val(stats_arr[stat]);
            }
        });
        // изменение блюда
        $(document).on('click', '.updateProduct', function(e) {
            if (!checkProductForm())
                return false;
            
            e.preventDefault();
            let form = $(this).parents('form:first');
            let form_data = new FormData();

            form_data.append('id', cur_product['id']);
            form_data.append('name', form.find('input[name="name"]').val());
            form_data.append('price', form.find('input[name="price"]').val());
            form_data.append('description', form.find('textarea[name="description"]').val());
            form_data.append('ingridients', form.find('textarea[name="ingridients"]').val());
            form_data.append('prepare_time', form.find('input[name="prepare_time"]').val());
            form_data.append('sectionId', form.find('input[name="sectionId"]').val());
            form_data.append('_token', form.find('input[name="_token"]').val());

            let img_data = form.find('input[name="img"]').prop('files');
            if (img_data[0])
                form_data.append('img', img_data[0]);
            
            let stats = make_stats(form.serializeArray());
            form_data.append('stats', stats);
            $.ajax({
                url: '{{ url("/updateProduct") }}',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data, 
                success: function(data) {
                    $('#closeProductCard').click();
                    let product = JSON.parse(data);
                    product['img'] = "{{ URL::asset('storage/menus/' . $menu['id']) }}/" + product['sectionId'] + '/products/' + product['img'];
                    update_product(product);
                    let ch_product = products.filter(p => p.id == product['id'])[0];
                    products[products.indexOf(ch_product)] = product;
                    let sp = sections.filter(s => s.id == product['sectionId'])[0]['products'];
                    sp[sp.indexOf(ch_product)] = product;
                    sections[sections.indexOf(sections.filter(s => s.id == product['sectionId'])[0])]['products'] = sp;
                }
            });
        });
        // изменение html блюда
        function update_product(product_data) {
            let product = new_editmenu_product(product_data);
            $(`[data-product="${product_data['id']}"]`).replaceWith(product);
        }
        // превращение свойств в массив
        function break_stats(stats) {
            let stats_arr = stats.split('\n');
            let res = {};
            for (let stat of stats_arr) {
                if (stat[0] == 'Б') 
                    res['pr'] = stat.substring(2, stat.length - 1);
                else if (stat[0] == 'Ж') 
                        res['ft'] = stat.substring(2, stat.length - 1);
                    else if (stat[0] == 'У')
                            res['ch'] =  stat.substring(2, stat.length - 1);
                        else if (stat[stat.length - 1] == 'г')
                                res['wt'] = stat.substring(0, stat.length - 1);
                            else
                                res['cl'] = stat.substring(0, stat.length - 4);
            }
            return res;
        }

        // обновление формы
        $(document).on('click', '.updateMenuBtn', function() {
            $('#updateMenuCard').find('input[name="address"]').val(address);
        });
        // обновление меню
        $(document).on('click', '.updateMenu', function(e) {            
            e.preventDefault();
            let form = $(this).parents('form:first');
            let form_data = new FormData();
            if (!form.find('input[name="address"]').val()) {
                alert('Вы не ввели адрес!');
                return false;
            }

            form_data.append('id', form.find('input[name="id"]').val());
            form_data.append('address', form.find('input[name="address"]').val());
            form_data.append('_token', form.find('input[name="_token"]').val());

            let img_data = form.find('input[name="img"]').prop('files');
            if (img_data[0])
                form_data.append('img', img_data[0]);
            
            $.ajax({
                url: '{{ url("/updateMenu") }}',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data, 
                success: function(data) {
                    $('#closeMenuCard').click();
                    let menu = JSON.parse(data);
                    $('.intro').css('background', 'url("{{ URL::asset("storage/menus/" . $menu["id"]) }}/' + menu['img'] + '") center no-repeat');
                    address = menu['address'];
                }
            });
        });


        // убрать блюдо из пользовательского меню
        $(document).on('click', '.productUnavailable', function() {
            let productId = $(this).parents('.product:first').attr('data-product');
            let form_data = new FormData();
            form_data.append('id', productId);
            form_data.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: '{{ url("/changeProductAvailability") }}',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data, 
                success: function(data) {
                    let changedProduct = $(`[data-product="${productId}"]`);
                    changedProduct.find('.productUnavailable').css('display', 'none');
                    changedProduct.find('.productAvailable').css('display', 'block');
                    changedProduct.find('a').css('opacity', '0.5');
                }
            });
        });
        // вернуть в меню
        $(document).on('click', '.productAvailable', function() {
            let productId = $(this).parents('.product:first').attr('data-product');
            let form_data = new FormData();
            form_data.append('id', productId);
            form_data.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: '{{ url("/changeProductAvailability") }}',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data, 
                success: function(data) {
                    let changedProduct = $(`[data-product="${productId}"]`);
                    changedProduct.find('.productAvailable').css('display', 'none');
                    changedProduct.find('.productUnavailable').css('display', 'block');
                    changedProduct.find('a').css('opacity', '1');
                }
            });
        });

        // обновление карточки удаления блюда
        $(document).on('click', '.deleteProductBtn', function() {
            let productId = $(this).parents('.product:first').attr('data-product');
            cur_product = products.filter(p => p.id == productId)[0];
            $('#deleteProductName').html(cur_product['name']);
        });
        // удаление блюда
        $(document).on('click', '#deleteProduct', function() {
            let form_data = new FormData();
            form_data.append('productId', cur_product['id']);
            form_data.append('_token', $('meta[name="csrf-token"]').attr('content'));
            $.ajax({
                url: '{{ url("/deleteProduct") }}',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function() {
                    let product = $(`[data-product="${cur_product['id']}"]`);
                    product.remove();
                    products = products.filter(p => p != cur_product);
                    sections.forEach(function(section, i) {
                        sections[i]['products'] = section['products'].filter(p => p != cur_product);
                    });
                }
            });
        });
        


        // добавление секции
        $(document).on('click', '.submitSection', function(e) {
            if (!checkSectionForm())
                return false;

            e.preventDefault();
            let form = $(this).parents('form:first');
            let img_data = form.find('input[name="img"]').prop('files')[0];
            let form_data = new FormData();
            form_data.append('img', img_data);
            form_data.append('name', form.find('input[name="name"]').val());
            form_data.append('menuId', form.find('input[name="menuId"]').val());
            form_data.append('_token', form.find('input[name="_token"]').val());
            $.ajax({
                url: '{{ url("/addSection") }}',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data, 
                success: function(data) {
                    form.trigger("reset");
                    $('#closeSectionCard').click();
                    let section = JSON.parse(data);
                    section['img'] = "{{ URL::asset('storage/menus/' . $menu['id']) }}/" + section['id'] + '/' + section['img'];
                    section['products'] = [];
                    section['available'] = true;
                    add_section(section);
                    sections.push(section);
                }
            });
        });
        // проверка содержимого секции
        function checkSectionForm() {
            let ok = true;
            $('#addSectionCard').find('input').each(function(key, el) {
                if (!el.value) {
                    if (el.name == 'name')
                        alert('Вы не ввели название раздела!');
                    else
                        alert('Вы не указали фоновое изображение!');
                    ok = false;
                }
            });
            return ok;
        }

        // убрать секцию из пользовательского меню
        $(document).on('click', '.sectionUnavailable', function() {
            let sectionId = $(this).parents('.section:first').attr('data-section');
            let form_data = new FormData();
            form_data.append('id', sectionId);
            form_data.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: '{{ url("/changeSectionAvailability") }}',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data, 
                success: function(data) {
                    let changedSection = $(`[data-section="${sectionId}"]`);
                    changedSection.find('.sectionUnavailable').css('display', 'none');
                    changedSection.find('.sectionAvailable').css('display', 'block');
                    changedSection.find('.collapse').removeClass(['collapse' + sectionId, 'show']);
                    changedSection.find('.card-header').css('opacity', '0.5');
                }
            });
        });
        // вернуть в меню
        $(document).on('click', '.sectionAvailable', function() {
            let sectionId = $(this).parents('.section:first').attr('data-section');
            let form_data = new FormData();
            form_data.append('id', sectionId);
            form_data.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: '{{ url("/changeSectionAvailability") }}',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data, 
                success: function(data) {
                    let changedSection = $(`[data-section="${sectionId}"]`);
                    changedSection.find('.sectionAvailable').css('display', 'none');
                    changedSection.find('.sectionUnavailable').css('display', 'block');
                    changedSection.find('.collapse').addClass('collapse' + sectionId);
                    changedSection.find('.card-header').css('opacity', '1');
                }
            });
        });

        // обновление карточки удаления секции
        $(document).on('click', '.deleteSectionBtn', function() {
            let sectionId = $(this).parents('.section:first').attr('data-section');
            cur_section = sections.filter(s => s.id == sectionId)[0];
            $('#deleteSectionName').html(cur_section['name']);
        });
        // удаление секции
        $(document).on('click', '#deleteSection', function() {
            let form_data = new FormData();
            form_data.append('sectionId', cur_section['id']);
            form_data.append('_token', $('meta[name="csrf-token"]').attr('content'));
            $.ajax({
                url: '{{ url("/deleteSection") }}',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function() {
                    let section = $(`[data-section="${cur_section['id']}"]`);
                    section.remove();
                    sections = sections.filter(s => s != cur_section);
                    products = products.filter(p => !cur_section['products'].includes(p));
                }
            });
        });
    </script>
</body>
</html>