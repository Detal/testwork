<div class="columnWrapper">
<div class='news_desc'>
<div class='paginator_href'>
<?php
if(!empty($_SESSION['allWrite']) && $_SESSION['allWrite'] = 'ok'){
    echo '<h2 class="error">Ваш заказ принят!</h2>';
}else {
    if (!empty($_SESSION['day'])) echo $hallMap->getData($_SESSION['day']);
    if (!empty($_SESSION['session'])) echo $hallMap->getData($_SESSION['session']);
}
//выборка цен на категории
   /* $informPrice=array(0=>'category_price');
    $queryPrice=$price->select($informPrice);
    $res=$hallMap->showPrice($queryPrice);
    echo $res;*/

    if (!isset($_SESSION['convers']) && !isset($_SESSION['session'])) {//показ дат для выбора дня
       // echo $hallMap->startForm("/www/controller/control.php", "post", "form", "form");
        //если сделан заказ - возможность еще одного заказа
        if(!isset($_SESSION['allWrite'])) {
            $hallMap->setDays();
            echo $hallMap->getTitle();
            echo $hallMap->startForm("/controller/control.php", "post", "form", "form");
            echo $hallMap->getDays();
            echo $hallMap->endForm("back", "отменить");
        }else{
            echo $hallMap->startForm("/controller/control.php", "post", "form", "form");
            $submitName=array(0=>'exit');
            $submitVal=array(0=>'выйти');
            echo $hallMap->createSubmit($submitName, $submitVal, 1);
            echo $hallMap->endForm("repeat", "еще заказ");
        }

    } elseif (isset($_SESSION['convers'])) {// показ расписания сеансов
        echo $hallMap->getTitleSession();
        echo $hallMap->startForm("/controller/control.php", "post", "form", "form");
        $conversTimes=array(0=>'time_start', 1=>'time_end');
        $convers=$dbConvers->select($conversTimes);
        $hallMap->setSession($convers);

        //echo $hallMap->getTitleSession();
        echo $hallMap->getSession($_SESSION['day'], $_SESSION['time']);

        $submitName=array(0=>'back');
        $submitVal=array(0=>'назад');
        echo $hallMap->createSubmit($submitName, $submitVal, 1);

        echo $hallMap->endForm("submit", "добавить");
//показ самого зала
    } elseif (isset($_SESSION['session'])) {
        // финальное сообщение
        if (!empty($_SESSION['finalMessage'])) {
            echo '<h2 class="error">'.$_SESSION['finalMessage'].'</h2>';
        } elseif (!empty($_SESSION['errorMessage'])) {
            echo '<h2 class="error">'.$_SESSION['errorMessage'].'</h2>';
        }
        //выборка цен на категории
        $informPrice=array(0=>'category_price');
        $queryPrice=$price->select($informPrice);
        $res=$hallMap->showPrice($queryPrice);
        echo $res;
//таблица оставшегося количества мест для выбора
        $table=$hallMap->sortPrice($queryPrice);
        if (empty($_SESSION['c_max']) && empty($_SESSION['allMax'])) {
            echo $hallMap->createTable($table, 0, 0);// вместо 0 передавть сессию(выборка из STATUS)
        } elseif (!empty($_SESSION['errorMessage'])) {
            echo $hallMap->getError($_SESSION['errorMessage']);
        } else {
            echo $hallMap->createTable($table, $_SESSION['c_max'], $_SESSION['allMax']);
        }

        echo $hallMap->startForm("/controller/control.php", "post", "form", "form");
        //схема зала
        $str='place';
        if (!empty($_SESSION['finalMessage'])) {
            //echo $_SESSION['finalMessage'];
            $redoName=array(0=>'redo');
            $redoVal=array(0=>'подтвердите');
            echo '<div class="repeat">'.$hallMap->createSubmit($redoName, $redoVal, 1).'</div>';
        }
        echo $hallMap->createInputCheck($str, 5, 10, $_SESSION['resConvers']);

        $labelMail=array(0=>'Email: ');
        $nameMail=array(0=>'mail');
        $placeholderMail=array(0=>'введите email');
        echo $hallMap->createInputEmail($labelMail, $nameMail, $placeholderMail, 1);
       /* if (!empty($_SESSION['error_mail'])) {
            echo $_SESSION['error_mail'];
        }*/
        $submitName=array(0=>'back');
        $submitVal=array(0=>'назад');
        echo $hallMap->createSubmit($submitName, $submitVal, 1);

        echo $hallMap->endForm("submit", "добавить");
    }
?>
</div>
