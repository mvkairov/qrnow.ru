// usermenu

// карточка блюда
const userMenuProductCard = `
<div class="card product pb-2" style="border-color: #fff;" data-product="{{ id }}">
    <a data-toggle="modal" data-target="#productModalCard">
        <img style="border-radius: 20px; max-height: 50vh; object-fit: cover;" src="{{ img }}" alt="" class="card-img-top">
    </a>
    <div class="card-body">
        <div style="max-width: 100%; overflow: hidden;">
            <h4 class="food-name card-title" style="float: left; width: 50%;">{{ name }}</h4>
            <h4 class="food-price card-title" style="float: left; width: 50%; text-align: right;">{{ price }}p</h4>
        </div>
        <hr>
        <p class="card-text-small">{{ description }}</p>

        <button style="box-shadow: none" class="col-12 btn btn-carrot show addToCartBtn counterCollapse{{ id }}" type="button" data-toggle="collapse" data-target=".counterCollapse{{ id }}" aria-expanded="false">Добавить в корзину</button>
        <button class="deleteFromCart" data-toggle="collapse" data-target=".counterCollapse{{ id }}" hidden></button>
        
        <div style="padding: 0;" class="col-12 collapse counterCollapse{{ id }}">
            <div style="padding: 0;margin-top: 10px;" class="btn-group col-12" role="group" aria-label="Basic example">
                <button style="box-shadow: none; border-radius: 5px;" type="button" class="col-5 btn btn-carrot minus">-</button>
                <button style="box-shadow: none; background-color: #fff; border-color: #fff; color: #000;" type="button" class="col-2 btn btn-carrot counter">{{ counter }}</button>
                <button style="box-shadow: none; border-radius: 5px;" type="button" class="btn btn-carrot col-5 plus">+</button>
            </div>
        </div>
    </div>
</div>
`;
function new_usermenu_product(data) {
    let product = Handlebars.compile(userMenuProductCard);
    return product(data);
}

// карточка секции
const userMenuSectionCard = `
<div style="border-radius: 20px; border-color: #fff; padding: 0; margin: 20px 10px;" class="card section" data-section="{{ id }}">
    <div style="border-radius: 20px; background: url('{{ img }}') center no-repeat; 
                height: 150px; background-attachment: fixed; background-size: cover;" 
         class="card-header">
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
                background-color: transparent;" class="btn" type="button" data-toggle="collapse" data-target=".collapse{{ id }}" aria-expanded="true" aria-controls="collapseOne">
                {{ name }}
            </button>
        </h5>
    </div>

    <div class="collapse collapse{{ id }}" data-parent="#productsList">
        <div style="padding-top: 20px; padding-bottom: -10px;" class="card-body">
            <div class="container-fluid padding">
                <div class="row padding">
                    <div class="col-12 productWrap">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
`;
function new_usermenu_section(data) {
    let section = Handlebars.compile(userMenuSectionCard);
    return section(data);
}

// список блюд в корзине
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
function update_usermenu_cart(data) {
    let cart_info = Handlebars.compile(cartProductsList);
    return cart_info(data);
}

// wait

// список блюд в корзине
const waitProductsList = `
<div class="product" style="max-width: 100%; overflow: hidden;" data-toggle="modal" data-target="#productModalCard" data-product="{{ id }}">
    <h6 class="food-name card-title" style="float: left; width: 70%;">{{ name }} {{ price }}р x {{ count }} = </h6>
    <h5 class="food-price card-title" style="float: left; width: 30%; text-align: right;">{{ sum }}p</h5>
</div>
`;
function wait_cart_product(data) {
    let cart_info = Handlebars.compile(waitProductsList);
    return cart_info(data);
}

// карточка блюда
const productModalCard = `
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
function update_usermenu_product_modal(data) {
    let modal = Handlebars.compile(productModalCard);
    return modal(data);
}