<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . '/app/SxGeo/SxGeo.php');
$errMsg = [];
// Код для формы регистрации
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-reg'])){
	// $start = microtime(true);
	$login = trim($_POST['login']);
	$email = trim($_POST['email']);
	$pass1 = trim($_POST['password']);
	$pass = trim($_POST['password_2']);
	$admin = 0;
	$age = trim($_POST['age']);
	$gender = trim($_POST['gender']);
	$ip = $_SERVER['REMOTE_ADDR'];
	$SxGeo = new SxGeo('app/SxGeo/SxGeo.dat', SXGEO_BATCH | SXGEO_MEMORY);
	$country = $SxGeo->getCountry($ip);
	$SxGeoCity = new SxGeo('app/SxGeo/SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY);
	$city = $SxGeoCity->get($ip);
	$city_name = $city["city"]["name_en"];

	if($login === '' || $email === '' || $pass === '') array_push($errMsg, 'Не все поля заполнены!');
	if(mb_strlen($login, 'UTF8') < 3) array_push($errMsg, 'Логин должен быть более 2-х символов');
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) array_push($errMsg, "Email $email указан неверно");
	if($pass1 !== $pass) array_push($errMsg, 'Пароли не совпадают');
	if(strlen($pass1) < 5) array_push($errMsg, 'Пароль слишком короткий');
	if($age < 14 || $age > 100){
		if($age < 14){
			array_push($errMsg, 'Ты еще маленький, иди учи уроки :)');
		}elseif($age > 100){
			array_push($errMsg, 'Вы слишком старенький, идите отдыхать :)');
		}
	}
	if(empty($errMsg)){
		$existence_mail = selectOne('users', ['email' => $email]);
		$sql = "SELECT * FROM users WHERE username = '$login'";
		$query = $pdo->prepare($sql);
		$query->execute();
		$existence_login = $query->fetch();
		if($existence_mail['email'] === $email){
			array_push($errMsg, 'Введенный email уже существует');
		}elseif($existence_login['username'] === $login){
			array_push($errMsg, 'Введенный login уже существует');
		}
		else{
			$password = password_hash($pass, PASSWORD_DEFAULT);
			$user_reg = [
				"admin" => $admin,
				"username" => $login,
				"email" => $email,
				"password" => $password,
				"age" => $age,
				"gender" => $gender,
				"ip" => $ip,
				"country" => $country,
				"city" => $city_name,
			];
			$id = insert("users", $user_reg);
			$user = selectOne("users", ['id' => $id]);
			userAuth($user);

			//$errMsg = "<span style='color:#0ca71e'>Пользователь <strong>$login</strong> успешно зарегистрирован!</span>";
		}
	}

	// echo 'Время генерации: ' . ( microtime(true) - $start ) . ' сек.';
}else {
	$login = '';
	$email = '';
}

// Код для формы авторизации
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-log'])){
	$email = trim($_POST['email']);
	$pass1 = trim($_POST['password']);
	if($email === '' || $pass1 === '') {
		array_push($errMsg, 'Не все поля заполнены!');
	}else{
		$existence_mail = selectOne('users', ['email' => $email]);
		if($existence_mail && password_verify($pass1, $existence_mail['password'])){
			userAuth($existence_mail);
		}else{
			array_push($errMsg, 'Неверная почта или пароль');
			$_SESSION['FAIL_NUM']++;
			if($_SESSION['FAIL_NUM'] > 3){
				$_SESSION['FAIL_TIME'] = time();
			}
		}
	}
}else{
	$email = '';
}

