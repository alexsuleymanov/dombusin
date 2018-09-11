<script type="text/javascript">
	function comment_submit(){
		$.post("/comments", $("#commentform").serialize(), function(data){
			alert('Ваш отзыв отправлен модератору');
			location.href = '/';
/*			$("#commentform").find(':input').each(function() {
		        switch(this.type) {
        		    case 'password':
		            case 'select-multiple':
        		    case 'select-one':
		            case 'text':
        		    case 'textarea':
	    	            $(this).val('');
    	    	        break;
		            case 'checkbox':
		            case 'radio':
		                this.checked = false;
			        }
	    	});
*/
		});
	}
</script>

<?=$Page->cont;?>
<br />
<input type="button" value="Добавить отзыв" onclick="location.href = '#form';"/>
<br /><br />

<span class="rev-text">
	Уважаемые клиенты! Оставьте, пожалуйста, Ваш отзыв о работе нашего интернет магазина. Нам очень важно Ваше мнение. Это поможет нам улучшить качество обслуживания. Спасибо!
</span>

<br /><br />

<div class="wrap-container">
	<div class="content reviews">
		<div class="wrap-reviews">

<?	foreach($this->comments as $k => $comment){
		$User = new Model_User('client');
		$author = $User->get($comment->user);
		if(empty($comment->cont)) continue;?>
			<div class="reviews-block clearfix">
				<span class="head clearfix">
					<span class="icon-reviews"></span>
					<span class="head-title"> "<?=$comment->theme?>"</span>
					<span class="date"> / <?=date("d-m-Y", $comment->tstamp)?></span>
				</span>
				<span class="reviews-text">
					<span class="name"><?=$author->name." ".$author->surname?>:</span>
					<span class="text">
						<?=$comment->cont?>
					</span>
				</span>
<?		if(!empty($comment->answer)){?>
				<div class="reviews-text" style="padding-left: 35px;">
					<span class="head clearfix">
						<span class="icon-reviews"></span>
						<span class="head-title"> Ответ Dombusin.com</span>
					</span>
					<span class="text">
						<?=$comment->answer?>
					</span>
				</div>
<?		}?>
			</div> 
<?	}?>
		</div>
	</div>
</div>

			<br /><br />

			<table cellpadding="5" cellspacing="5">

				<tr>
					<td><a name="form"></a> </td>
					<td><h3>Оставить отзыв</h3></td>
				</tr>
				<tr>
					<td></td>
					<td>
<?					if($_COOKIE['userid']){?>
						<form action="" method="post" id="commentform">
						<table class="commentform">
							<tr>
								<td>Тема сообщения</td>
								<td><input type="text" name="theme" size="40" /></td>
							</tr>
							<tr>
								<td valign="top">Коментарий</td>
								<td><textarea name="cont" rows="10" cols="40"></textarea></td>
							</tr>
							<tr>
								<td colspan="2" align="right">
									<input type="submit" name="submit" value="Отправить" onclick="comment_submit(); return false;" />
									<input type="hidden" name="type" value="site" />
									<input type="hidden" name="par" value="0" />
								</td>
							</tr>
						</table>
						</form>                                         
<?					}else{?>
						<div class="comment_register_login"><a href="/register">ЗАРЕГИСТРИРУЙТЕСЬ</a> ИЛИ <a href="/login">ВОЙДИТЕ</a> ЧТОБЫ ОСТАВИТЬ ОТЗЫВ</div>
<?					}?>
					</td>
				</tr>

			</table>
<br /><br /><br />
<?/*
<span class="rev-text">
	Уважаемые клиенты! Оставьте, пожалуйста, Ваш отзыв о работе нашего интернет магазина. Нам очень важно Ваше мнение. Это поможет нам улучшить качество обслуживания. Спасибо!
</span>

<div class="wrap-container">
	<div class="content reviews">
		<div class="wrap-reviews">
			<div class="reviews-block clearfix">
				<span class="head clearfix">
					<span class="icon-reviews"></span>
					<span class="head-title"> "Удобный магазин, спасибо!"</span>
					<span class="date"> / 21-06-2015</span>
				</span>
				<span class="reviews-text">
					<span class="name">Анастасия:</span>
					<span class="text">
						Анастасия, Златоуст, Челябинской обл. Заказ оформила 9.06.2015 в 8 вечера - 11.06.2015 уже пришло сообщение, что заказ собран - быстро, молодцы! Удобные способы оплаты, приятная девушка- оператор:) Спасибо за бесплатную доставку! 
					</span>
				</span>
			</div>
*/?>