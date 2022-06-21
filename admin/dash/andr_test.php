<?
$t1 = microtime();
$a = file_get_contents('https://api.rasp.yandex.net/v3.0/search/?apikey=235b1eb4-307a-4fb9-9f84-0cb605e76bcd&from=s9601338&to=s9601666&date=2022-06-18');
$r = json_decode($a, true);
$t2 = microtime();

echo 'Расписание '.$r['segments'][0]['from']['title'].' - '.$r['segments'][0]['from']['title'].'<br><br>';

for($i = 0; $i < count($r['segments']); $i++){
	echo date('d-m-Y h:i:s', strtotime($r['segments'][$i]['arrival'])).' - '.date('d-m-Y h:i:s', strtotime($r['segments'][$i]['departure'])).'<br>';

}

$t3 = microtime();

echo '<br><br><br><br>t1: '.($t2 - $t1).'<br>';
echo 't2: '.($t3 - $t1);
?>