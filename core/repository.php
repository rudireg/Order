<?php
/**
 * Created by PhpStorm.
 * User: rudi
 * Date: 04.01.2017
 * Time: 22:24
 */
namespace core;

class Repository
{
    protected static $DBH;

    /**
     * Singlton - шаблон для работы с БД
     * @return \PDO возвращает экземпляр для работы с БД
     */
    public static function getInstance()
    {
        if (self::$DBH === null) {
            try{
                self::$DBH = new \PDO("mysql:host=127.0.0.1;dbname=cart;", "root", "huckoff");
            } catch (\PDOException $e) {
                \file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
            }
        }
        return self::$DBH;
    }

    /**
     * @param $count int Количество товаров в заказе
     * @return bool Результат выполнения операции добавления нового заказа
     */
    public static function addOrder($count)
    {
        if ($count < 1)
            return false;

        $STH = self::$DBH->prepare("INSERT INTO orders (id, date, ip, count) VALUES (?, ?, ?, ?)");
        $data = array(null, time(), $_SERVER["REMOTE_ADDR"], $count);
        return $STH->execute($data);
    }

    /**
     * Получить все заказы
     * @return array|null Возвращает массив заказов
     */
    public static function getOrders()
    {
        $STH = self::$DBH->query("SELECT * FROM `orders` ORDER BY `date` DESC");
        $STH->setFetchMode(\PDO::FETCH_ASSOC);
        if ($STH->rowCount() < 1)
            return null;

        $orders = array();
        while ($row = $STH->fetch()) {
            $orders[] = $row;
        }
        return $orders;
    }

    /**
     * Закрываем для Singlton
     */
    final private function __construct() {}
    final private function __clone() {}
    final private function __sleep() {}
    final private function __wakeup() {}
}