<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Чат Rudi</title>
    <meta name="description" content="Чат" />
    <meta name="keywords" content="Чат" />

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="/css/media-queries.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="cartWidget">
        <form id="orderForm" method="post" action="/core/order.php">
            <span id="orderNotice" class="orderNotice"></span>
            <div class="orderActions">
                <span class="orderDecrement" id="orderDecrement">&ndash;</span>
                <input class="orderCount" type="text" id="orderCount" name="orderCount" value="0" />
                <span class="orderIncrement" id="orderIncrement">+</span>
                <button class="btn text-uppercase btn-buy">Купить</button>
            </div>
        </form>
    </div>
    <div class="clearfix"></div>

    <h2 class="text-center">Список заказов</h2>
    <hr />
    <div id="listOrders" class="listOrders"></div>
</div>

<script src="/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/js/cart.js" type="text/javascript"></script>
</body>
</html>