<?php
class ValidateForm{
	// установка  начальной границы проверки длины значений при валидации полей
	protected function limitStart($start){
		if(is_numeric($start)) return $start;
	}
	// установка  конесной границы проверки длины значений при валидации полей
	protected function limitEnd($end){
		if(is_numeric($end)) return $end;
	}

	// Функция валидации даты используется в function validateSelectDate
	protected function day($d, $m, $y){
		if($m == 2 && $y%4 == 0 && $d > 29){
			return false;
		}elseif($m == 2 && $y%4 != 0 && $d > 28){
			return false;
		}elseif(($m == 4 || $m == 6 || $m == 9 || $m == 11) && $d > 30){
			return false;
		}else{
			return true;
		}
	}

	//Валидирует текст, пароль. Не допускает 2 слова
	public function validateInputAlone($text, $textArr, $start, $end){
		$text = trim($text);
		$text = htmlspecialchars($text);

		if(!empty($text) && (is_string($text) || is_numeric($text)) && mb_strlen($text, 'utf-8') <= $this->limitEnd($end) && mb_strlen($text, 'utf-8') >= $this->limitStart($start) && count($textArr) == 1){
			return $text;
		}
		return false;
	}

	//Валидирует textarea
	public function validateInputTextarea($text, $start){
		$text = trim($text);
		$text = htmlspecialchars($text);

		if(!empty($text) && (is_string($text) || is_numeric($text)) && mb_strlen($text, 'utf-8') >= $this->limitStart($start)){
			return $text;
		}
		return false;
	}

	public function validateMail($mail){
		$mail = trim($mail);
		if($mail[0] == '@' || $mail[mb_strlen($mail)-1] == '@'){//не первая и не последня собачка
			return false;
		}		
			// Фильтрация для рядом стоящих собак	
		$res = '';

		for($i = 0; $i < mb_strlen($mail); $i++){
			if ($mail[$i] != '@'){
			$res .= $mail[$i];
		}elseif($mail[$i] != $mail[$i - 1]){
			$res .= $mail[$i];
		}
		} 

			//проверяем на наличие собачки вообще
		$mail_str = str_replace('@',' ', $res);
		$mail_arr = explode('@', $res);

		if($mail_str == $res){
			return false;
		}elseif(count($mail_arr) != 2){//проверка на наличие нескольких собачек не стоящих рядом
			return false;
		}else{
			return $res;
		}	
	}
	
	public function validateRadio($radio){
		if(!empty($radio)) return true;
	}
// select 
	public function validateSelect($select){
// остальные варианты
		if(!empty($select)){
			return true;
		}
	}
// если select - дата. Обязательно МАССИВ
	public function validateSelectDate($selectDay, $selectMonth, $selectYear){
		if(!empty($selectDay) && !empty($selectMonth) && !empty($selectYear) && $this->day($selectDay, $selectMonth, $selectYear)){
			return true;
		}
		return false;
	}
}
?>