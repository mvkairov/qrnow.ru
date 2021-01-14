const listMenu = `
<li style="border:none;" class="list-group-item list-group-item">
    <h5>{{ name }}</h5>
    <a href="{{ url }}/orders"><button style="margin: 5px auto" class="col-12 btn btn-carrot">Заказы</button></a>
    <a href="{{ url }}/edit"><button style="margin: 5px auto" class="col-12 btn btn-carrot">Редактировать</button></a>
    <a href="{{ url }}/places"><button style="margin: 5px auto" class="col-12 btn btn-carrot">QR-коды</button></a>
    <!-- <button style="margin: 5px auto" data-toggle="modal" data-target="#exampleModal"  class="col-12 btn btn-dark">Удалить меню</button> -->
</li>
`;
const listPlace = `
<li style="border:none;" class="list-group-item list-group-item place" data-place="{{ id }}">
    <h5>{{ name }}</h5>
    <button style="margin: 5px auto" class=" col-12 btn btn-carrot" onclick="download_img(this);" data-place="{{ id }}" data-name="{{ name }}">Скачать QR</button>
    <button style="margin: 5px auto" class="col-12 btn btn-dark deletePlaceBtn" data-toggle="modal" data-target="#deletePlaceCard">Удалить место</button>
</li>
`;
const listOrder = `
<li class="list-group-item list-group-item order" data-order="{{ id }}">
    <h5>{{ guestName }}</h5>
    <h5>{{# if takeAway }}С собой, {{/ if }}
        {{ place }}, {{ guestNumber }} чел., {{ time }}</h5>
    <h5>Оплата {{# if payByCard}}картой{{ else }}наличными{{/ if }}</h5>
    {{# if comment }}
        <p>комментарий: {{ comment }}</p>
        <hr>
    {{/ if }}
    <hr>    
    {{# each products }}
        <p>{{ @key }} x{{ this }}</p>
    {{/ each }}
    <h6>Итог: {{ sum }}р.</h6>
    <hr>
    <button class="btn btn-success deleteOrderBtn" data-toggle="modal" data-target="#deleteOrderCard">Заказ выполнен</button>
</li>
`;
const listCall = `
<li class="list-group-item list-group-item call" data-call="{{ id }}">
    <h5>{{ place }}, {{ time }}</h5>
    <p>Вызов {{# if garcon }} официанта {{ else }} кальянщика {{/ if }}</p>
    <button class="btn btn-success deleteCallBtn" data-toggle="modal" data-target="#deleteCallCard">Готово</button>
</li>
`;
const userMenuProductModal = `
<div class="card" style="border-color: #fff">
    <img style="border-radius: 20px" src="{{ img }}" alt="" class="card-img-top">
    <div class="card-body">
        <div style="max-width: 100%; overflow: hidden;">
            <h4 class="food-name card-title" style="float: left; width: 50%;">{{ name }}</h4>
            <h4 class="food-price card-title" style="float: left; width: 50%; text-align: right;">{{ price }}p</h4>
        </div>
        <hr>
        <p style="margin: 0" class="card-text">{{ description }}</p>
        <hr>
        <div>
            <p class="card-text food-stats" style="white-space: pre-line;">{{ stats }}</p>
        </div>
        {{# if ingridients }}
            <p style="margin: 0" class="card-text">Ингридиенты: {{ ingridients }}</p>
        {{/ if }}
        {{# if prepare_time }}
            <hr>
            <p style="text-align: right; color: grey" class="card-text">{{ prepare_time }} 
                <svg style="vertical-align: bottom;" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-clock" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm8-7A8 8 0 1 1 0 8a8 8 0 0 1 16 0z"/>
                    <path fill-rule="evenodd" d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
            </p>
        {{/ if }}
    </div>
</div>
`;
const userMenuProductCard = `
<div style="padding-top: 50px;" class="card-body product" data-product="{{ id }}">
    <div class="container-fluid padding">
        <div class="row padding">
            <div class="col-12">
                <div class="card" style="border-color: #fff">
                    <a data-toggle="modal" data-target="#productModalCard">
                        <img style="border-radius: 20px" src="{{ img }}" alt="" class="card-img-top">
                    </a>
                    <div class="card-body">
                        <div style="max-width: 100%; overflow: hidden;">
                            <h4 class="food-name card-title" style="float: left; width: 50%;">{{ name }}</h4>
                            <h4 class="food-price card-title" style="float: left; width: 50%; text-align: right;">{{ price }}p</h4>
                        </div>
                        <hr>
                        <p class="card-text-small">{{ description }}</p>
                        <button style="box-shadow: none" class="col-12 btn btn-carrot" type="button" data-toggle="collapse" data-target=".counterCollapse{{ id }}" aria-expanded="false"> Добавить в корзину
                        </button>
                        <div style="padding: 0;" class="col-12 collapse counterCollapse{{ id }}">
                            <div style="padding: 0;margin-top: 10px;" class="btn-group col-12" role="group" aria-label="Basic example">
                                <button style="box-shadow: none; border-radius: 5px;" type="button" class="col-5 btn btn-carrot minus">-</button>
                                <button style="box-shadow: none; background-color: #fff; border-color: #fff; color: #000;" type="button" class="col-2 btn btn-carrot counter">{{ counter }}</button>
                                <button style="box-shadow: none; border-radius: 5px;" type="button" class="btn btn-carrot col-5 plus">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
`;
const userMenuSectionCard = `
<div style="border-radius: 20px; border-color: #fff; margin: 40px 10px;" class="card section" data-section="{{ id }}">
    <div style="border-radius: 20px; background: url({{ img }}) center no-repeat; height: 150px;" class="card-header heading{{ id }}">
        <h5 class="mb-0">
        <button style="border: medium none;
            text-shadow: 2px 2px 2px #333;
            color: #fff;
            font-size: 40px;
            box-shadow: none;
            width: 100%;
            height: 100%;
            background-image: none; 
            background: transparent;
            float: left;
            background-color: transparent;" class="btn" type="button" data-toggle="collapse" data-target=".collapse{{ id }}" aria-expanded="true">
            {{ name }}
        </button>
        </h5>
    </div>
    <div class="collapse collapse{{ id }} productWrap" data-parent="#productsList">

    </div>
</div>
`;
const cartProductsList = `
{{# each products }}
    {{# if counter }}
        <div class="product" style="max-width: 100%; overflow: hidden;" data-product="{{ id }}">
            <h5 class="food-name card-title" style="float: left; width: 70%;">{{ name }}</h5>
            <h5 class="food-price card-title" style="float: left; width: 30%; text-align: right;">{{ price }}p</h5>
            <div style="padding: 0; display: inline-block;" class="btn-group col-12" role="group" aria-label="Basic example">
                <button style="box-shadow:none;border-radius: 20px" type="button" class="col-2 btn btn-carrot minus">-</button>
                <button style="background-color: #fff; color: #000; border-color: #fff; box-shadow: none" type="button" class="col-2 btn btn-primary counter">{{ counter }}</button>
                <button style="border-radius: 20px;box-shadow:none;" type="button" class="btn btn-carrot col-2 plus">+</button>
            </div>
        </div>
    {{/ if }}
{{/ each }}
`;
const waitProductsList = `
<div class="product" style="max-width: 100%; overflow: hidden;" data-toggle="modal" data-target="#productModalCard" data-product="{{ id }}">
    <h5 class="food-name card-title" style="float: left; width: 70%;">{{ name }} x{{ count }}</h5>
    <h5 class="food-price card-title" style="float: left; width: 30%; text-align: right;">{{ price }}p</h5>
</div>
`;
const editMenuProductCard = `
<div style="padding-top: 10px;" class="card-body product" data-product="{{ id }}">
    <div class="container-fluid padding">
        <div class="row padding">
            <div class="col-12">
                <div class="card border-light" style="background-color: #fff;">
                    <a data-toggle="modal" data-target="#productModalCard" style="opacity: {{# if available }} 1 {{ else }} 0.5 {{/ if }};">
                        <img style="border-radius: 20px" src="{{ img }}" alt="" class="card-img-top">
                    </a>
                    <div class="card-body">
                        <div style="max-width: 100%; overflow: hidden;">
                            <h4 class="food-name card-title" style="float: left; width: 50%;">{{ name }}</h4>
                            <h4 class="food-price card-title" style="float: left; width: 50%; text-align: right;">{{ price }}p</h4>
                        </div>
                        <hr>
                        <p class="card-text-small">{{ description }}</p>
                        
                        <button class="btn btn-info col-12 m-1 productUnavailable"
                                style="display: {{# if available }} block {{ else }} none {{/ if }}; border-radius: 30px;">
                                Убрать из меню</button>
                        <button class="btn btn-success col-12 m-1 productAvailable"
                                style="display: {{# if available }} none {{ else }} block {{/ if }}; border-radius: 30px;">
                                Вернуть в меню</button>
                        <button class="btn btn-carrot col-12 m-1 updateProductBtn"
                                style="margin-top: 10px; border-radius: 30px;"
                                data-toggle="modal" data-target="#addProductCard">Изменить блюдо</button>
                        <button class="btn btn-danger col-12 m-1 deleteProductBtn"
                                style="margin-top: 10px; border-radius: 30px;"
                                data-toggle="modal" data-target="#deleteProductCard">Удалить блюдо</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
`;
const editMenuSectionCard = `
<div style="margin: 20px auto; border-radius: 20px; border-color: #fff;" class="card col-xl-5 col-md-7 col-sm-11 section" data-section="{{ id }}">
    <div style="border-radius: 20px; background: url('{{ img }}') center no-repeat; height: 150px; opacity: {{# if available }} 1 {{ else }} 0.5 {{/ if }};" class="card-header">
        <h5 class="mb-0">
            <button style="border: medium none;
                text-shadow: 2px 2px 2px #333;
                color: #fff;
                font-size: 40px;
                box-shadow: none;
                width: 100%;
                height: 100%;
                background-image: none; 
                background: transparent;
                float: left;
                background-color: transparent;" class="btn" type="button" data-toggle="collapse" data-target=".collapse{{ id }}">
                {{ name }}
            </button>
        </h5>
    </div>
    <button class="btn btn-info col-12 sectionUnavailable"
            style="display: {{# if available }} block {{ else }} none {{/ if }}; margin-top: 10px; border-radius: 30px;">
            Убрать из меню</button>
    <button class="btn btn-success col-12 sectionAvailable"
            style="display: {{# if available }} none {{ else }} block {{/ if }}; margin-top: 10px; border-radius: 30px;">
            Вернуть в меню</button>

    <button style="margin-top: 10px; border-radius: 30px;" class="btn btn-danger col-12 deleteSectionBtn" data-toggle="modal" data-target="#deleteSectionCard">Удалить раздел</button>
    <div class="collapse {{# if available }} collapse{{ id }} {{/ if }}" 
                data-parent="#productsList">
        <button style="margin-top: 10px;" class="btn btn-carrot col-12 addProductBtn" data-toggle="modal" data-target="#addProductCard">Добавить блюдо</button>
        <span class="productWrap">
            
        </span>
    </div>
</div>
`;

