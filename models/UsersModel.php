<?php
// Модель для таблицы пользователей

// Регис-ция нового польз-теля

function registerNewUser ($email, $pwdMD5, $name, $phone, $adress)
{
	$email = htmlspecialchars(mysql_real_escape_string($email));
	$name = htmlspecialchars(mysql_real_escape_string($name));
	$phone = htmlspecialchars(mysql_real_escape_string($phone));
	$adress = htmlspecialchars(mysql_real_escape_string($adress));
	
	$sql = "INSERT INTO users (`email`, `pwd`, `name`, `phone`, `adress`)
	VALUES ('{$email}', '{$pwdMD5}', '{$name}', '{$phone}', '{$adress}')";
	
	$rs = mysql_query($sql);
	
	if($rs){
		$sql = "SELECT * FROM users WHERE (`email` = '{$email}' and `pwd` = '{$pwdMD5}')
		LIMIT 1";
		
	$rs = mysql_query($sql);
	$rs = createSmartyRsArray($rs);
	
	if(isset($rs[0])){
		$rs['success'] = 1;
	}else {
		$rs['success'] = 0;
	}
	}else{
		$rs['success'] = 0;
	}
	
	return $rs;
}

// Проверка параметров пользователя
function checkRegisterParams($email, $pwd1, $pwd2)
{
	$res = null;
	if(! $email){
		$res['success'] = false;
		$res['message'] = 'Введите email';
	}
	if(! $pwd1){
		$res['success'] = false;
		$res['message'] = 'Введите пароль';
	}
	if(! $pwd2){
		$res['success'] = false;
		$res['message'] = 'Введите повтор пароля';
	}
	if($pwd1 !=$pwd2){
		$res['success'] = false;
		$res['message'] = 'Пароли не совпадают';
	}
	return $res;
}

// Проверка почты(есть ли email адрес в БД)
// string $email
// return array массив-строка из таблицы users, либо пустой массив
function checkUserEmail($email)
{
	$email = mysql_real_escape_string($email);
	$sql = "SELECT id FROM users WHERE email = '{$email}'";
	
	$rs = mysql_query($sql);
	$rs = createSmartyRsArray($rs);
	
	return $rs;
}

// Авторизация пользователя
function loginUser($email, $pwd)
{
	$email = htmlspecialchars(mysql_real_escape_string($email));
	$pwd   = md5($pwd);
	
	$sql = "SELECT * FROM users WHERE (`email` = '{$email}' and `pwd` ='{$pwd}')
	LIMIT 1";
	
	$rs = mysql_query($sql);
	
	$rs = createSmartyRsArray($rs);
	if(isset($rs[0])){
		$rs['success'] = 1;		
	} else {
		$rs['success'] = 0;
	}
	return $rs;
}