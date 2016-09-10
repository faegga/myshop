<?php
// Модель для таблицы заказов (orders)
	function makeNewOrder($name, $phone, $adress)
	{
// инициализация переменных
	$userId = $_SESSION['user']['id'];
	$comment = "id пользователя: {$userId}<br />
				Имя: {$name}<br />
				Тел: {$phone}<br />
				Адрес: {$adress}";
				
	$dataCreated =date('Y.m.d H:i:s');	
	$userIp      =$_SERVER['REMOTE_ADDR'];
// запрос к БД
	$sql = "INSERT INTO orders (`user_id`, `date_created`, `date_payment`, `status`, `comment`, `user_ip`)
	VALUES ('{$userId}', '{$dateCreated}', null, '0', '{$comment}', '{$userIp}')";
	
	$rs = mysql_query($sql);
// получить Id созданного заказа
	if($rs){
		$sql = "SELECT id FROM orders ORDER BY id DESC LIMIT 1";
	$rs = mysql_query($sql);
	// преобразование результатов запроса
	$rs = createSmartyRsArray($rs);
	// возвращаем id созданного запроса
	if(isset($rs[0])){
		return $rs[0]['id'];
		}
	}
	return false;
}