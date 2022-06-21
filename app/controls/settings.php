<?php

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['button-settings'])){
	$tech = $_POST['tech'];
	$settings = [
		'tech' => $tech,
	];
	update('settings', 1, $settings);
}
?>