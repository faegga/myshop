<?php
// Модель для таблицы категорий (categories)

// Получить дочернии категории для категорий $catId

	function getChildrenForCat($catId)
	{
		$sql = "SELECT * FROM categories WHERE parent_id = '{$catId}'";
		
		$rs = mysql_query($sql);
		
		return createSmartyRsArray($rs);
	}
		

// Получить главные категории с привязками дочерних return массив категорий
	

	function getAllMainCatsWithChildren(){
		$sql = 'SELECT * FROM categories WHERE parent_id = 0';
		
		$rs = mysql_query($sql);
		
		$smartyRs = array();
		while ($row = mysql_fetch_assoc($rs)) {
			
			$rsChildren =getChildrenForCat($row['id']);
			
			if($rsChildren){
				$row['children'] = $rsChildren;
			}
			
		$smartyRs[] = $row;	
		}
		
		return $smartyRs;
	}
	
// Получить данные категории по id; integer $catId ID категории; array-строка категории

function getCatById($catId)
{
	$catId = intval($catId);
	$sql = "SELECT * FROM categories WHERE id = '{$catId}'";
	
	$rs = mysql_query($sql);
	return mysql_fetch_assoc($rs);
}

// Получить все главные категории (категорий которые не являются дочерними)
	
	function getAllMainCategories()
	{
		$sql = 'SELECT * FROM categories WHERE parent_id =0';
		
		$rs = mysql_query($sql);
		
		return createSmartyRsArray($rs);
	}
	
// Добавление новой категории

	function insertCat($catName, $catParentId= 0)
	{
	// готовим запрос
	$sql = "INSERT INTO categories (`parent_id`, `name`) VALUES ('{$catParentId}', '{$catName}')";
	// выполняем запрос
	mysql_query($sql);
	// получаем id добавленной записи
	$id = mysql_insert_id();
	
	return $id;
	}
	
	// Получить все категории
	function getAllCategories()
	{
		$sql = 'SELECT * FROM categories ORDER BY parent_id ASC';
		
		$rs = mysql_query($sql);
		
		return createSmartyRsArray($rs);
	}
	
	// Обновление категории
	 function updateCategoryData($itemId, $parentId = -1, $newName = '')
	{
		$set = array();
		
		if($newName){
			$set[] = " `name` = '{$newName}'";
		}
		if($parentId > -1){
			$set[] = "`parent_id` = '{$parentId}'";
		}
		
		$setStr = implode($set, ", ");
		$sql = "UPDATE categories SET {$setStr} WHERE id = '{$itemId}'";
		
		$rs = mysql_query($sql);
		
		return $rs;
	} 