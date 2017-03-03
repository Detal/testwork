<div class="columnWrapper">
<?php
if(isset($_SESSION['id'])) {
    $sql1=array(0=>'order_id', 1=>'orders', 2=>'date_convers', 3=>'convers_id', 4=>'halls', 5=>'date_order');
    $sql2=array('user_id'=>$_SESSION['id']);
    $order=$dbOrders->selectWhere($sql1, $sql2);

    echo $orderMap->getTitle();

    echo $orderMap->startForm("/controller/control.php", "post", "form", "form");
    echo $orderMap->getOrder($order);
    echo $orderMap->endForm("delete", "удалить");
}
?>
</div>
