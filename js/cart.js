/**
 * Увеличить кол. заказов
 */
$("#orderIncrement").click(function(){
    var count = $("#orderCount").val();
    count ++;
    $("#orderCount").val(count);
});

/**
 * Уменьшить кол. заказов
 */
$("#orderDecrement").click(function(){
    var count = $("#orderCount").val();
    count --;
    if(count < 0) count = 0;
    $("#orderCount").val(count);
});

/**
 * Отправка заказа в БД
 */
$("#orderForm").validate({
    submitHandler:function(form) {
        var orderCount = $("#orderCount").val();
        if (isNaN(orderCount)) {
            showMsg("Укажите число", 'orderErrorNotice');
            return false;
        }
        if (orderCount < 1) {
            showMsg("Укажите количество", 'orderErrorNotice');
            return false;
        }

        var param = {'orderCount':orderCount};
        $.ajax({
            url: '/core/order.php',
            dataType: 'json',
            cache: false,
            type: 'POST',
            data: param,
            success: function(data) {
                if(data.error == 0){
                    showMsg(data.text, 'orderNotice');
                    showOrders(data.orders);
                    return false;
                }
                showMsg(data.text, 'orderErrorNotice');
                return false;
            },
            error: function(data) {
                showMsg('Ошибка сервера', 'orderErrorNotice');
                return false;
            }
        });
        return false;
    }
});

/**
 * Отобразить сообщение на 3 секунды
 */
function showMsg(msg, type)
{
    $("#orderCount").focus();
    document.getElementById('orderNotice').innerHTML = msg;
    $("#orderNotice").attr('class', type);
    $("#orderNotice").css('display', 'block');
    $("#orderNotice").show();
    //Через 3 секунды скрываем сообщение
    setTimeout(function(){$("#orderNotice").hide();}, 3000);
}

/**
 * Отобразить список заказов
 * @param orders Массив заказов
 */
function showOrders(orders)
{
    var table = '<table class="table table-bordered">' +
        '<tr>' +
        '<th>Дата</th><th>IP</th><th>Количество</th>' +
        '</tr>';

    orders.forEach(function(item, i, orders) {
        table += '<tr>' +
                     '<td>' + showDate(item.date) + '</td>' +
                     '<td>' + item.ip + '</td><td>' +item.count + '</td>' +
                 '</tr>';
    });
    table += '</table>';

    document.getElementById('listOrders').innerHTML = table;
}

/**
 * Конвертирует UNIX время в дни, месяцы, год, и время
 * @param unixTime
 * @returns {string}
 */
function showDate(unixTime) {
    time = new Date(unixTime * 1000);
    var options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        weekday: 'long',
        timezone: 'UTC',
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric'
    };

    return time.toLocaleString("ru", options);
}