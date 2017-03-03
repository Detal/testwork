<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<title><?php echo $title; ?></title><!--сделать переменку-->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<link href="/view/css/style.css" rel="stylesheet">
</head>
<body>
<?php if(isset($_GET['main']) && $_GET['main'] == '' || SDR) { ?>
	<div class="pageWrapper1" >
	<?php }else{ ?>
<div class="pageWrapper" >
<?php } ?>
	<header>
        <nav class="clear">
			<ul class="ul">
				<li><a class="first_href" href="/index.php?main">Главная</a></li>
				<li><a class="first_href" href="/index.php?hall">Схема зала</a></li>
				<li><a class="first_href" href="/index.php?order">Список заказов</a></li>
			</ul>
		</nav>
</header>
		<div class="contentWrapper">