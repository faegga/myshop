<?php
// Модель для продукции (products)
// Получаем последние добавленный товары $limit кол-во товаров
// array Массив товаров

function getLastProducts($limit = null)
{
	$sql = "SELECT * FROM `products` ORDER BY id DESC";
	if($limit){
		$sql .= " LIMIT {$limit}";
	}
	
	$rs = mysql_query($sql);
	return createSmartyRsArray($rs);
}

// Получить продукты для категории $itemId
	function getProductsByCat($itemId)
	{
		$itemId = intval($itemId);
		$sql = "SELECT * FROM products WHERE category_id = '{$itemId}'";
		
		$rs = mysql_query($sql);
		return createSmartyRsArray($rs);
	}
