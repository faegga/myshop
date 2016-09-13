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
// Получить данные продукта по ID
	function getProductById($itemId)
	{
		$itemId = intval($itemId);
		$sql = "SELECT * FROM products WHERE id ='{$itemId}'";
		
		$rs = mysql_query($sql);
		return mysql_fetch_assoc($rs);
	}
	
// Получить список про-ов из массива идентиф-ов
function getProductsFromArray($itemsIds)
{	
	$strIds = implode($itemsIds, ', ');
	
	$sql = "SELECT * FROM products WHERE id in ({$strIds})";
	
	$rs = mysql_query($sql);
	
	return createSmartyRsArray($rs);
}

function getProducts()
{
	$sql = "SELECT * FROM `products` ORDER BY category_id";
	
	$rs = mysql_query($sql);
	
	return createSmartyRsArray($rs);
}

// Добавление нового товара
function insertProduct ($itemName, $itemPrice, $itemDesc, $itemCat){
	$sql = "INSERT INTO products SET
	`name`= '{$itemName}',
	`price`= '{$itemPrice}',
	`description`= '{$itemDesc}',
	`category_id`= '{$itemCat}'";
	
	$rs = mysql_query($sql);
	return $rs;
}
