<?php
// Контроллер страницы товара

// Подключаем модели
	include_once '../models/ProductsModel.php';
	include_once '../models/CategoriesModel.php';

 //Формирование страницы продукта
 
	 function indexAction($smarty) {
	 $itemId = isset($_GET['id']) ? $_GET['id'] : null;
	 if($itemId == null) exit();
 
 // Получить данные продукта
	 $rsProduct =  getProductById($itemId);
	 
 // Получить все категории
	 $rsCategories = getAllMainCatsWithChildren();
	 
	 $smarty->assign('pageTitle', '');
	 $smarty->assign('rsCategories', $rsCategories);
	 $smarty->assign('rsProduct', $rsProduct);
	 
	 loadTemplate($smarty, 'header');
	 loadTemplate($smarty, 'product');
	 loadTemplate($smarty, 'footer');
 }
