<?php
$show_link = 5;
$sql_news_main_page = "SELECT * FROM news";
$query_news_main_page =  mysql_query($sql_news_main_page);

//8 последних новостей по дате в центр
$sql_news_main = "SELECT * FROM news ORDER BY date_news DESC LIMIT 8";
$query_news_main = mysql_query($sql_news_main);
while($res_news_main[] = mysql_fetch_array($query_news_main)){
	$result_news_main = $res_news_main;
}

$title_main = 'Последнее:';

$title_aside = 'Самое свежее из разделов:';

include_once DR ."/view/main.php";
?>