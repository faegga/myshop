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

// Формирование страницы заказа
function orderAction($smarty){
	// Получаем маасив идент-ов (id) продуктов корзины
	$itemsIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;
	// если корзина пуста то перенаправляем в корзину
	if(! $itemsIds){
		redirect('/cart/');
		return;
	}
	// получаем из массива $_POST кол-во покупаемых тов-ов
	$itemsCnt = array();
	foreach($itemsIds as $item){
	// формируем ключ для массива POST
	$postVar = 'itemCnt_' . $item;
	//создаём элемент массива кол-ва покупаемого товара
	// ключ массива - ID товара,значение массива-кол-во товара
	//$itemsCnt[1]=3; товар с ID == покупают 3 штуки
	$itemsCnt[$item] = isset($_POST[$postVar]) ? $_POST[$postVar] :null;
	}
//получаем список прод-ов по массиву корзины
	$rsProducts = getProductsFromArray($itemsIds);
	
/*добавляем каждому продукту дополнительное поле
"realPrice = кол-во продуктов * на цену продукта"
"cnt" = кол-во покупаемого товара

&$item - для того чтобы при изменении переменной 4item менялся и элемент массива $rsProducts*/
$i = 0;
foreach($rsProducts as &$item){
	$item['cnt'] = isset($itemsCnt[$item['id']]) ? $itemsCnt[$item['id']] : 0;
	if($item['cnt']){
		$item['realPrice'] = $item['cnt'] * $item['price'];
	}else {
		//если вдруг получилось так что товар в корзине есть,а кол-во == нулю,то удаляем этот товара
		unset($rsProducts[$i]);
		
	}
	$i++;
}
	if(! $rsProducts){
		echo "Корзина пуста";
		return;
	}
// полученный массив покупаемых товаров помещаем в сессионную переменную
	$_SESSION['saleCart'] = $rsProducts;
	
	$rsCategories = getAllMainCatsWithChildren();
	
	// hideLoginBox переменная-флаг для того чтобы спрятать блоки логина и рег-ции в боковой панели
		if(! isset($_SESSION['user'])){
			$smarty->assign('hideLoginBox', 1);
		}
	$smarty->assign('pageTitle', 'Заказ');
	$smarty->assign('rsCategories', $rsCategories);
	$smarty->assign('rsProducts', $rsProducts);
	
	loadTemplate($smarty, 'header');
	loadTemplate($smarty, 'order');
	loadTemplate($smarty, 'footer');
}