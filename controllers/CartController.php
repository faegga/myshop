<?php
// Контроллер работы с корзиной

include_once '../models/CategoriesModel.php';
include_once '../models/ProductsModel.php';

// Добавление продукта в корзину

function addtocartAction () {
	$itemId = isset($_GET['id']) ? intval($_GET['id']) : null;
	if(! $itemId) return false;
	
	$resData = array();
	
	// если значение не найдено,то добавляем
	if(isset($_SESSION['cart']) && array_search($itemId, $_SESSION['cart']) === false) {
		$_SESSION['cart'][] = $itemId;
		$resData['cntItems'] = count($_SESSION['cart']);
		$resData['success'] = 1;
	} else {
		$resData['success'] = 0;
	} 
	echo json_encode($resData);
}

// Удаление продуктов из корзины
// integer id get параметр-id удаляемого продукта
//return json инфор-ция об опер-ции (успех,кол-во элем-ов в корзине)

function removefromcartAction() {
	$itemId = isset($_GET['id']) ? intval($_GET['id']) : null;
	if(! $itemId) exit();
	
	$resData = array();
	$key = array_search($itemId, $_SESSION['cart']);
	if ($key !== false){
		unset($_SESSION['cart'][$key]);
		$resData['success'] = 1;
		$resData['cntItems'] = count($_SESSION['cart']);		
	} else {
		$resData['success'] = 0;
	}
	echo json_encode($resData);
}

// Формирование страницы корзины
function indexAction($smarty) {
	
	$itemsIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
	
	$rsCategories = getAllMainCatsWithChildren();
	$rsProducts = getProductsFromArray($itemsIds);
	
	$smarty->assign('pageTitle', 'Корзина');
	$smarty->assign('rsCategories', $rsCategories);
	$smarty->assign('rsProducts', $rsProducts);
	
	loadTemplate($smarty, 'header');
	loadTemplate($smarty, 'cart');
	loadTemplate($smarty, 'footer');
}