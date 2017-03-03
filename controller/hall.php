<?php
$hallMap = new CreateHall("Выберите дату", "Выберите сеанс");
$dbConvers = new Dbase('localhost', 'root', '', 'Orders', 'conversation');//сеансы
$dbStatus = new Dbase('localhost', 'root', '', 'Orders', 'status');// статус мест, занято не занято
$price = new Dbase('localhost', 'root', '', 'Orders', 'category');// ценовая категория


include $_SERVER['DOCUMENT_ROOT'] . "/view/hall.php";
?>