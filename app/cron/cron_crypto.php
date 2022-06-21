<?
include ("/var/www/qwert136/data/www/minebtc.ru".'/app/database/connect.php');
$crypto_json = file_get_contents('https://min-api.cryptocompare.com/data/price?fsym=BTC&tsyms=USD,RUB&api_key=52d5b28e4bb92174269c4ad936feea3da9fb957467a2c88cc45123717837795b');
$crypto = json_decode($crypto_json, true);
$usd = $crypto['USD'];
$rub = $crypto['RUB'];
global $pdo;
$sql = "UPDATE crypto SET USD = $usd, RUB = $rub WHERE id = 1";
$query = $pdo->prepare($sql);
$query->execute();
/*update('crypto', 1, ['USD' => $usd, 'RUB' => $rub]);*/
?>

