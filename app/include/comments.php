<?php
include ($_SERVER['DOCUMENT_ROOT'] . '/app/controls/commentaries.php');
?>


<select name="effects" id="effectTypes" class="ddl">
	<option value="blind">Blind</option>
	<option value="bounce">Bounce</option>
	<option value="clip">Clip</option>
	<option value="drop">Drop</option>
	<option value="explode">Explode</option>
	<option value="fold">Fold</option>
	<option value="highlight">Highlight</option>
	<option value="puff">Puff</option>
	<option value="pulsate">Pulsate</option>
	<option value="scale">Scale</option>
	<option value="shake">Shake</option>
	<option value="size">Size</option>
	<option value="slide">Slide</option>
</select>
<div style="width:100%; margin-top: 20px;" class="comment">
	<h3>Оставить комментарий</h3>
	<form style="margin-top: 15px;" action="<?="?page=single&id_post=$post_id"?>" method="post">
		<div class="form-item err">
			<? include $_SERVER['DOCUMENT_ROOT'] . "/app/include/error_info.php"?>
		</div>
		<div>
			<? if(isset($_SESSION['login'])): ?>
				<label for="">Ваше имя</label>
			<? else: ?>
				<label for="">Укажите ваш email</label>
			<? endif; ?>
			<input name="login" style="margin: 10px 0;" class="reg-input" <? if(isset($_SESSION['login'])){$sess_log = $_SESSION['login']; echo "value='$sess_log' "; echo "disabled";}?> <? if(isset($_SESSION['login'])){echo "type='text'";}else{echo "type='email'";}?>>
		</div>
		<div>
			<label for="">Напишите ваш отзыв</label>
			<textarea style="margin-top: 10px;margin-bottom: 10px;" class="reg-input" rows="5" minlength="7" name="comment"><?=$comment?></textarea>
		</div>
		<div>
			<button class="submit-btn1" name="button-comment" type="submit">Отправить</button>
		</div>
	</form>
</div>
<div style="margin-top: 35px; " class="comments">
	<?
	global $pdo;
	$sql = "SELECT * from comments WHERE id_post = $post_id ORDER BY id DESC";
	$query = $pdo->prepare($sql);
	$query->execute();
	dbCheckError($query);
	$All_comments = $query->fetchAll();
	?>
	<div style="display:flex; justify-content:space-between;">
		<h3 style="margin-bottom: 15px;">Комментарии  <span style="color:#4b8eab"><?=count($All_comments)?></span></h3>
		<div style="margin-right:10px"><i style="margin-right: 7px;" class="fas fa-eye"></i><?=$post['views'];?><i id="likes" style="cursor: pointer;margin-left: 10px; margin-right: 7px;" class="fa-heart"></i><span id="num_likes"><?=$post['likes'];?></span></div>
	</div>
		<?
		if(isset($_SESSION['id'])){
			$user_id = $_SESSION['id'];
			$sql = "SELECT * FROM likes_users WHERE id_user = $user_id AND id_post = $post_id";
			$query = $pdo->prepare($sql);
			$query->execute();
			$row = $query->rowCount();
		}
		?>
		<? if($row == 1): ?>
		<script>
			var like_icon = document.querySelector('#likes');
			like_icon.classList.add("fas");
		</script>
		<? elseif($row == 0 || !isset($_SESSION['id'])): ?>
		<script>
			var like_icon = document.querySelector('#likes');
			like_icon.classList.add("far");
		</script>
		<? endif; ?>
		<?
		$ip = $_SERVER['REMOTE_ADDR'];
		$sql = "SELECT * FROM views_posts WHERE ip = '$ip' AND id_post = $post_id";
		$query = $pdo->prepare($sql);
		$query->execute();
		$row = $query->rowCount();
		if($row == 0){
			insert('views_posts', ['ip' => $ip, 'id_post' => $post_id]);
			$sql = "UPDATE posts SET views = views + 1 WHERE id = $post_id";
			$query = $pdo->prepare($sql);
			$query->execute();
		}
		?>
	<hr>
	<? foreach($All_comments as $number => $comment): ?>
	<div style="margin: 20px 0;" class="one-comment">
		<div style="display:flex;justify-content: space-between;">
			<i style="margin-left: 11px;" class="far fa-user"> <?=$comment['login']?></i>
			<i style="margin-right: 11px;" class="far fa-calendar"> <?=$comment['created_date']?></i>
		</div>
		<div style="background: white;margin-top: 15px;padding: 12px;border-radius: 7px;">
			<?=$comment['comment']?>
		</div>
	</div>
	<? endforeach; ?>
	<script>
		<? if(isset($_SESSION['id'])): ?>
		$('#likes').on('click', function (){
			var change;
			var remove;
			var id_user = <?=$_SESSION['id']?>;
			var id_post = <?=$post['id']?>;
			if ($(this).hasClass('far')){
				remove = function (){
					$(this).removeClass();
					$(this).addClass('fas fa-heart');
				}
				change = 1;
			}else if($(this).hasClass('fas')){
				change = 0;
				remove = function (){
					$(this).removeClass();
					$(this).addClass('far fa-heart');
				}
			}
			$.ajax({
				type: 'POST',
				url: 'app/ajax/comments_ajax.php',
				data: {action: 'likes', id_user:id_user, id_post:id_post, change: change},
				success: function (data){
					var like_icon = document.querySelector('#likes');
					var num_likes = document.querySelector('#num_likes');
					if (data.includes('ok1')){
						like_icon.classList.remove("far");
						like_icon.classList.add("fas");
						num_likes.textContent = +num_likes.textContent + 1;
					}else if (data.includes('ok2')){
						like_icon.classList.remove("fas");
						like_icon.classList.add("far");
						num_likes.textContent = num_likes.textContent - 1;
					}
				}
			})
		});
		<? endif; ?>
	</script>
</div>