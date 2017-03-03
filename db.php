<?php
$host = 'localhost';
$user = 'root';
$pswd = '';
$database = 'project';
$desc_db = mysql_connect($host, $user, $pswd) or die('Нет соединения с БД');
mysql_select_db($database) or die('NO DB');
mysql_query("SET NAMES utf-8");
/*$host = 'mysql.zzz.com.ua';
$user = 'detal';
$pswd = '45683968';
$database = 'detal';
$desc_db = mysql_connect($host, $user, $pswd) or die('Нет соединения с БД');
mysql_select_db($database) or die('NO DB');
mysql_query("SET NAMES utf-8");*/
?>