// Создание пользователя В АДМИНКЕ

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-user-create'])){
	$login = trim($_POST['login']);
	$email = trim($_POST['email']);
	$pass1 = trim($_POST['password']);
	$pass = trim($_POST['password_2']);
	$admin = $_POST['admin'];
	$age = trim($_POST['age']);
	$gender = trim($_POST['gender']);
	$ip = $_SERVER['REMOTE_ADDR'];
	$SxGeo = new SxGeo('app/SxGeo/SxGeo.dat', SXGEO_BATCH | SXGEO_MEMORY);
	$country = $SxGeo->getCountry($ip);
	$SxGeoCity = new SxGeo('app/SxGeo/SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY);
	$city = $SxGeoCity->get($ip);
	$city_name = $city["city"]["name_en"];


	if($login === '' || $email === '' || $pass === '') array_push($errMsg, 'Не все поля заполнены!');
	if(mb_strlen($login, 'UTF8') < 3) array_push($errMsg, 'Логин должен быть более 2-х символов');
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) array_push($errMsg, "Email $email указан неверно");
	if($pass1 !== $pass) array_push($errMsg, "Пароли не совпадают");
	if(strlen($pass1) < 5) array_push($errMsg, "Пароль слишком короткий");
	if($age < 14 || $age > 100){
		if($age < 14){
			array_push($errMsg, "Ты еще маленький, иди учи уроки :)");
		}elseif($age > 100){
			array_push($errMsg, "Вы слишком старенький, идите отдыхать :)");
		}
	}
	if(empty($errMsg)){
		$existence_mail = selectOne('users', ['email' => $email]);
		$sql = "SELECT * FROM users WHERE username = '$login'";
		$query = $pdo->prepare($sql);
		$query->execute();
		$existence_login = $query->fetch();
		if($existence_mail['email'] === $email){
			array_push($errMsg, "Введенный email уже существует");
		}elseif($existence_login['username'] === $login){
			array_push($errMsg, "Введенный login уже существует");
		}
		else{
			$password = password_hash($pass, PASSWORD_DEFAULT);
			$user_create = [
				"admin" => $admin,
				"username" => $login,
				"email" => $email,
				"password" => $password,
				"age" => $age,
				"gender" => $gender,
				"ip" => $ip,
				"country" => $country,
				"city" => $city_name,
			];
			insert("users", $user_create);
			header('location: ' . $http . $_SERVER['SERVER_NAME'] . '?page=ADM_users_index');
		}
	}
}

// Редактирование пользователя В АДМИНКЕ
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_user'])){
	$user = selectOne('users', ['id' => $_GET['id_user']]);
	$id = $user['id'];
	$admin = $user['admin'];
	$username = $user['username'];
	$email = $user['email'];
	$age = $user['age'];
	$gender = $user['gender'];
	$ip = $user['ip'];
	$country = $user['country'];
	$city = $user['city'];
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-user-update'])){
	$username = trim($_POST['login']);
	$email = trim($_POST['email']);
	if(!empty($_POST['password'])){
		$pass1 = trim($_POST['password']);
		$pass = trim($_POST['password_2']);
		if($pass1 !== $pass) array_push($errMsg, "Пароли не совпадают");
		if(strlen($pass1) < 5) array_push($errMsg, "Пароль слишком короткий");
	}
	$admin = $_POST['admin'];
	$age = trim($_POST['age']);
	$gender = trim($_POST['gender']);

	if($username === '' || $email === '') array_push($errMsg, "Не все поля заполнены!");
	if(mb_strlen($username, 'UTF8') < 3) array_push($errMsg, "Логин должен быть более 2-х символов");
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) array_push($errMsg, "Email $email указан неверно");
	if($age < 14 || $age > 100){
		if($age < 14){
			array_push($errMsg, "Ты еще маленький, иди учи уроки :)");
		}elseif($age > 100){
			array_push($errMsg, "Вы слишком старенький, идите отдыхать :)");
		}
	}
	if(empty($errMsg)){
		global $pdo;
		$user = selectOne('users', ['username' => $username]);
		$id = $_GET['id_user'];
		$sql = "SELECT * FROM users WHERE email = '$email'";
		$query = $pdo->prepare($sql);
		$query->execute();
		$existence_mail = $query->fetch();

		$sql = "SELECT * FROM users WHERE username = '$username'";
		$query = $pdo->prepare($sql);
		$query->execute();
		$existence_login = $query->fetch();

		if($existence_mail['email'] == $email && $existence_mail['id'] != $id){
			array_push($errMsg, "Введенный email уже существует");
		}
		if($existence_login['username'] == $username && $existence_login['id'] != $id){
			array_push($errMsg, "Введенный login уже существует");
		}
		if(empty($errMsg)){
			if(!empty($pass)){
				$password = password_hash($pass, PASSWORD_DEFAULT);
				$p2 = "$password";
			}else{
				$p2 = $user['password'];
			}
			$user_edit = [
				"admin"=> $admin,
				"username" => $username,
				"email" => $email,
				"age" => $age,
				"gender" => $gender,
				"password" => $p2
			];
			update('users', 86, $user_edit);
			header('location: ' . $http . $_SERVER['SERVER_NAME'] . '?page=ADM_users_index');
		}
	}
}



