<?php
include_once "ValidateForm.php";
class ValidateHall extends ValidateForm{
    protected $errorPlaces;
    protected $limitCategory;
    protected $allLimit;
    protected $prices = array();

    //установка лимитов
    public function setLimits($limitCategory, $allLimit){
        $this->limitCategory = $limitCategory;
        $this->allLimit = $allLimit;
    }
    public function getLimitCategory(){
        if(!empty($this->limitCategory)) {
            return $this->limitCategory;
        }else{
            return false;
        }
    }
    public function getAllLimit(){
        if(!empty($this->allLimit)) {
            return $this->allLimit;
        }else{
            return false;
        }
    }
    // валидация макс возможного мест для выбора
    public function setAllPlaces($places){
        if(!empty($places) && count($places) <= $this->allLimit){
            return intval(($this->allLimit) - count($places));
        }else{
            return false;
        }
    }
    public function validateLimitCategory($places){
        if(!empty($places) && (($this->allLimit) > count($places))){
            $counter = 0;
            $res = array();
            sort($places);
            for($i = 0; $i < count($places); $i++){
                if($count != $places[$i]) $counter = 0;// обнуление счетчика при переходе на подсчет следующей категории
                $counter++;
                if($counter > $this->limitCategory){
                    $count = $places[$i];
                    $this->errorPlaces = 'Вы превысили лимит мест! В '.$count.' категории.';
                    return $this->errorPlaces;
                }else{
                    $count = $places[$i];
                    $res[$count] = $counter;
                }
            }
            return $res;
        }else{
            return false;
        }
    }

    public function setPrices($prices){
        for($i = 0; $i < count($prices); $i++) {
            $this->prices[$i+1] = $prices[$i][0];
        }
    }
    //подсчет стоимости заказа $nPlaces - массив с ключами = категоия, значение - количество мест
    public function counterSum($nPlaces){
        $res = '';
        if(is_array($nPlaces)){
            for($i = 0; $i < count($this->prices); $i++){
                if($nPlaces[$i]){
                    $res += $nPlaces[$i] * $this->prices[$i];
                }
            }
        }
        return $res;
    }
    // сообщение по итоговому заказу ДОДЕЛАТЬ!!!!!!!!!! больше 3 мест не считает
    public function getFinalMessage($allPlaces, $sum){
        $res = '<span>Заказ: Места: ';
        for($i =0; $i < count($allPlaces); $i++){
            $res .=' [ '. $allPlaces[$i].' ] ';
        }
        $res .= " На сумму:".$sum." </span>";
        return $res;

    }


}