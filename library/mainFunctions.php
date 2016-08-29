<?php

	function loadPage ($smarty, $controllerName, $actionName ='index'){
		
		include_once PathPrefix . $controllerName . PathPostfix;
		
		$function = $actionName . 'Action';
		$function($smarty);
	}
	
	// загрузка шаблона object smarty+название шаблона
	function loadTemplate($smarty, $templateName)
	{
		$smarty->display($templateName . TemplatePostfix);
	}
	
	// функция отладки
	function d($value = null, $die = 1)
	{
		echo 'Debug: <br /><pre>';
		print_r($value);
		echo '</pre>';
		
		if($die) die;
	}
	
// Преобразование функции выборки в ассоциативный массив recordset $rs набор строк рез-тат SELECT
	function createSmartyRsArray($rs)
	{
		if(! $rs) return false;
		
		$smartyRs =array();
		while ($row = mysql_fetch_assoc($rs)) {
			$smartyRs[] = $row;
		}
		
		return $smartyRs;
	}

	// Редирект
	function redirect($url)
	{
		if(! $url) $url = '/';
		header("Location: {$url}");
		exit;
	}