


	<?php include($_SERVER['DOCUMENT_ROOT'].'/app/controls/dashboard.php'); ?>
	<main>
		<?php include($_SERVER['DOCUMENT_ROOT'].'/app/include/aside_admin.php'); ?>
		<div style="display:flex; flex-wrap:wrap;" class="posts">
			<!--Виджет погода-->
			<div style="width:33%;">
				<!--Прогноз-->
				<div class="wheather_click search section"
					 style="display:flex; justify-content:center; align-items:center; height:10px; width:100%">
					<div>Прогноз</div>
				</div>
				<div style="position:absolute; top:129px; right:14%; width:75%;" class="a hidden">
					<div style="border-radius: 80px;" class="search section forecasts hidden" id="hidden_wheather">
						<?php foreach($forecasts as $day => $day_info): ?>
							<?php if($day != 0): ?>
								<div>
									<div id="days_date" style="text-align:center;font-size:20px; margin:15px 0;"><?php echo date('d F Y', strtotime($day_info['date']))?></div>
									<div class="wheather_days_icons" style="display:flex; flex-direction: column; justify-content:center; align-items:center">
										<div style="display:flex; justify-content:space-evenly;">
											<div>
												<div class="wheather_days_time">Ночь</div>
												<div style="display:flex; justify-content:center; align-items:center;">
													<div>
														<img style="height:50px"
															 src="https://yastatic.net/weather/i/icons/funky/dark/<?=$day_info['parts']['night']['icon']?>.svg">
													</div>
													<div><?=$day_info['parts']['night']['temp_avg']?> &deg;C</div>
												</div>
											</div>
											<div>
												<div class="wheather_days_time">Утро</div>
												<div style="display:flex; justify-content:center; align-items:center;">
													<div>
														<img style="height:50px"
															 src="https://yastatic.net/weather/i/icons/funky/dark/<?=$day_info['parts']['morning']['icon']?>.svg">
													</div>
													<div><?=$day_info['parts']['morning']['temp_avg']?> &deg;C</div>
												</div>
											</div>
										</div>
										<div style="display:flex">
											<div>
												<div class="wheather_days_time">День</div>
												<div style="display:flex; justify-content:center; align-items:center;">
													<div>
														<img style="height:50px"
															 src="https://yastatic.net/weather/i/icons/funky/dark/<?=$day_info['parts']['day']['icon']?>.svg">
													</div>
													<div><?=$day_info['parts']['day']['temp_avg']?> &deg;C</div>
												</div>
											</div>
											<div>
												<div class="wheather_days_time">Вечер</div>
												<div style="display:flex; justify-content:center; align-items:center;">
													<div>
														<img style="height:50px"
															 src="https://yastatic.net/weather/i/icons/funky/dark/<?=$day_info['parts']['evening']['icon']?>.svg">
													</div>
													<div><?=$day_info['parts']['evening']['temp_avg']?> &deg;C</div>
												</div>
											</div>
										</div>

									</div>
									<div style="text-align:center"><b><?=$condition[$day_info['parts']['day']['condition']]?></b></div>
									<div class="wheather_item" style="text-align:center">Скорость ветра: <?=$day_info['parts']['day']['wind_speed']?> м/с</div>
									<div class="wheather_item" style="text-align:center">Направление ветра: <?=$wind_dirs[$day_info['parts']['day']['wind_dir']]?></div>
									<div class="wheather_item" style="text-align:center">Влажность: <?=$day_info['parts']['day']['humidity']?> %</div>
									<div class="wheather_item" style="text-align:center">Фаза луны: <?=$moon_fases[$day_info['moon_text']]?></div>
								</div>
							<? endif; ?>
						<? endforeach; ?>
					</div>
				</div>
				<!--Прогноз-->

				<!--Погода сейчас-->
				<div class="search section wheather">
					<div>
						<?=$geo['locality']['name']?>
					</div>
					<div style="display:flex; padding-top:5px">
						<div>
							<img style="height:50px"
								 src="https://yastatic.net/weather/i/icons/funky/dark/<?=$fact['icon']?>.svg">
						</div>
						<div class="temp_now" style="font-size:42px;margin-left: 10px; display:flex; align-items:center">
							<div><?=$fact['temp']?> &deg;C</div>
						</div>
					</div>
					<div class="condition_now" style="font-size: 22px; margin-bottom: 10px;">
						<?
						$type_wheather = $fact['condition'];
						echo $condition[$type_wheather];
						?>
					</div>
					<div class="wheather_item">
						Скорость ветра: <?=$fact['wind_speed']?> м/с
					</div>
					<div class="wheather_item">

						<?$wind_dir_letter = $fact['wind_dir'];?>
						Направление ветра: <?=$wind_dirs[$wind_dir_letter]?>
					</div class="wheather_item">
					<div class="wheather_item">
						Влажность: <?=$fact['humidity']?> %
					</div>
					<div class="wheather_item">
						Рассвет: <?=$forecasts['0']['sunrise']?>
					</div class="wheather_item">
					<div class="wheather_item">
						Закат: <?=$forecasts['0']['sunset']?>
					</div>
					<div class="wheather_item">
						<?
						$moon_fase_code = $forecasts['0']['moon_text'];
						$moon_fase = $moon_fases[$moon_fase_code];
						?>
						Фаза луны: <?=$moon_fase?>
					</div>
					<div class="today_wheather_parts" style="display:flex">
						<div>
							<div>Ночь</div>
							<div style="display:flex">
								<div><img src="https://yastatic.net/weather/i/icons/funky/dark/<?=$forecasts[0]['parts']['night']['icon']?>.svg"></div>
								<div style="display:flex; align-items:center"><span><?=$forecasts[0]['parts']['night']['temp_avg']?> &deg;C</span></div>
							</div>
						</div>
						<div>
							<div>Утро</div>
							<div style="display:flex">
								<div><img src="https://yastatic.net/weather/i/icons/funky/dark/<?=$forecasts[0]['parts']['morning']['icon']?>.svg"></div>
								<div style="display:flex; align-items:center"><span><?=$forecasts[0]['parts']['morning']['temp_avg']?> &deg;C</span></div>
							</div>
						</div>
						<div>
							<div>День</div>
							<div style="display:flex">
								<div><img src="https://yastatic.net/weather/i/icons/funky/dark/<?=$forecasts[0]['parts']['day']['icon']?>.svg"></div>
								<div style="display:flex; align-items:center"><span><?=$forecasts[0]['parts']['day']['temp_avg']?> &deg;C</span></div>
							</div>
						</div>
						<div>
							<div>Вечер</div>
							<div style="display:flex">
								<div><img src="https://yastatic.net/weather/i/icons/funky/dark/<?=$forecasts[0]['parts']['evening']['icon']?>.svg"></div>
								<div style="display:flex; align-items:center"><span><?=$forecasts[0]['parts']['evening']['temp_avg']?> &deg;C</span></div>
							</div>
						</div>
					</div>
				</div>
				<!--Погода сейчас-->
			</div>
			<!--Виджет погода-->

			<!--Виджет расписание-->
			<div style="width:33%;">
				<script>
					$.ajax({
						type: "POST",
						url: "admin/dash/select_direction.php",
						success: function (data){
							var resp = JSON.parse(data);
							for (var key in resp){
								$('.from').append(`<option value="${key}">${resp[key]}</option>`);
								$('.to').append(`<option value="${key}">${resp[key]}</option>`);
							}
						}
					});
					$.ajax({
						type: "POST",
						url: "admin/dash/select_station.php",
						data: {action:'visible_rasp'},
						success: function (data){
							$('.now-rasp').append(data);
						}
					});
					$.ajax({
						type: "POST",
						url: "admin/dash/select_station.php",
						data: {action:'full_rasp'},
						success: function (data){
							$('.c').append(data);
						}
					});
				</script>
				<div class="rasp_click search section"
					 style="display:flex; justify-content:center; align-items:center; height:10px;  width: 97%; margin-left: 10px">
					<div>Выбор станции</div>
				</div>
				<div style="position:absolute; top:129px; right:20%; width:32%;" class="b hidden">
					<div style="text-align:center; border: 12px outset;" class="search section wheather" id="hidden_wheather">
						<div style="text-align:center; font-size: 19px; margin-bottom:8px;">Направление</div>
						<div style="display:flex; justify-content:center">
							<select class="direction" style="font-size: 19px !important;margin-bottom:10px; width:50%;" name="direction">
								<option value="bel">Белорусское</option>
								<option value="kiev">Киевское</option>
								<option value="pavel">Павелецкое</option>
								<option value="kursk">Курское</option>
								<option value="gorkov">Горьковское</option>
								<option value="savel">Савеловское</option>
								<option value="rizh">Рижское</option>
								<option value="yaroslav">Ярославское</option>
								<option value="lenin">Ленинградское</option>
								<option value="kazan">Казанское</option>
								<option value="kazan2">Казанское-2</option>
							</select>
						</div>
						<div id="errMsg" style="color:red; text-align:center; font-size: 19px; margin-bottom:8px;"></div>
						<div style="display:flex">
							<div style="text-align:center; font-size: 19px; margin-bottom:8px; flex:1">Откуда:</div>
							<div style="text-align:center; font-size: 19px; margin-bottom:8px; flex:1">Куда:</div>
						</div>
						<select class="from" style="font-size: 19px !important; width:42%; height:39px; border: 1px solid #0f3483; border-radius: 6px;" name="from">
						</select>
						-
						<select class="to" style="font-size: 19px !important; width:42%; height:39px; border: 1px solid #0f3483; border-radius: 6px;" name="to">
						</select>
					</div>
				</div>
				<div style="margin-left:10px;" class="now-rasp search section">

				</div>
				<div class="full_click search section"
					 style="display:flex; justify-content:center; align-items:center; height:10px;  width: 97%; margin-left: 10px">
					<div>Полное расписание</div>
				</div>
				<div class="c hidden">

				</div>
			</div>
			<!--Виджет расписание-->

			<!--Виджет курсы-->
			<div style="width:33%">
				<div style="margin-left:10px;" class="search section">
					<div style="text-align:center; margin-bottom:25px">Курсы:</div>
					<?
					$sql = "SELECT * FROM crypto";
					global $pdo;
					$query_crypto = $pdo->prepare($sql);
					$query_crypto->execute();
					$crypto_arr = $query_crypto->fetchAll();
					?>
					<? foreach($crypto_arr as $currency => $currency_info): ?>
					<div style="text-align:center"><?=$currency_info['currency']?>: <?=$currency_info['USD']?>$  <?=$currency_info['RUB']?> руб.</div>
					<? endforeach; ?>
				</div>
			</div>
			<!--Виджет курсы-->
		</div>
	</main>

	<script>

		// AJAX

		$('.direction').change(function (){
			let dir = $('.direction option:selected').attr('value');
			$.ajax({
				type: "POST",
				url: "admin/dash/select_direction.php",
				data: {direction: dir},
				success: function (data){
					$(".from").empty();
					$(".to").empty();
					var resp = JSON.parse(data);
					for (var key in resp){
						$('.from').append(`<option value="${key}">${resp[key]}</option>`);
						$('.to').append(`<option value="${key}">${resp[key]}</option>`);
					}
				}
			});
		});

		$('.from, .to').change(function () {
			let dep = $('.from option:selected').attr('value');
			let arr = $('.to option:selected').attr('value');
			$.ajax({
				type: "POST",
				url: "admin/dash/select_station.php",
				data: {action: 'visible_rasp', fromto: 'change', from: dep, to: arr},
				success: function (data) {
					$("#errMsg").empty();
					if (data.includes('Станции должны быть разными!')){
						$("#errMsg").append(data);
					}else{
						let now_rasp = $(".now-rasp");
						now_rasp.empty();
						now_rasp.append(data);
					}
				}
			});
			$.ajax({
				type: "POST",
				url: "admin/dash/select_station.php",
				data: {action: 'full_rasp', fromto: 'change', from: dep, to: arr},
				success: function (data) {
					if (!data.includes('Станции должны быть разными!')){
						let c = $(".c");
						c.empty();
						c.append(data)
					}
				}
			});
		});


		$('.wheather_click').on('click', function(){
			$('.a').toggle()
		});
		$('.rasp_click').on('click', function(){
			$('.b').toggle()
		});
		$('.full_click').on('click', function(){
			$('.c').toggle()
		});
		$(document).mouseup(function (e) {
			var container = $(".a");
			if (container.has(e.target).length === 0){
				container.hide();
			}
		});
		$(document).mouseup(function (e) {
			var container1 = $(".b");
			if (container1.has(e.target).length === 0){
				container1.hide();
			}
		});
		$(document).mouseup(function (e) {
			var container2 = $(".c");
			if (container2.has(e.target).length === 0){
				container2.hide();
			}
		});

		<? if(isset($_POST['direction'])): ?>
		let el_direction = document.querySelector(".direction option[value='<?=$_POST['direction']?>']");
		el_direction.setAttribute('selected', '');
		<? endif; ?>
		<? if(isset($_POST['from'])): ?>
		let el_from = document.querySelector(".from option[value='<?=$_POST['from']?>']");
		el_from.setAttribute('selected', '');
		let el_to = document.querySelector(".to option[value='<?=$_POST['to']?>']");
		el_to.setAttribute('selected', '');
		<? endif; ?>

	</script>

<?php echo $forecasts['0']['date'];?>










