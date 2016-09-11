<?php
// модель для таблицы продукции (purchase)
	function setPurchaseForOrder($orderId, $cart)
	{
		$sql = "INSERT INTO purchase (order_id, product_id, price, amount) VALUES";
		
		$values = array();
		// формируем массив для запроса для каждого товара
		foreach ($cart as $item) {
			$values[] = "('{$orderId}', '{$item['id']}', '{$item['price']}', '{$item['cnt']}')";
		}
		// преобразовываем массив в строку
		$sql .= implode($values, ', ');
		$rs = mysql_query($sql);
		return $rs;
		
	}
	
	function getPurchaseForOrder($orderId)
	{
		$sql = "SELECT `pe`.*, `ps`.`name` FROM purchase as `pe` JOIN products as `ps` ON `pe`.product_id = `ps`.id WHERE `pe`.order_id = {$orderId}";
		//d($sql);
		$rs = mysql_query($sql);
		return createSmartyRsArray($rs);
	}