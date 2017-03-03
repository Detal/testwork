<?php
session_start();
include_once "../ValidateHall.php";
include_once "../Dbase.php";

if(isset($_POST['exit'])){
    unset($_SESSION['session']);
    unset($_SESSION['convers']);
    unset($_SESSION['day']);
    unset($_SESSION['time']);
    unset($_SESSION['error_mail']);
    unset($_SESSION['mail']);
    unset($_SESSION['$places1']);
    unset($_SESSION['$places2']);
    unset($_SESSION['$places3']);
    unset($_SESSION['errorPlaces']);
    unset($_SESSION['c_max']);
    unset($_SESSION['allMax']) ;
    unset($_SESSION['allPlaces']) ;
    unset($_SESSION['errorMessage']) ;
    unset($_SESSION['finalMessage']);
    unset($_SESSION['errorAllWrite']);
    unset($_SESSION['allWrite']);
    unset($_SESSION['convers_id']);
    unset($_SESSION['resConvers']);
    unset($_SESSION['sum']);
    unset($_SESSION['id']);
    header ("Location: /index.php?main");
    exit;}

if(isset($_POST['back'])){
    unset($_SESSION['session']);
    unset($_SESSION['convers']);
    unset($_SESSION['day']);
    unset($_SESSION['time']);
    unset($_SESSION['error_mail']);
    unset($_SESSION['mail']);
    unset($_SESSION['$places1']);
    unset($_SESSION['$places2']);
    unset($_SESSION['$places3']);
    unset($_SESSION['errorPlaces']);
    unset($_SESSION['c_max']);
    unset($_SESSION['allMax']) ;
    unset($_SESSION['allPlaces']) ;
    unset($_SESSION['errorMessage']) ;
    unset($_SESSION['finalMessage']);
    unset($_SESSION['errorAllWrite']);
    unset($_SESSION['allWrite']);
    unset($_SESSION['convers_id']);
    //unset($_SESSION['resConvers']);
    unset($_SESSION['sum']);
    //unset($_SESSION['id']);
    header ("Location: /index.php?hall");
    exit;
}
$dbStatus = new Dbase('localhost', 'root', '', 'Orders', 'status');// статус мест, занято не занято
$dbMail = new Dbase('localhost', 'root', '', 'Orders', 'users');
$dbConversation = new Dbase('localhost', 'root', '', 'Orders', 'conversation');
$dbHallOrder = new Dbase('localhost', 'root', '', 'Orders', 'hall');
$priceControl = new Dbase('localhost', 'root', '', 'Orders', 'category');// ценовая категория
$orderWrite = new Dbase('localhost', 'root', '', 'Orders', 'orders');




$mail = trim($_POST['mail']);
$res = '';
if(isset($_POST['place'])){
    $allPlaces = $_POST['place'];
    $finalPlaces = $allPlaces;// для вывода сообщения о совершенном заказе
    $_SESSION['finalPlaces'] = $finalPlaces;// массив с id мест для записи в STATUS
}
//День - сеанс

if(isset($_POST['day'])){
    if($_POST['day'] == date('Y-m-d')) {//если сегодняшний день,
        $_SESSION['convers'] = 'on';
        $time = date("H:i:s");
        $_SESSION['time'] = $time;
        $_SESSION['day'] = $_POST['day'];
    }elseif(!isset($_POST['redo'])){
        $_SESSION['convers'] = 'on';
        $_SESSION['day'] = $_POST['day'];
    }
}

if(isset($_POST['session']) && !isset($_POST['redo'])){
    unset($_SESSION['convers']);
    $_SESSION['session'] = mb_substr($_POST['session'], 0, 8, 'utf-8');
    //получаем convers_id из conversation
    $poleId = array(0 => 'convers_id');
    $poleSeek = array('time_start' => $_SESSION['session']);
    $conversId = $dbConversation->selectWhere($poleId, $poleSeek);
    $_SESSION['convers_id'] = $conversId[0][0];

    $halls = array(0 => 'hall_id');
    $data = $conversId[0][0];
    $raw = array('conv_id' => $data, 'date_converse' => $_SESSION['day']);
    $convers = $dbStatus->selectWhere($halls, $raw);//недоступные чекбоксы
    
    $resConvers = array();
    for($i = 0; $i < count($convers); $i++){
        $resConvers[$i] = $convers[$i][0];
    }
    $_SESSION['resConvers'] = $resConvers;
}