// admin panels
function new_list_order(data) {
    let order = Handlebars.compile(listOrder);
    return order(data);
}
function new_list_call(data) {
    let call = Handlebars.compile(listCall);
    return call(data);
}
function new_list_menu(data) {
    let menu = Handlebars.compile(listMenu);
    return menu(data);
}
function new_list_place(data) {
    let place = Handlebars.compile(listPlace);
    return place(data);
}

// usermenu
function update_usermenu_product_modal(data) {
    let modal = Handlebars.compile(userMenuProductModal);
    return modal(data);
}
function new_usermenu_product(data) {
    let product = Handlebars.compile(userMenuProductCard);
    return product(data);
}
function new_usermenu_section(data) {
    let section = Handlebars.compile(userMenuSectionCard);
    return section(data);
}
function update_usermenu_cart(data) {
    let cart_info = Handlebars.compile(cartProductsList);
    return cart_info(data);
}
// wait
function wait_cart_product(data) {
    let cart_info = Handlebars.compile(waitProductsList);
    return cart_info(data);
}

// editmenu
function new_editmenu_product(data) {
    let product = Handlebars.compile(editMenuProductCard);
    return product(data);
}
function new_editmenu_section(data) {
    let section = Handlebars.compile(editMenuSectionCard);
    return section(data);
}