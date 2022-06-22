<?php
include ($_SERVER['DOCUMENT_ROOT'] . '/app/controls/commentaries.php');
?>

<div style="width:100%; margin-top: 20px;" class="comment">
	<h3>Оставить комментарий</h3>
		<div style="margin-top:10px; color:red" class="form-item err">
		</div>
		<div>
			<? if(isset($_SESSION['login'])): ?>
				<label for="">Ваше имя</label>
			<? else: ?>
				<label for="">Укажите ваш email</label>
			<? endif; ?>
			<input id="login" name="login" style="margin: 10px 0;" class="reg-input" <? if(isset($_SESSION['login'])){$sess_log = $_SESSION['login']; echo "value='$sess_log' "; echo "disabled";}?> <? if(isset($_SESSION['login'])){echo "type='text'";}else{echo "type='email'";}?>>
		</div>
		<div>
			<label for="comment">Напишите ваш отзыв</label>
			<textarea id="comment" style="margin-top: 10px;margin-bottom: 10px;" class="reg-input" rows="5" minlength="7" name="comment"><?=$comment?></textarea>
		</div>
		<div>
			<button id="add_comm" class="submit-btn1" name="button-comment" type="submit">Отправить</button>
		</div>
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
		<h3 style="margin-bottom: 15px;">Комментарии  <span id="num_comm" style="color:#4b8eab"><?=count($All_comments)?></span></h3>
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
	<hr id="hr">
	<? foreach($All_comments as $number => $comment): ?>
	<div style="margin: 20px 0;" class="one-comment">
		<div style="display:flex;justify-content: space-between;">
			<i style="margin-left: 11px;" class="far fa-user"> <?=$comment['login']?></i>
			<span>
				<i style="margin-right: 11px;" class="far fa-calendar"> <?=$comment['created_date']?></i>
			<? if($_SESSION['admin'] == 1): ?>
				<i style="color:#cb0c0c; cursor:pointer" data="<?=$comment['id']?>" id="del_comm" class="fa-solid fa-circle-xmark"></i>
			<? endif; ?>
			</span>
		</div>
		<div style="background: white;margin-top: 15px;padding: 12px;border-radius: 7px;">
			<?=$comment['comment']?>
		</div>
	</div>
	<? endforeach; ?>
	<script>

		// Добавить комментарий
		$('#add_comm').on('click', function (){
			var comment = $('#comment').val();
			var login = $('#login').val();
			var post_id = <?=$_GET['id_post']?>;
			var session = <?if(isset($_SESSION['id'])){echo 1;}else{echo 0;}?>;
			$.ajax({
				type: 'POST',
				url: 'app/ajax/comments_ajax.php',
				data: {action: 'add_com', comment:comment, login:login, post_id:post_id, session:session},
				success: function (data){
					$('.err').empty();
					if (data.includes('ok')){
						const today = new Date();
						const dateSrc = today.toLocaleString('ru-RU', { year: 'numeric', month: 'numeric', day: 'numeric' });
						let time = today.toLocaleString('ru-RU', { hour: 'numeric', minute: 'numeric', second: 'numeric' });
						time = time.split(".").reverse().join(":");
						dateDst = dateSrc.split(".").reverse().join("-");
						$('#hr').after(`
						<div style="margin: 20px 0;" class="one-comment">
							<div style="display:flex;justify-content: space-between;">
								<i style="margin-left: 11px;" class="far fa-user">${login}</i>
								<i style="margin-right: 11px;" class="far fa-calendar"> ${dateDst} ${time}</i>
							</div>
							<div style="background: white;margin-top: 15px;padding: 12px;border-radius: 7px;">
								${comment}
							</div>
						</div>`);
						let span = $('#num_comm');
						let num_comm = span.text();
						span.empty();
						span.append(+num_comm + 1);
					}else {
						$('.err').append(data);
					}
				}
			});
		});

		// Удалить комментарий
		<? if($_SESSION['admin'] == 1): ?>
			$('.comments').on('click', function (event){
				if (event.target.hasAttribute('data')){
					if (confirm('Вы действительно хотите удалить комментарий?')){
						var target = event.target;
						var id = target.getAttribute('data');
						$.ajax({
							type: 'POST',
							url: 'app/ajax/comments_ajax.php',
							data: {action: 'del_com', id:id},
							success: function (data){
								if (data.includes('ok')){
									let comment = target.parentElement.parentElement.parentElement;
									comment.remove();
									let span = $('#num_comm');
									let num_comm = span.text();
									span.empty();
									span.append(num_comm - 1);
								}
							}
						});
					}
				}
			});
		<? endif; ?>
		// Поставить лайк
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