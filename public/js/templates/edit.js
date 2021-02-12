// карточка блюда
const editMenuProductCard = `
<div class="card border-light product" style="background-color: #fff;" data-product="{{ id }}">
    <div>
        <img data-toggle="modal" data-target="#productModalCard" style="border-radius: 20px; max-height: 50vh; object-fit: cover; opacity: {{# if available }} 1 {{ else }} 0.5 {{/ if }};" src="{{ img }}" alt="" class="card-img-top">
        <div class="menu-actions">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-eye productAvailable" viewBox="0 0 16 16"
                 style="display: {{# if available }} none {{ else }} inline {{/ if }};">
                <title>Убрать из меню</title>
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-eye-slash productUnavailable" viewBox="0 0 16 16"
                 style="display: {{# if available }} inline {{ else }} none {{/ if }};">
                <title>Вернуть в меню</title>
                <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299l.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884l-12-12 .708-.708 12 12-.708.708z"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-pencil-square updateProductBtn" viewBox="0 0 16 16"
                 data-toggle="modal" data-target="#addProductCard">
                <title>Изменить блюдо</title>
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-trash deleteProductBtn" viewBox="0 0 16 16"
                 data-toggle="modal" data-target="#deleteProductCard">
                <title>Удалить блюдо</title>
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
            </svg>
        </div>
    </div>
    <div class="card-body">
        <div style="max-width: 100%; overflow: hidden;">
            <h4 class="food-name card-title" style="float: left; width: 50%;">{{ name }}</h4>
            <h4 class="food-price card-title" style="float: left; width: 50%; text-align: right;">{{ price }}p</h4>
        </div>
        <hr>
        <p class="card-text-small">{{ description }}</p>
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
    <div class="card-header" 
         style="border-radius: 20px; 
                background: url('{{ img }}') center no-repeat; 
                background-attachment: fixed; background-size: cover; 
                height: 150px; 
                opacity: {{# if available }} 1 {{ else }} 0.5 {{/ if }};">
        <div class="menu-actions">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-plus-circle addProductBtn" viewBox="0 0 16 16"
                 data-toggle="modal" data-target="#addProductCard">
                <title>Добавить блюдо</title>
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-eye sectionAvailable" viewBox="0 0 16 16"
                 style="display: {{# if available }} none {{ else }} inline {{/ if }};">
                <title>Вернуть в меню</title>
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-eye-slash sectionUnavailable" viewBox="0 0 16 16"
                 style="display: {{# if available }} inline {{ else }} none {{/ if }};">
                <title>Убрать из меню</title>
                <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299l.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884l-12-12 .708-.708 12 12-.708.708z"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-pencil-square updateSectionBtn" viewBox="0 0 16 16"
                 data-toggle="modal" data-target="#addSectionCard">
                <title>Изменить раздел</title>
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-trash deleteSectionBtn" viewBox="0 0 16 16"
                 data-toggle="modal" data-target="#deleteSectionCard">
                <title>Удалить раздел</title>
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
            </svg>
        </div>
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