<?php
include_once "CreateForm.php";
class CreateHall extends CreateForm{
    protected $title;
    protected $titleSession;
    protected $session;
    protected $days = array();
    public $prices = array();
    protected $categories = array();

    function __construct($title, $titleSession){
        $this->title = $title;
        $this->titleSession = $titleSession;
    }
// получение заголовка
    public function getTitle(){
        $res = '<h2 class="error">'. $this->title.'</h2>';
        return $res;
    }
//получение заголовка сеансов
    public function getTitleSession(){
        $res = '<h2 class="error">'. $this->titleSession.'</h2>';
        return $res;
    }
// установка допустимых дней
     public function setDays(){
         $str = '';
         for($i = 0; $i < 5; $i++){
             if($i == 0){
                 $str = date('Y-m-d');
                 $this->days[$i] = $str;
             }else{
                 $this->days[$i] = date("Y-m-d", time() + 89400*$i);
             }
         }
         $this->days;
     }
     // получение допустимых дней
    public function getDays(){
        $res = '';
        for($i = 0; $i < count($this->days); $i++){
            $res .= '<input class="button2" type="submit" name="day" value="'.$this->days[$i].'">';
        }
        return $res;
    }
    //показ выбраного дня в разделе сеансы и выбранного сеанса
    public function getData($day){
        $res .= '<h2 class="error">'.$day.'</h2><hr />';
        return $res;
    }
// установка расписания сеансов
    public function setSession($session){
        $this->session = $session;
    }
//получение расписания сеансов
    public function getSession($date, $time){
        $res = '';
        for($i = 0; $i < count($this->session); $i++) {
            if ($date == date('Y-m-d') && $time > $this->session[$i][0]) {
                continue;
            } else {
                $res .= '<input class="button2" type="submit" name="session" value="'.$this->session[$i][0] . '-' . $this->session[$i][1] . '">';
            }
        }
        return $res;
    }


    public function setCategories($categories){
        $this->categories = $categories;
    }
    //вывод ошибок
    public function getError($error){
        return '<span class="error">'.$error.'</span>';
    }
// input type="checkbox", $nPow - количество рядов в категории, $nPlace - мест в ряду, $checked - SESSION - массив c id занятых мест
    public function createInputCheck($nameTeg, $nRow, $nPlace, $checked){
        $counter = 1;
        $res = '<div>';
        if(is_string($nameTeg) && is_numeric($nRow) && is_numeric($nPlace)){
            for($j = 0; $j < 4; $j++) {
                if($j != 3) {
                    $res .= '<label class="label'.($j+1).'">';
                }else{
                    $res .= '<label class="last">';
                }
                for ($k = 0; $k < $nRow; $k++) {
                    if($j == 0) {
                        $js = ($k + 1);
                        $res .= '<p> ряд ' . ($k + 1);
                    }elseif($j > 0 && $j < 3) {
                        $js = ($k + 1);
                        $res .= '<p>';
                    }elseif ($j == 3){
                        $js = ($k + 6);
                        $res .= '<p> ряд ' . ($k + 6);
                    }else{
                        $res .= '<p>';
                    }
                    //количество мест в ряду
                    for ($i = 0; $i < $nPlace; $i++) {
                        if($counter <= 50 || ($counter >= 101 && $counter <= 150)){
                            $cat = 2;
                        }elseif($counter <= 100 && $counter >= 51){
                            $cat = 1;
                        }else{
                            $cat = 3;
                        }
                        for($y = 0; $y < count($checked); $y++){
                            // учет занятых мест
                            if($checked[$y] == $counter){
                                $res .= '<input type="checkbox" data-tooltip="ряд '.$js.', место '.$counter.'" name="' . $nameTeg./*$cat . */'[]" value="' . $counter . '" disabled/>';
                                $counter++;
                                continue 2;
                            }
                        }
                        $res .= '<input type="checkbox" data-tooltip="ряд '.$js.', место '.$counter.'" name="' . $nameTeg./*$cat . */'[]" value="' . $counter . '"/>';
                        $counter++;
                    }
                    $res .= '</p>';
                }
                $res .= '</label>';
            }
            $res .= '</div>';
            return $res;
        }
        return $res .= 'Некорректные данные';
    }
    // вывод строки из массива
    public function showPrice($data){
        $arr = array();
        for($i = 0; $i < count($data); $i++){
            if($data[$i][0]) {
                for ($k = 0; $k < count($data[$i]); $k++){
                    $arr[$i] = $data[$i][$k];
                }
                //$arr = array_unique($arr);
                rsort($arr);
             }else{
                //$arr = array_unique($data);
                rsort($arr);
            }
        }
        $res = '<div class="price">';
        if(is_array($arr)){
            for($i = 0; $i < count($arr); $i++) {
                $res .= '<div class="error"><div class="colored'.($i+1).'"></div> - <span>'.$arr[$i]. 'грн.</span></div>';
            }
            $res .= '</div>';
        }
        return $res;
    }
    //Сортирует и убирает повторяющиеся значения
    public function sortPrice($data){
        $arr = array();
        for($i = 0; $i < count($data); $i++){
            if($data[$i][0]) {
                for ($k = 0; $k < count($data[$i]); $k++){
                    $arr[$i] = $data[$i][$k];
                }
                //$arr = array_unique($arr);
                arsort($arr);
            }else{
                //$arr = array_unique($data);
                arsort($arr);
            }
        }
        return $arr;
    }
    //таблица доступности мест для заказа принимает массив из showPrice,$nCat - сколько выбрал клиент уже в категории,
    // $nAll -сколько клиент выбрал всего
    public function createTable($showPrice, $nCat, $nAll){
        if(is_array($nCat)) arsort($nCat);
        $res .= '<table><tr><th>Категории</th>';
        for($k = 0; $k < 3; $k++) {
            if($k == 0){
                for($i = 0; $i < count($showPrice); $i++){
                    $res .= '<th>'.$showPrice[$i].'</th>';
                }
                $res .= '<th>Всего</th></tr>';
            }elseif($k == 1){
                $res .= '<td>Доступно мест</td>';
                for ($i = 0; $i < count($showPrice); $i++) {
                    $res .= '<td>'.(5-$nCat[$i+1]).'</td>';// добавить параметр в функцию, для автоматического подсчета остатка
                }
                $res .= '<td>'.(15-$nAll).'</td></tr>';// подсчитывать по формуле
            }/*else{
                $res .= '<td>Выбрано</td>';
                for ($i = 0; $i < count($showPrice); $i++) {
                    $res .= '<td>0</td>';// добавить параметр в функцию, для автоматического подсчета остатка
                }
                $res .= '<td>0</td></tr>';// подсчитывать по формуле
            }*/
        }
        $res .= '</table>';
        //return $showPrice;
        return $res;
    }
    public function getOrder($order){
        $res = '';
        $count = 0;
        for($i = 0; $i < count($order); $i++) {
            if(!empty($order[$i][1]) && $order[$i][2] > date('Y-m-d')) {
                $count++;
                $res .= '<label class="order_l"><span class="order_s">Заказ №: '.$order[$i][0].'<br />'.$order[$i][1].'</span><input type="checkbox" name="del[]" value="'.$order[$i][0].'"/></label>';
            }elseif(!empty($order[$i][1]) && $order[$i][2] <= date('Y-m-d')){
                $res .= '<label class="order_l"><span class="order_s">Заказ №: '.$order[$i][0].'<br />' .$order[$i][1].'</span></label>';
            }
        }
        return $res;
    }
}