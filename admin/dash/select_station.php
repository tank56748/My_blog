<?php if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'): ?>
	<?php if($_POST['action'] == 'visible_rasp'): ?>
		<?php
		$from = 's9601338';
		$to = 's9601666';
		if(isset($_POST['fromto'])) {
			$from = $_POST['from'];
			$to = $_POST['to'];
		}
		?>
		<?php if($from == $to): ?>
			<?php echo "Станции должны быть разными!";?>
		<?php else: ?>
			<?php
			$date_rasp = date('o-m-d');
			$query = http_build_query(['apikey' => "235b1eb4-307a-4fb9-9f84-0cb605e76bcd", 'from' => "$from", 'to' => "$to", 'limit' => '200', 'date' => "$date_rasp"]);
			$url = "https://api.rasp.yandex.net/v3.0/search/?".$query;
			$rasp_json = file_get_contents($url);
			$rasp = json_decode($rasp_json, true);
			$rasp_list = $rasp['segments'];
			?>
			<div class="search-title" style="text-align:center; font-size:25px; margin-bottom:15px"><?=$rasp_list[0]['from']['title']?> - <?=$rasp_list[0]['to']['title']?></div>
				<? $i = 0; ?>
				<? foreach($rasp_list as $sub_train => $train_info): ?>
					<?$dep_unixtime = strtotime($train_info['departure']);?>
					<?if($dep_unixtime >= time() && $dep_unixtime < (time() + 60 * 60 * 3)):?>
						<?if($i > 9){break;}
							preg_match('/\w{2}:\w{2}/', $train_info['departure'], $found_dep);
							preg_match('/\w{2}:\w{2}/', $train_info['arrival'], $found_arriv);
						?>
						<div id="time<?=$i?>" class="train_time">
							<div><span style="font-weight: bold;"><?=$found_dep[0] . ' - ' . $found_arriv[0]?></span></div>
						</div>
						<div id="info<?=$i?>" class="train_info hidden" style="text-align:center; margin-bottom:9px;">
							<div style="margin-bottom:8px"><span style="font-weight: bold;"><?=$found_dep[0] . ' - ' . $found_arriv[0]?></span></div>
							<div style="font-weight: bold; margin-bottom:8px"><?=$train_info['thread']['short_title']?></div>
							<div><?=$train_info['thread']['transport_subtype']['title']?></div>
						</div>
						<script>$('#time<?=$i?>').hover(function(){$('#info<?=$i?>').toggle()});</script>
							<?$i++;?>
						<?endif;?>
				<?endforeach;?>
				<? if($i == 0) {
					echo '<div style="text-align:center; margin-bottom:9px;">' . 'Нет поездов' . '</div>';
				} ?>
		<?php endif; ?>
	<?php elseif($_POST['action'] == 'full_rasp'): ?>
		<?php
		$from = 's9601338';
		$to = 's9601666';
		if(isset($_POST['fromto'])) {
			$from = $_POST['from'];
			$to = $_POST['to'];
		}
		?>
		<?php if($from == $to): ?>
			<?php echo "Станции должны быть разными!";?>
		<?php else: ?>
			<?php
			$date_rasp = date('o-m-d');
			$query = http_build_query(['apikey' => "235b1eb4-307a-4fb9-9f84-0cb605e76bcd", 'from' => "$from", 'to' => "$to", 'limit' => '200', 'date' => "$date_rasp"]);
			$url = "https://api.rasp.yandex.net/v3.0/search/?".$query;
			$rasp_json = file_get_contents($url);
			$rasp = json_decode($rasp_json, true);
			$rasp_list = $rasp['segments'];
			?>
			<div style="position: absolute;top: 50px;right: 4%;display: flex;width: 92%;background: white;height: 788px;flex-flow: column wrap;border-radius: 5px;padding: 15px 0px 10px 0; overflow:scroll" >
				<? foreach($rasp_list as $sub_train => $train_info): ?>
					<?preg_match('/\w{2}:\w{2}/', $train_info['departure'], $found_dep);
					preg_match('/\w{2}:\w{2}/', $train_info['arrival'], $found_arriv);?>
					<div class="time-info_item">
						<div id="time<?=$i?>" style="margin-bottom: 0px;font-size: 19px;" class="train_time">
							<div><span style="font-weight: bold;"><?=$found_dep[0] . ' - ' . $found_arriv[0]?></span></div>
						</div>
						<div style="text-align:center; font-size: 11px;"><?=$train_info['thread']['short_title']?></div>
					</div>
				<? endforeach; ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
<? else: ?>
	<? echo "Ошибка доступа"; ?>
<? endif; ?>


