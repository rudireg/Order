<?php
/**
 * Created by PhpStorm.
 * User: rudi
 * Date: 04.01.2017
 * Time: 22:51
 */
use core\Repository;

require_once "repository.php";

/**
 * Получение и проверка данных
 */
$count = $_POST['orderCount'];
if ($count < 1) {
    $errMsg = 'Не полученно кол. товаров.';
    //Раскомментировать если нужно отправлять на почту сообщение об ошибке
    //toMail($errMsg);
    toLog($errMsg);
    $response = array("text" => $errMsg, "error" => 1);
    echo json_encode($response);
    return;
}

/**
 * Инициализация БД
 */
if (!Repository::getInstance()) {
    $errMsg = "Нет подключения к БД.";
    //Раскомментировать если нужно отправлять на почту сообщение об ошибке
    //toMail($errMsg);
    toLog($errMsg);
    $response = array("text" => $errMsg, "error" => 2);
    echo json_encode($response);
    return;
}

/**
 * Добавляем новый заказ в БД
 */
if (!Repository::addOrder($count)) {
    $errMsg = "Ошибка добавления в БД.";
    //Раскомментировать если нужно отправлять на почту сообщение об ошибке
    //toMail($errMsg);
    toLog($errMsg);
    $response = array("text" => $errMsg, "error" => 3);
    echo json_encode($response);
    return;
}

/**
 * Получаем все заказы
 */
$orders = Repository::getOrders();
$response = array("text" => "Товар добавлен в корзину.", "error" => 0, 'orders' => $orders);
echo json_encode($response);
return;

/**
 * Занести в лог данные
 * @param $msg {string}
 */
function toLog($msg)
{
    $date = new DateTime();
    $str = "----------------- " . $date->format('Y-m-d H:i:s') . " -----------------\n" . $msg . "\n\n";
    file_put_contents('..\log\log.txt', $str, FILE_APPEND);
}

/**
 * @param $msg {string} сообщение для отправки на почту администратору
 */
function toMail($msg)
{
    /* получатели */
    $to = "rudireg@ya.ru";

    /* тема */
    $subject = "Ошибка на сервере";

    /* сообщение */
    $message = '
                <html>
                    <head>
                        <title>Ошибка на сервере</title>
                    </head>
                    <body>
                         <p>'.$msg.'</p>
                    </body>
                </html>';

    /* Шапка Content-type */
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";

    /* дополнительные шапки */
    $headers .= "From: Robot <info@example.com>\r\n";

    mail($to, $subject, $message, $headers);
}