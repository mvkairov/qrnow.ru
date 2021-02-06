// меню в списке
const listMenu = `
<li style="border: none;" class="list-group-item list-group-item menu" data-menu="{{ id }}">
    <h5>{{ name }}</h5>
    <a href="{{ url }}/orders"><button style="margin: 5px auto" class="col-12 btn btn-carrot">Заказы</button></a>
    <a href="{{ url }}/edit"><button style="margin: 5px auto" class="col-12 btn btn-carrot">Редактировать</button></a>
    <a href="{{ url }}/places"><button style="margin: 5px auto" class="col-12 btn btn-carrot">QR-коды</button></a>
    <button style="margin: 5px auto" data-toggle="modal" data-target="#deleteMenuCard" class="col-12 btn btn-dark deleteMenuBtn">Удалить меню</button>
</li>
`;
function new_list_menu(data) {
    let menu = Handlebars.compile(listMenu);
    return menu(data);
}

// qr-код в списке
const listPlace = `
<li style="border:none;" class="list-group-item list-group-item place" data-place="{{ id }}">
    <h5>{{ name }}</h5>
    <button style="margin: 5px auto" class=" col-12 btn btn-carrot" onclick="download_img(this);" data-place="{{ id }}" data-name="{{ name }}">Скачать QR</button>
    <button style="margin: 5px auto" class="col-12 btn btn-dark deletePlaceBtn" data-toggle="modal" data-target="#deletePlaceCard">Удалить место</button>
</li>
`;
function new_list_place(data) {
    let place = Handlebars.compile(listPlace);
    return place(data);
}

// заказ
const listOrder = `
<li class="list-group-item list-group-item order" data-order="{{ id }}">
    <h5>{{ guestName }}</h5>
    <h5>{{# if takeAway }}С собой, {{/ if }}
        {{ place }}, {{ guestNumber }} чел., {{ time }}</h5>
    <h5>Оплата {{# if payByCard}}картой{{ else }}наличными{{/ if }}</h5>
    {{# if comment }}
        <p>комментарий: {{ comment }}</p>
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
function new_list_order(data) {
    let order = Handlebars.compile(listOrder);
    return order(data);
}

// вызов
const listCall = `
<li class="list-group-item list-group-item call" data-call="{{ id }}">
    <h5>{{ place }}, {{ time }}</h5>
    <p>Вызов {{# if garcon }} официанта {{ else }} кальянщика {{/ if }}</p>
    <button class="btn btn-success deleteCallBtn" data-toggle="modal" data-target="#deleteCallCard">Готово</button>
</li>
`;
function new_list_call(data) {
    let call = Handlebars.compile(listCall);
    return call(data);
}
