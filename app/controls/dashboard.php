<?php


// Яндекс погода ///////////////////////////////////////////////////////////
require_once ($_SERVER['DOCUMENT_ROOT'] . '/app/SxGeo/SxGeo.php');
$ip = $_SERVER['REMOTE_ADDR'];
$SxGeoCity = new SxGeo('app/SxGeo/SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY);
$city = $SxGeoCity->get($ip);
$lat = $city['city']['lat'];
$lon = $city['city']['lon'];

$opts = ['http' => ['method' => "GET", 'header' => "X-Yandex-API-Key:810af9b8-420d-47d9-a121-40dfba8907ec"."\r\n"]];
$context = stream_context_create($opts);
$wheather_json = file_get_contents("https://api.weather.yandex.ru/v2/forecast/?lat=$lat&lon=$lon&lang=ru_RU&hours=false", false, $context);
$wheather = json_decode($wheather_json, true);
$geo = $wheather['geo_object'];
$fact = $wheather['fact'];
$forecasts = $wheather['forecasts'];

$condition = [
	'clear' => 'Ясно',
	'partly-cloudy' => 'малооблачно',
	'cloudy' => 'облачно с прояснениями',
	'overcast' => 'пасмурно',
	'drizzle' => 'морось',
	'light-rain' => 'небольшой дождь',
	'rain' => 'дождь',
	'moderate-rain' => 'умеренно сильный дождь',
	'heavy-rain' => 'сильный дождь',
	'continuous-heavy-rain' => 'длительный сильный дождь',
	'showers' => 'Ливень',
	'wet-snow' => 'дождь со снегом',
	'light-snow' => 'небольшой снег',
	'snow' => 'снег',
	'snow-showers' => 'снегопад',
	'hail' => 'град',
	'thunderstorm' => 'гроза',
	'thunderstorm-with-rain' => 'дождь с грозой',
	'thunderstorm-with-hail' => 'гроза с градом'
];

$wind_dirs = [
	'nw' => 'северо-западное',
	'n' => 'северное',
	'ne' => 'северо-восточное',
	'e' => 'восточное',
	'se' => 'юго-восточное',
	's' => 'южное',
	'sw' => 'юго-западное',
	'w' => 'западное',
	'с' => 'штиль',
];

$moon_fases = [
	'moon-code-0' => 'полнолуние',
	'moon-code-1' => 'убывающая луна',
	'moon-code-2' => 'убывающая луна',
	'moon-code-3' => 'убывающая луна',
	'moon-code-4' => 'последняя четверть',
	'moon-code-5' => 'убывающая луна',
	'moon-code-6' => 'убывающая луна',
	'moon-code-7' => 'убывающая луна',
	'moon-code-8' => 'новолуние',
	'moon-code-9' => 'растущая луна',
	'moon-code-10' => 'растущая луна',
	'moon-code-11' => 'растущая луна',
	'moon-code-12' => 'первая четверть',
	'moon-code-13' => 'растущая луна',
	'moon-code-14' => 'растущая луна',
	'moon-code-15' => 'растущая луна',
];


// Яндекс расписание //////////////////////////////////////////////////////////

/*$query2 = http_build_query(array('apikey'=>"235b1eb4-307a-4fb9-9f84-0cb605e76bcd", 'from'=>"s2000009", 'to' => 's9600686', 'limit' => '200'));
$url2 = "https://api.rasp.yandex.net/v3.0/search/?" . $query2;
$rasp_json6 = file_get_contents($url2);
$rasp6 = json_decode($rasp_json6, true);
$query = http_build_query(array('apikey'=>"235b1eb4-307a-4fb9-9f84-0cb605e76bcd", 'uid'=>"6804_0_2000003_g22_4", 'format' => 'json'));
$url = "https://api.rasp.yandex.net/v3.0/thread/?" . $query;
$stations_json1 = file_get_contents($url);
$stations1 = json_decode($stations_json1, true);
$arr_stations = [];
foreach($stations1["stops"] as $value){
	$arr_stations += [$value['station']['code'] => $value['station']['title']];
}*/













