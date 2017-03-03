<?php
class Dbase{
    public $dbh;
    public $host;
    public $user;
    public $pswd;
    public $database;
    public $table;
//$table - таблица
  function __construct($host, $user, $pswd, $database, $table){
      $this->host = $host;
      $this->user = $user;
      $this->pswd = $pswd;
      $this->database = $database;
      $this->table = $table;
      $this->dbh = mysqli_connect($this->host, $this->user, $this->pswd, $this->database) or die('Нет соединения с БД');
    }

// массив со значениями для полей 2 массива
    public function insert($colls, $data){
        $sql = "INSERT INTO " .$this->table." SET ";
        if(count($data) == count($colls)) {
            for ($i = 0; $i < count($colls); $i++) {
                if($i != count($colls)-1) {
                    $sql .= $colls[$i] . "='".$data[$i]."', ";
                 }else{
                    $sql .= $colls[$i] . "='" . $data[$i] . "'";
                }
            }
        }
        //return $sql;
        mysqli_query($this->dbh, $sql);
    }
    //выбор всех полей
    public function selectAll(){
        $sql = "SELECT * FROM " .$this->table."";
        //return $sql;
        $query = mysqli_query($this->dbh, $sql);
        while($res[] = mysqli_fetch_row($query)){
            $result = $res;
        }
        return $result;
    }
    // $data - массив полей;
    public function select($data){
        $sql = "SELECT ";
        for($i = 0; $i < count($data); $i++){
            if(($i != count($data)-1) && count($data) != 1){
                $sql .= $data[$i].", ";
            }elseif(count($data) == 1 && $i == 0){
                $sql .= $data[$i] . " FROM " .$this->table."";
                break;
            }else{
                $sql .= $data[$i]." FROM " .$this->table."";
            }
        }
        //return $sql;
        $query = mysqli_query($this->dbh, $sql);
        while($res[] = mysqli_fetch_row($query)){
            $result = $res;
        }
        return $result;
    }

    public function selectWhere($data, $search){
        $sql = "SELECT ";
        for($i = 0; $i < count($data); $i++){
            if((count($data) > 1) && $i != (count($data)-1)){//если массив > 1, не последний элемент
                $sql .= $data[$i].", ";
            }elseif(count($data) == 1 && $i == 0){//если массив длинной = 1
                $sql .= $data[$i] . " FROM " .$this->table."";
                break;
            }elseif((count($data) > 1) && $i == (count($data)-1)){
                $sql .= $data[$i]." FROM " .$this->table."";
            }
        }
        $count = 0;
        $sql .= " WHERE ";
        foreach($search as $key => $value){
            if((count($search) > 1) && $count == 0){//если массив > 1, первый элемент
                $sql .= $key." = '".$value."'";
            }elseif(count($search) == 1 && $count == 0){//если массив длинной = 1
                $sql .= $key." = '".$value."'";
                break;
            }elseif((count($search) > 1) && $count != 0 && $count != (count($search)-1)){//если массив > 1, не первый и не последний элемент
                $sql .=" AND ". $key." = '".$value."'";
            }elseif((count($search) > 1) && $count == (count($search)-1)){//если массив > 1,  последний
                $sql .=" AND ". $key." = '".$value."'";
            }
            $count++;
        }
        //return $sql;
        $query = mysqli_query($this->dbh, $sql);
        //return $query;
        while($res_log[] = mysqli_fetch_row($query)){
            $result = $res_log;
        }
        //if(empty($result)){ return 'Пусто!';}
        return $result;
    }
    public function delFrom($del){
        $sql = "DELETE FROM ".$this->table." WHERE order_id='".$del."'";
        $query = mysqli_query($this->dbh, $sql);
        //return $sql;
    }
}