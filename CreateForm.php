<?php
class CreateForm{

// Функция установки месяца
protected function month($n){
	if($n == 1){
		return 'Январь';
	}elseif($n == 2){
		return 'февраль';
	}elseif($n == 3){
		return 'март';
	}elseif($n == 4){
		return 'арпель';
	}elseif($n == 5){
		return 'май';
	}elseif($n == 6){
		return 'июнь';
	}elseif($n == 7){
		return 'июль';
	}elseif($n == 8){
		return 'август';
	}elseif($n == 9){
		return 'сентябрь';
	}elseif($n == 10){
		return 'октябрь';
	}elseif($n == 11){
		return 'ноябрь';
	}elseif($n == 12){
		return 'декабрь';
	}
}

//начало формы
	public function startForm($action, $method, $name, $class){
		$res = '';
		if($method == 'post' || $method == 'get' && is_string($name) && is_string($class) && is_string($action)){
			return $res .= '<form action="'.$action.'" method="'.$method.'" name="'.$name.'" class="'.$class.'">';
		}
		return $res .= 'Некорректные данные';
	}
// конец формы и input type="submit"
	public function endForm($name, $value){
		$res = '';
		if(is_string($name) && is_string($value)){
			return $res = '<label class="button"><input class="button3" type="submit" name="'.$name.'"  value="'.$value.'"/></label></form>';
		}
		return $res .= 'Некорректные данные';
	}
// input type="text", $nameArrFirst, $nameArrTeg и $placeholderArr = МАССИВЫ
	public function createInputText($nameArrFirst, $nameArrTeg, $placeholderArr, $n){
		$res = '';
		if(is_array($nameArrFirst) && is_array($nameArrTeg) && is_array($placeholderArr) && is_numeric($n)){
			for($i = 0; $i < $n; $i++){
				$res .= '<label><span>'.$nameArrFirst[$i].'</span><input type="text" name="'.$nameArrTeg[$i].'" placeholder="'.$placeholderArr[$i].'" /></label><br /><br />';
			}
			return $res;
		}
		return $res .= 'Некорректные данные';
	}
// textarea $nameArrFirst, $nameArrTeg и $placeholderArr = МАССИВЫ
	public function createTextarea($nameArrFirst, $nameArrTeg, $placeholderArr, $n){
		$res = '';
		if(is_array($nameArrFirst) && is_array($nameArrTeg) && is_array($placeholderArr) && is_numeric($n)){
			for($i = 0; $i < $n; $i++){
				$res .= '<label><span>'.$nameArrFirst[$i].'</span><textarea name="'.$nameArrTeg[$i].'" placeholder="'.$placeholderArr[$i].'"></textarea></label><br /><br />';
			}
			return $res;
		}
		return $res .= 'Некорректные данные';
	}
// input type="password" $nameArrFirst, $nameArrTeg и $placeholderArr = МАССИВЫ
	public function createInputPassword($nameArrFirst, $nameArrTeg, $placeholderArr, $n){
		$res = '';
		if(is_array($nameArrFirst) && is_array($nameArrTeg) && is_array($placeholderArr) && is_numeric($n)){
			for($i = 0; $i < $n; $i++){
				$res .= '<label><span>'.$nameArrFirst[$i].'</span><input type="password" name="'.$nameArrTeg[$i].'" placeholder="'.$placeholderArr[$i].'"></label><br /><br />';
			}
			return $res;
		}
		return $res .= 'Некорректные данные';
	}
// input type="email" $nameArrFirst, $nameArrTeg и $placeholderArr = МАССИВЫ
	public function createInputEmail($nameArrFirst, $nameArrTeg, $placeholderArr, $n){
		$res = '';
		if(is_array($nameArrFirst) && is_array($nameArrTeg) && is_array($placeholderArr) && is_numeric($n)){
			for($i = 0; $i < $n; $i++){
				$res .= '<label class="email"><span>'.$nameArrFirst[$i].'</span><input type="email" name="'.$nameArrTeg[$i].'" placeholder="'.$placeholderArr[$i].'"></label>';
			}
			return $res;
		}
		return $res .= 'Некорректные данные';
	}
// input type="radio", аргумент $nameArrFirst = МАССИВ названий для каждого из переключателей
	public function createInputRadio($nameArrFirst, $nameTeg, $n){
		$res = '';
		if(is_array($nameArrFirst) && is_string($nameTeg) && is_numeric($n)){
			for ($i = 0; $i < $n; $i++){
				$res .= '<label><span>'.$nameArrFirst[$i].'</span><input type="radio" name="'.$nameTeg.'" value="'.$nameTeg[0].($i+1).'"/></label><br /><br />';
			}
			return $res;
		}
		return $res .= 'Некорректные данные';
	}
// input type="checkbox", аргумент $nameArrFirst = МАССИВ названий для каждого из переключателей
    public function createInputCheck($nameArrFirst, $nameTeg, $n, $n1){
        $res = '';
        if(is_array($nameArrFirst) && is_string($nameTeg) && is_numeric($n)){
            for ($i = 0; $i < $n; $i++){
                $res .= '<label><span>'.$nameArrFirst[$i].'</span><input type="checkbox" name="'.$nameTeg.'[]" value="'.($i+1).'"/></label><select name = "sum'.($i+1).'">';
                    for($k = 0; $k < $n1; $k++){
                        $res .= '<option value = "'. $k.'">'.$k.'</option>';
                    }
                    $res .= '</select><br /><br />';
            }
            return $res;
        }
        return $res .= 'Некорректные данные';
    }// input type="button" $nameArr и $valuerArr = МАССИВЫ
	public function createButton($nameArr, $valuerArr, $n){
		$res = '';
		if(is_array($nameArr) && is_array($valuerArr) && is_numeric($n)){
			for ($i = 0; $i < $n; $i++){
				$res .= '<label class="button"><input type="button" name="'.$nameArr[$i].'" value="'.$valuerArr[$i].'"/></label><br /><br />';
			}
			return $res;
		}
		return $res .= 'Некорректные данные';
	}
// input type="submit" $nameArr и $valuerArr = МАССИВЫ
	public function createSubmit($nameArr, $valuerArr, $n){
		$res = '';
		if(is_array($nameArr) && is_array($valuerArr) && is_numeric($n)){
			for ($i = 0; $i < $n; $i++){
				$res .= '<label class="button"><input class="button3" type="submit" name="'.$nameArr[$i].'" value="'.$valuerArr[$i].'"/></label>';
			}
			return $res;
		}
		return $res .= 'Некорректные данные';
	}
	// input type="select", $nameSelect и $nameOpt = МАССИВЫ названий для каждого select и option
	public function createSelect($nameSelect, $nameOpt){
		$res = '';
		$nSelect = count($nameSelect);
		if(is_array($nameSelect) && is_array($nameOpt) && (count($nameOpt) == $nSelect)){
			for($k = 0; $k < $nSelect; $k++){
				$res .= '<select name = "'.$nameSelect[$k].'">';
				for($i = 0; $i < count($nameOpt[$k]); $i++){
					if(is_numeric($nameOpt[$k][$i])){// для годов  и дней значение value = значению
						$res .= '<option value = "'.$nameOpt[$k][$i].'">'.$nameOpt[$k][$i].'</option>';
					}else{
						$res .= '<option value = "'.($i+1).'">'.$nameOpt[$k][$i].'</option>';
					}
				}
				$res .= '</select>';
			}
			return $res . '<br />';
		}
		return $res .= 'Некорректные данные';
	}
// создание массива с месяцами
	public function createMonth(){
		$res = array();
		for($i = 1; $i <= 12; $i++){
			$res[$i-1] =  $this->month($i);
		}
		return $res;
	}
}
?>