//РЕГИСТРАЦИЯ функция валидации мыла
function mail_valid($m){
    if($m[0] == '@' || $m[mb_strlen($m)-1] == '@'){//не первая и не последня собачка
        return false;
    }
    // Фильтрация для рядом стоящих собак
    $res_m = '';

    for($i = 0; $i < mb_strlen($m); $i++){
        if ($m[$i] != '@'){
            $res_m .= $m[$i];
        }elseif($m[$i] != $m[$i - 1]){
            $res_m .= $m[$i];
        }
    }

    //проверяем на наличие собачки вообще
    $mail_str = str_replace('@',' ', $res_m);
    $mail_arr = explode('@', $res_m);

    if($mail_str == $res_m){
        return false;
    }elseif(count($mail_arr) != 2){//проверка на наличие нескольких собачек не стоящих рядом
        return false;
    }else{
        return $res_m;
    }
}//конец функции

//РЕГИСТРАЦИЯ проверка мыла
if(!empty($mail) && is_string($mail) && mail_valid($mail)){
    $_SESSION['mail'] = mail_valid($mail);
    unset($_SESSION['error_mail']);
}elseif(!isset($_POST['redo']) && !isset($_POST['day']) && !isset($_POST['session'])){
    $_SESSION['error_mail'] = 'Ведите существующий e-mail!';
    unset($_SESSION['mail']);
}

