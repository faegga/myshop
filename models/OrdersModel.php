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
				
	$dateCreated =date('Y.m.d H:i:s');	
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

// Получить список заказов с привязкой к продуктам для пользователя $userId
	function getOrderWithProductsByUser($userId)
	{
		$userId = intval($userId);
		$sql = "SELECT * FROM orders WHERE `user_id` = '{$userId}' ORDER BY id DESC";
		
		$rs = mysql_query($sql);
		
		$smartyRs = array();
		while ($row = mysql_fetch_assoc($rs)) {
			$rsChildren = getPurchaseForOrder($row['id']);
			
			if($rsChildren){
				$row['children'] = $rsChildren;
				$smartyRs[] = $row;
			}
		}
		return $smartyRs;
	}
	
	function getOrders(){
		$sql = "SELECT o.*, u.name, u.email, u.phone, u.adress FROM orders AS `o`
		LEFT JOIN users AS `u` ON o.user_id = u.id ORDER BY id DESC";
		
		$rs = mysql_query($sql);
		
		$smartyRs = array();
		while ($row = mysql_fetch_assoc($rs)) {
			$rsChildren = getProductsForOrder($row['id']);
			
			if($rsChildren){
				$row['children'] = $rsChildren;
				$smartyRs[] = $row;
			}
		}
		return $smartyRs;
	}
	
// Получить продукты заказа 
	function getProductsForOrder($orderId)	
	{
		$sql = "SELECT * FROM purchase AS pe LEFT JOIN products AS ps ON pe.product_id = ps.id
		WHERE (`order_id` = '{$orderId}')";
		
		$rs = mysql_query($sql);
		return createSmartyRsArray($rs);
	}
	
	function updateOrderStatus($itemId, $status){
		$status = intval($status);
		$sql = "UPDATE orders SET `status` = '{$status}' WHERE id = '{$itemId}'";
		$rs = mysql_query($sql);
		return $rs;
	}
	
	function updateOrderDatePayment($itemId, $datePayment){
		$sql = "UPDATE orders SET `date_payment` = '{$datePayment}' WHERE id = '{$itemId}'";
		
		$rs = mysql_query($sql);
		
		return $rs;		
	}