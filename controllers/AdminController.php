<?php
// Контроллер бэкенда сайта

// подключаем модели

	include_once '../models/CategoriesModel.php';
	include_once '../models/ProductsModel.php';
	include_once '../models/OrdersModel.php';
	include_once '../models/PurchaseModel.php';
	
	$smarty->setTemplateDir(TemplateAdminPrefix);
	$smarty->assign('templateWebPath', TemplateAdminWebPath);
	
	function indexAction($smarty){
		$rsCategories = getAllMainCategories();
		
		$smarty->assign('rsCategories', $rsCategories);
		$smarty->assign('pageTitle', 'Управление сайтом');
		
		loadTemplate($smarty, 'adminHeader');
		loadTemplate($smarty, 'admin');
		loadTemplate($smarty, 'adminFooter');
	}
	
	function addnewcatAction(){
		$catName = $_POST['newCategoryName'];
		$catParentId = $_POST['generalCatId'];
		
		$res = insertCat($catName, $catParentId);
		if($res){
			$resData['success'] = 1;
			$resData['message'] = 'Категория добавлена';
		} else {
			$resData['success'] = 0;
			$resData['message'] = 'Ошибка добавления категории';
		}
		echo json_encode($resData);
		return;
	}
	
	//Страница управления категориями
	 function categoryAction($smarty){
		$rsCategories = getAllCategories();
		$rsMainCategories = getAllMainCategories();
		
		$smarty->assign('rsCategories', $rsCategories);
		$smarty->assign('rsMainCategories', $rsMainCategories);
		$smarty->assign('pageTitle', 'Управление сайтом');
		
		loadTemplate($smarty, 'adminHeader');
		loadTemplate($smarty, 'adminCategory');
		loadTemplate($smarty, 'adminFooter');
	} 
	
	  function updatecategoryAction(){
		$itemId = $_POST['itemId'];
		$parentId = $_POST['parentId'];
		$newName = $_POST['newName'];
		
		$res = updateCategoryData($itemId, $parentId, $newName);
		
		if($res){
			$resData['success'] = 1;
			$resData['message'] = 'Категория обновлена';
		} else {
			$resData['success'] = 0;
			$resData['message'] = 'Ошибка изменения данных категории';
		}
		echo json_encode($resData);
		return;
	}  
	
	// Страница управления товарами
	
	function productsAction($smarty){
		$rsCategories = getAllCategories();
		$rsProducts = getProducts();
		
		$smarty->assign('rsCategories', $rsCategories);
		$smarty->assign('rsProducts', $rsProducts);
		
		$smarty->assign('pageTitle', 'Управление сайтом');
		
		loadTemplate($smarty, 'adminHeader');
		loadTemplate($smarty, 'adminProducts');
		loadTemplate($smarty, 'adminFooter');
	}
	
	function addproductAction(){
		$itemName = $_POST['itemName'];
		$itemPrice = $_POST['itemPrice'];
		$itemDesc = $_POST['itemDesc'];
		$itemCat = $_POST['itemCatId'];
		
		$res = insertProduct ($itemName, $itemPrice, $itemDesc, $itemCat);
		
		if($res){
			$resData['success'] = 1;
			$resData['message'] = 'Изменения успешно внесены';
		} else {
			$resData['success'] = 0;
			$resData['message'] = 'Ошибка изменения данных';
		}
		echo json_encode($resData);
		return;
	}