// карточка блюда
const editMenuProductCard = `
<div class="card border-light product" style="background-color: #fff;" data-product="{{ id }}">
    <a data-toggle="modal" data-target="#productModalCard" style="opacity: {{# if available }} 1 {{ else }} 0.5 {{/ if }};">
        <img style="border-radius: 20px; max-height: 50vh; object-fit: cover;" src="{{ img }}" alt="" class="card-img-top">
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
`;
function new_editmenu_product(data) {
    let product = Handlebars.compile(editMenuProductCard);
    return product(data);
}

// карточка секции
const editMenuSectionCard = `
<div style="margin: 20px auto; border-radius: 20px; border-color: #fff; padding: 0;" 
     class="card col-xl-5 col-md-7 col-sm-11 section" 
     data-section="{{ id }}">
    <div style="border-radius: 20px; background: url('{{ img }}') center no-repeat; 
                background-attachment: fixed; background-size: cover; 
                height: 150px; opacity: {{# if available }} 1 {{ else }} 0.5 {{/ if }};" 
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
                background-color: transparent;" class="btn" type="button" data-toggle="collapse" data-target=".collapse{{ id }}">
                {{ name }}
            </button>
        </h5>
    </div>
    <div class="collapse {{# if available }} collapse{{ id }} {{/ if }}" data-parent="#productsList">
        <button class="btn btn-info col-12 sectionUnavailable"
                style="display: {{# if available }} block {{ else }} none {{/ if }}; 
                       margin-top: 10px; border-radius: 30px;">Убрать из меню</button>
        <button class="btn btn-success col-12 sectionAvailable"
                style="display: {{# if available }} none {{ else }} block {{/ if }}; 
                margin-top: 10px; border-radius: 30px;">Вернуть в меню</button>
        <button style="margin-top: 10px; border-radius: 30px;" class="btn btn-danger col-12 deleteSectionBtn" data-toggle="modal" data-target="#deleteSectionCard">Удалить раздел</button>   
        <button style="margin-top: 10px;" class="btn btn-carrot col-12 addProductBtn" data-toggle="modal" data-target="#addProductCard">Добавить блюдо</button>
        
        <div style="padding-top: 10px;" class="card-body">
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
function new_editmenu_section(data) {
    let section = Handlebars.compile(editMenuSectionCard);
    return section(data);
}

// модальная карточка блюда
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