//Валидация заказа
if(!empty($_SESSION['mail'])) {
    //проверка на уникальности мыла
    include "../db.php";
    $arg = $_SESSION['mail'];
    $pole = array(0 => 'user_name');
    $mail = array('user_name' => $arg);
    $resultMail = $dbMail->selectWhere($pole, $mail);
    $userMail = $resultMail[0][0];
    // объект - валидатор и лимиты
    $validHall = new ValidateHall();
    $validHall->setLimits(5, 15);
    ////////// //если клиент есть в базе.............
    if (!empty($userMail) && !empty($allPlaces)) { // проверяем в заказах на выбраную дату и устанавливаю лимиты
        //достаю id usera
        $dateConvers = $_SESSION['day'];
        $orderIdArr = array(0 => 'user_id');
        $seekOrder = array('user_name' => $arg);
        $resultSelectUserId = $dbMail->selectWhere($orderIdArr, $seekOrder);
        $userId = $resultSelectUserId[0][0];
        // есть ли заказы на этот день и сеанс
        //достаю id сеанса
        $conversIdArr = array(0 => 'convers_id');
        $seekTime = array('time_start' => $_SESSION['session']);
        $resultConversId = $dbConversation->selectWhere($conversIdArr, $seekTime);
        $conversId = $resultConversId[0][0];
        //достаю забронированные места этим пользователем на этот день и сеанс
        $hallId = array(0 => 'hall_id');
        $seekUserPlaces = array('conv_id' => $conversId, 'date_converse' => $dateConvers, 'user_id' => $userId);
        $inspectionPlaces = $dbStatus->selectWhere($hallId, $seekUserPlaces);
        if (count($inspectionPlaces) > 1) {
            for ($i = 0; $i < count($inspectionPlaces); $i++) {
                $userPlaces[$i] = $inspectionPlaces[$i][0];
            }
        } else {
            $userPlaces = $inspectionPlaces[0][0];// ранее забронированные места этим пользователем на этот день и сеанс
        }
        //устанавливаю лимиты для заказов
        // объединяю текущий заказ с уже существующим, если он был
        if (!empty($userPlaces)) {
            //$finalPlaces = $allPlaces;// для вывода сообщения о совершенном заказе
            $allPlaces = array_merge($userPlaces, $allPlaces);
        }
        // установка allmax с учетом всех заказов клиента на этот сеанс
        $allMax = $validHall->setAllPlaces($allPlaces);
        //если не превышени общий лимит на сеанс
        if ($allMax != false) {
            //устанавливаю cMax1 - n, с учетом  того, что уже были заказы на этот сеанс
            $category = array(0 => 'category_id');
            // вытягиваю id категорий, соответствующие заказанным местам
            for ($i = 0; $i < count($allPlaces); $i++) {
                $seekCategory = array('hall_id' => $allPlaces[$i]);
                $res = $dbHallOrder->selectWhere($category, $seekCategory);
                $catPlaces[$i] = $res[0][0];//////массив с id категорий, соответствующих заказанным местам
            }
            // подсчет одинаковых id
            $nPlaces = $validHall->validateLimitCategory($catPlaces);//
            if ($nPlaces != false && is_array($nPlaces)) {
                $_SESSION['c_max'] = $nPlaces;
                $_SESSION['allMax'] = $allMax;
                unset($_SESSION['errorMessage']);
                // итоговое сообщение по совершенному заказу
                $informPrice = array(0 => 'category_price');
                $queryPrice = $priceControl->select($informPrice);
                for ($i = 0; $i < count($finalPlaces); $i++) {
                    $seekCategoryF = array('hall_id' => $finalPlaces[$i]);
                    $resF = $dbHallOrder->selectWhere($category, $seekCategoryF);
                    $catPlacesF[$i] = $resF[0][0];//////массив с id категорий, соответствующих заказанным местам
                }
                $nPlacesF = $validHall->validateLimitCategory($catPlacesF);//
                $validHall->setPrices($queryPrice);
                $sum = $validHall->counterSum($nPlacesF);
                $finalMessage = $validHall->getFinalMessage($finalPlaces, $sum);
                $_SESSION['sum'] = $sum;
                $_SESSION['finalMessage'] = $finalMessage;
                unset ($_SESSION['errorMessage']);
            } elseif (is_string($nPlaces)) {
                $_SESSION['errorMessage'] = $nPlaces;
                unset ($_SESSION['finalMessage']);
                unset($_SESSION['c_max']);
                unset($_SESSION['allMax']);
            } elseif ($nPlaces == false) {
                $_SESSION['c_max'] = $validHall->getAllLimit();
                $_SESSION['allMax'] = $validHall->getLimitCategory();
                unset($_SESSION['errorMessage']);
                unset($_SESSION['finalMessage']);
            }
        } else {
            $_SESSION['finalMessage'] = 'Вы превысили Лимит!';
        }
//если клиента нет в базе
    } elseif (empty($userMail) && (!empty($allPlaces))) { // выбрать цену из категорий и умножить на длинну массива
        $allMax = $validHall->setAllPlaces($finalPlaces);
        //если не превышени общий лимит на сеанс
        if ($allMax != false) {
            //устанавливаю cMax1 - n, с учетом  того, что уже были заказы на этот сеанс
            $category = array(0 => 'category_id');
            // вытягиваю id категорий, соответствующие заказанным местам
            for ($i = 0; $i < count($allPlaces); $i++) {
                $seekCategory = array('hall_id' => $allPlaces[$i]);
                $res = $dbHallOrder->selectWhere($category, $seekCategory);
                $catPlaces[$i] = $res[0][0];//////массив с id категорий, соответствующих заказанным местам
            }
            // подсчет одинаковых id
            $nPlaces = $validHall->validateLimitCategory($catPlaces);//
            if ($nPlaces != false && is_array($nPlaces)) {
                $_SESSION['c_max'] = $nPlaces;
                $_SESSION['allMax'] = $allMax;
                unset($_SESSION['errorMessage']);
                // итоговое сообщение по совершенному заказу
                $informPrice = array(0 => 'category_price');
                $queryPrice = $priceControl->select($informPrice);
                for ($i = 0; $i < count($finalPlaces); $i++) {
                    $seekCategoryF = array('hall_id' => $finalPlaces[$i]);
                    $resF = $dbHallOrder->selectWhere($category, $seekCategoryF);
                    $catPlacesF[$i] = $resF[0][0];//////массив с id категорий, соответствующих заказанным местам
                }
                $nPlacesF = $validHall->validateLimitCategory($catPlacesF);//массив(ключи - категория)(значения - количество мест)
                $validHall->setPrices($queryPrice);
                $sum = $validHall->counterSum($nPlacesF);
                $finalMessage = $validHall->getFinalMessage($finalPlaces, $sum);
                $_SESSION['sum'] = $sum;
                $_SESSION['finalMessage'] = $finalMessage;
                unset ($_SESSION['errorMessage']);
                // запись мыла клиента в бд
                $collsOfUser = array(0 => 'user_name');
                $dataMail = array(0 => $_SESSION['mail']);
                $dbMail->insert($collsOfUser, $dataMail);
            } elseif (is_string($nPlaces)) {
                $_SESSION['errorMessage'] = $nPlaces;
                unset ($_SESSION['finalMessage']);
                unset($_SESSION['c_max']);
                unset($_SESSION['allMax']);
            } elseif ($nPlaces == false) {
                $_SESSION['c_max'] = $validHall->getAllLimit();
                $_SESSION['allMax'] = $validHall->getLimitCategory();
                unset($_SESSION['errorMessage']);
                unset($_SESSION['finalMessage']);
            }
        } else {
            $_SESSION['finalMessage'] = 'Вы превысили Лимит!';
        }
    }
}
//Запись заказа в БД
if(isset($_POST['redo'])){
    // формирование заказа-билета
    for($i = 0; $i < count($_SESSION['finalPlaces']); $i++){
        $orderRow = array(0 => 'row_id');
        $seekRow = array('hall_id' => $_SESSION['finalPlaces'][$i]);
        $resR = $dbHallOrder->selectWhere($orderRow, $seekRow);
        $rowsR[$i] = 'Ряд: '.$resR[0][0]. '. Место: '.$_SESSION['finalPlaces'][$i] ;//////массив с номерами рядов
    }
    $order = '';// ЗАКАЗ
    $order .= 'Дата заказа: '. date("Y-m-d").'.<br />';
    $order .='Клиент: '. $_SESSION['mail'] . '.<br />';
    $order .='Дата сеанса: ' .$_SESSION['day']. '.<br />';
    $order .= 'Время сеанса: '. $_SESSION['session']. '.<br />';
    $order.='Места: ';
    for($i = 0; $i < count($rowsR); $i++) {
        if($i != (count($rowsR) - 1)) {
            $order.=$rowsR[$i] . ', ';
        }else{
            $order.=$rowsR[$i] . '.<br />';
        }
    }
    $order .= 'Цена: '. $_SESSION['sum'].' грн.<br />';
    //запись заказа в бд, отметка в таблице статус
       // запись заказа
        //достаю id клиента
    $seekId = array(0 => 'user_id');
    $seekMail = array('user_name' => $_SESSION['mail']);
    $id = $dbMail->selectWhere($seekId, $seekMail);
    $_SESSION['id'] = $id[0][0];
        //запись заказа
    $idConverse = $_SESSION['convers_id'];
    $collsOrder = array(0 => 'user_id', 1 => 'orders', 2 => 'date_convers', 3 => 'convers_id', 4 => 'date_order', 5 => 'halls');
    $str = '';
    for($i = 0; $i < count($_SESSION['finalPlaces']); $i++) {
        $str .= $_SESSION['finalPlaces'][$i].', ';
    }
    $insertData=array(0=>$id[0][0], 1=>$order, 2=>$_SESSION['day'], 3=>$_SESSION['convers_id'], 4=>date("Y-m-d"), 5=>$str);
    $orderWrite->insert($collsOrder, $insertData);
        // запись в status забронированных мест
    $orderId = array(0 => 'order_id');
    $orderValue = array('user_id' => $id[0][0], 'date_convers' => $_SESSION['day'], 'convers_id' => $_SESSION['convers_id']);
    $orderIdForWrite = $orderWrite->selectWhere($orderId, $orderValue);//id заказа
    rsort($orderIdForWrite);
    $collsStatus = array(0 => 'hall_id', 1 => 'conv_id', 2 => 'date_converse', 3 => 'user_id', 4 => 'order_id');
    for ($i = 0; $i < count($_SESSION['finalPlaces']); $i++) {//запись
        $insertSatus=array(0=>$_SESSION['finalPlaces'][$i], 1=>$_SESSION['convers_id'], 2=>$_SESSION['day'], 3=>$id[0][0], 4=>$orderIdForWrite[0][0]);
        $dbStatus->insert($collsStatus, $insertSatus);
    }
if(!empty($id) && !empty($orderIdForWrite) && !empty($order)){
    $_SESSION['allWrite'] = 'Ваш заказ принят!';
    unset($_SESSION['errorAllWrite']);
    unset($_SESSION['session']);
    unset($_SESSION['convers']);
    unset($_SESSION['day']);
    unset($_SESSION['time']);
    unset($_SESSION['error_mail']);
    unset($_SESSION['mail']);
    unset($_SESSION['sum']);
    unset($_SESSION['errorPlaces']);
    unset($_SESSION['c_max']);
    unset($_SESSION['allMax']);
    unset($_SESSION['finalPlaces']);
    unset($_SESSION['finalMessage']);

}else{
    $_SESSION['errorAllWrite'] = 'Ошибка записи!';
    unset($_SESSION['allWrite']);
}

}

if(isset($_POST['delete']) && !empty($_POST['del'])){
    $check = $_POST['del'];

    for($i = 0; $i < count($check); $i++){
        $orderWrite->delFrom($check[$i]);
        $dbStatus->delFrom($check[$i]);
    }
    header ("Location: /index.php?order");
    exit;
}
if(isset($_POST['repeat'])){
    unset($_SESSION['session']);
    unset($_SESSION['convers']);
    unset($_SESSION['day']);
    unset($_SESSION['time']);
    unset($_SESSION['error_mail']);
    unset($_SESSION['mail']);
    unset($_SESSION['sum']);
    unset($_SESSION['errorPlaces']);
    unset($_SESSION['c_max']);
    unset($_SESSION['allMax']);
    unset($_SESSION['finalPlaces']);
    unset($_SESSION['finalMessage']);
    unset($_SESSION['errorAllWrite']);
    unset($_SESSION['allWrite']);

}

header ("Location: /index.php?hall");
exit;
?>