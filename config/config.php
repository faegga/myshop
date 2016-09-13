<?php
	// Константы для обращения к контроллерам
	define ('PathPrefix', '../controllers/');
	define ('PathPostfix', 'Controller.php');

	// используемый шаблон
	$template = 'default';
	$templateAdmin = 'admin';
	
	// пути к файлам шаблонов (*.tpl)
	define ('TemplatePrefix', "../views/{$template}/");
	define ('TemplateAdminPrefix', "../views/{$templateAdmin}/");
	define ('TemplatePostfix', '.tpl');
	
	// пути к файлам шаблона в вебе
	define ('TemplateWebPath', "/templates/{$template}/");
	define ('TemplateAdminWebPath', "/templates/{$templateAdmin}/");
	
	// Инициализация Smarty-to Smarty.class.php
	require ('../library/Smarty/libs/Smarty.class.php');
	$smarty = new Smarty();
	
	$smarty->setTemplateDir(TemplatePrefix);
	$smarty->setCompileDir('../tmp/smarty/templates_c');
	$smarty->setCacheDir('../tmp/smarty/cache');
	$smarty->setConfigDir('../library/Smarty/configs');
	
	$smarty->assign('templateWebPath', TemplateWebPath);
	