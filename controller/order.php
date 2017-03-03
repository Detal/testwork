<?php
session_start();
//список заказов клиента
$dbOrders = new Dbase('localhost', 'root', '', 'Orders', 'orders');//сеансы
$orderMap = new CreateHall("Список заказов", "Выберите сеанс");

include DR . "/view/order.php";
