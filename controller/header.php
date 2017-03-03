<?php
session_start();
include_once DR . "/Dbase.php";
include_once DR . "/CreateHall.php";
// title главной стр
if($_SERVER['REQUEST_URI'] == '/' || (isset($_GET['main']) && $_GET['main'] == '') || $_SERVER['REQUEST_URI'] == '/index.php'){
$title = 'Бронирование билетов';
//title для основного каталога
}elseif(isset($_GET['hall']) && $_GET['hall'] == ''){
	$title = "Схема зала";
//title для категорий
}elseif(isset($_GET['order']) && $_GET['order'] == ''){//доработать&& isset($_GET['catalog'])
	$title = "Заказ";
}
include_once DR ."/view/header.php";
?>