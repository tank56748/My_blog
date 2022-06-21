<?php if(count($errMsg)): ?>
	<ul style="display:flex; flex-wrap:wrap; list-style:none; color: #ef244a; font-weight: bold;">
	<? foreach($errMsg as $key => $value): ?>
		<li style="margin-right: 15px;"><? echo $value;if(count($errMsg) > 1){if(count($errMsg) - 1 == $key){echo ".";}else{echo ",";}}?></li>
<?php endforeach; ?>
	</ul>
<?php endif; ?>