$country_index = array ( 'AC' =>'остров Вознесения', 'AD' => 'Андорра', 'AE' => 'Объединенные Арабские Эмираты', 'AF' => 'Афганистан', 'AG' => 'Антигуа и Барбуда', 'AI' => '', 'AL' => 'Албания', 'AM' => 'Армения', 'AN' => 'Голланские Антильские острова', 'AO' => 'Ангола', 'AQ' => 'Антарктика', 'AR' => 'Аргентина', 'AS' => 'Американское Самоа', 'AT' => 'Австрия', 'AU' => 'Австралия', 'AW' => 'Аруба', 'AX' => 'Аландские острова', 'AZ' => 'Азербайджан', 'BA' => 'Босния и Герцеговина', 'BB' => 'Барбадос', 'BD' => 'Бангладеш', 'BE' => 'Бельгия', 'BF' => 'Буркина-Фасо', 'BG' => 'Болгария', 'BH' => 'Бахрейн', 'BI' => 'Бурунди', 'BJ' => 'Бенин', 'BM' => 'Бермудские острова', 'BN' => 'Бруней', 'BO' => 'Боливия', 'BR' => 'Бразилия', 'BS' => 'Багамские острова', 'BT' => 'Бутан', 'BV' => '', 'BW' => 'Ботсвана', 'BY' => 'Беларусь', 'BZ' => 'Белиз', 'CA' => 'Канада', 'CC' => 'Кокосовые острова', 'CD' => 'Конго', 'CF' => 'Центральноафриканская Республика', 'CG' => 'Конго', 'CH' => 'Швейцария', 'CI' => 'Кот-дИвуар', 'CK' => 'острова Кука', 'CL' => 'Чили', 'CM' => 'Камерун', 'CN' => 'Китай', 'CO' => 'Колумбия', 'CR' => 'Коста-Рика', 'CS' => 'Сербия и Черногория', 'CU' => 'Куба', 'CV' => 'Кабо-Верде', 'CX' => 'остров Рождества', 'CY' => 'Кипр', 'CZ' => 'Чехия', 'DE' => 'Германия', 'DJ' => 'Джибути', 'DK' => 'Дания', 'DM' => 'Доминика', 'DO' => 'Доминиканская Республика', 'DZ' => 'Алжир', 'EC' => 'Эквадор', 'EE' => 'Эстония', 'EG' => 'Египет', 'EH' => 'Западная Сахара', 'ER' => 'Эритрея', 'ES' => 'Испания', 'ET' => 'Эфиопия', 'FI' => 'Финляндия', 'FJ' => 'Фиджи', 'FK' => 'Фолклендские острова', 'FM' => 'Микронезия', 'FO' => 'Фарерские острова', 'FR' => 'Франция', 'GA' => 'Габон', 'GB' => 'Соединенное Королевство Великобритании и Северной Ирландии', 'GD' => 'Гренада', 'GE' => 'Грузия', 'GF' => 'Французская Гвиана', 'GG' => 'остров Гернси', 'GH' => 'Гана', 'GI' => 'Гибралтар', 'GL' => 'Гренландия', 'GM' => 'Гамбия', 'GN' => 'Гвинея', 'GP' => 'Гваделупа', 'GQ' => 'Экваториальная Гвинея', 'GR' => 'Греция', 'GS' => 'Южная Джорджия и Южные Сандвичевы острова', 'GT' => 'Гватемала', 'GU' => 'Гуам', 'GW' => 'Гвинея-Бисау', 'GY' => 'Гайана', 'HK' => 'Гонконг', 'HM' => '', 'HN' => 'Гондурас', 'HR' => 'Хорватия', 'HT' => 'Гаити', 'HU' => 'Венгрия', 'ID' => 'Индонезия', 'IE' => 'Ирландия', 'IL' => 'Израиль', 'IM' => 'остров Мэн', 'IN' => 'Индия', 'IO' => '', 'IQ' => 'Ирак', 'IR' => 'Иран', 'IS' => 'Исландия', 'IT' => 'Италия', 'JE' => 'остров Джерси', 'JM' => 'Ямайка', 'JO' => 'Иордания', 'JP' => 'Япония', 'KE' => 'Кения', 'KG' => 'Кыргызстан', 'KH' => 'Камбоджа', 'KI' => 'Кирибати', 'KM' => 'Коморские острова', 'KN' => 'Сент-Китс и Невис', 'KP' => 'Северная Корея', 'KR' => 'Южная Корея', 'KW' => 'Кувейт', 'KY' => 'Каймановы острова', 'KZ' => 'Казахстан', 'LA' => 'Лаос', 'LB' => 'Ливан', 'LC' => 'Сент-Люсия', 'LI' => 'Лихтенштейн', 'LK' => 'Шри-Ланка', 'LR' => 'Либерия', 'LS' => 'Лесото', 'LT' => 'Литва', 'LU' => 'Люксембург', 'LV' => 'Латвия', 'LY' => 'Ливия', 'MA' => 'Марокко', 'MC' => 'Монако', 'ME' => 'Монтенегро', 'MD' => 'Молдова', 'MG' => 'Мадагаскар', 'MH' => 'Маршалловы острова', 'MK' => 'Македония', 'ML' => 'Мали', 'MM' => 'Мьянма', 'MN' => 'Монголия', 'MO' => 'Макао', 'MP' => 'Mariana  Северные Марианские острова', 'MQ' => 'Мартиника', 'MR' => 'Мавритания', 'MS' => 'Монтсеррат', 'MT' => 'Мальта', 'MU' => 'Маврикий', 'MV' => 'Мальдивы', 'MW' => 'Малави', 'MX' => 'Мексика', 'MY' => 'Малайзия', 'MZ' => 'Мозамбик', 'NA' => 'Намибия', 'NC' => 'Новая Каледония', 'NE' => 'Нигер', 'NF' => 'Норфолк', 'NG' => 'Нигерия', 'NI' => 'Никарагуа', 'NL' => 'Нидерланды', 'NO' => 'Норвегия', 'NP' => 'Непал', 'NR' => 'Науру', 'NU' => '', 'NZ' => 'Новая Зеландия', 'OM' => 'Оман', 'PA' => 'Панама', 'PE' => 'Перу', 'PF' => 'Французская Полинезия', 'PG' => 'Папуа - Новая Гвинея', 'PH' => 'Филиппины', 'PK' => 'Пакистан', 'PL' => 'Польша', 'PM' => 'Сен-Пьер и Микелон', 'PN' => 'остров Питкэрн', 'PR' => 'Пуэрто-Рико', 'PS' => 'Палестина', 'PT' => 'Португалия', 'PW' => 'Палау', 'PY' => 'Парагвай', 'QA' => 'Катар', 'RE' => 'остров Реюньон', 'RO' => 'Румыния', 'RU' => 'Россия', 'RW' => 'Руанда', 'SA' => 'Саудовская Аравия', 'SB' => 'Соломоновы Острова', 'SC' => 'Сейшельские Острова', 'SD' => 'Судан', 'SE' => 'Швеция', 'SG' => 'Сингапур', 'SH' => 'остров Святой Елены', 'SI' => 'Словения', 'SJ' => '', 'SK' => 'Словакия', 'SL' => 'Сьерра-Леоне', 'SM' => 'Сан-Марино', 'SN' => 'Сенегал', 'SO' => 'Сомали', 'SR' => 'Суринам', 'ST' => 'Сан-Томе и Принсипи', 'SU' => 'СССР', 'SV' => 'Сальвадор', 'SY' => 'Сирия', 'SZ' => 'Свазиленд', 'TC' => '', 'TD' => 'Чад', 'TF' => '', 'TG' => 'Того', 'TH' => 'Таиланд', 'TJ' => 'Таджикистан', 'TK' => 'Токелау', 'TL' => '-', 'TM' => 'Туркменистан', 'TN' => 'Тунис', 'TO' => 'Тонга', 'TP' => 'Восточный Тимор', 'TR' => 'Турция', 'TT' => 'Тринидад и Тобаго', 'TV' => 'Тувалу', 'TW' => 'Тайвань', 'TZ' => 'Танзания', 'UA' => 'Украина', 'UG' => 'Уганда', 'UK' => 'Соединенное Королевство Великобритании и Северной Ирландии', 'UM' => '', 'US' => 'США', 'UY' => 'Уругвай', 'UZ' => 'Узбекистан', 'VA' => 'Ватикан', 'VC' => 'Сент-Винсент и Гренадины', 'VE' => 'Венесуэла', 'VG' => 'Виргинские острова, Британские', 'VI' => 'Виргинские острова, США', 'VN' => 'Вьетнам', 'VU' => 'Вануату', 'WF' => '', 'WS' => 'Западное Самоа', 'YE' => 'Йемен', 'YT' => '', 'YU' => 'Югославия', 'ZA' => 'ЮАР', 'ZM' => 'Замбия', 'ZW' => 'Зимбабве' );
$admin_index = ["1" => "Админ", "0" => "Пользователь"];

?>