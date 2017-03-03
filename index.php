<?php
define('DR', $_SERVER['DOCUMENT_ROOT']);
define('SN', $_SERVER['SERVER_NAME']);
define('RU', $_SERVER['REQUEST_URI']);

include DR."/db.php";
//$in = $_SERVER['REQUEST_URI'];

if((SN == 'cinema.ua' && RU == '/') || (isset($_GET['main']) && $_GET['main'] == '') || RU == '/www/index.php' || isset($_GET['exit'])){
    include DR."/controller/header.php";
	include DR."/controller/main.php";// главная стр
}elseif(isset($_GET['hall']) && $_GET['hall'] == '' && mb_substr(RU, 0, 10, 'utf-8') == '/index.php'){
	include DR."/controller/header.php";
	include DR."/controller/hall.php";// схема зала и форма заказа
}elseif(isset($_GET['order']) && $_GET['order'] == '' && mb_substr(RU, 0, 10, 'utf-8') == '/index.php'){
	include DR."/controller/header.php";
	include DR."/controller/order.php";// заказ клиента
}else{
	include DR."/controller/404.php";
}
include DR."/controller/footer.php";

?>