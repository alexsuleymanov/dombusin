<noindex>
	<div id="callbackModal" class="modal hide" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-header clearfix">
			<h3 id="myModalLabel">Обратный звонок</h3>
			<a href="#" class="close" data-dismiss="modal" aria-hidden="true">Закрыть</a>
		</div>
		<div class="modal-body clearfix">
			<form action="/callback" method="post" id="callback_form">
				<div class="moduleBox">
					<div class="content">
						<div class="form" id="calback-form">
							<ol>
								<li><label for="name">Полное имя:</label><input type="text" name="name" id="name"></li>
								<li><label for="email">Ваш телефон:</label><input type="text" name="phone" id="phone"></li>
								<li><label for="callback">Время для звонка:</label>
									<select name="callback">
										<option value="9:00-18:00">9:00-18:00</option>
										<option value="9:00-12:00">9:00-12:00</option>
										<option value="12:00-14:00">12:00-14:00</option>
										<option value="14:00-18:00">14:00-18:00</option>
										<option value="18:00-20:00">18:00-20:00</option>
										<option value="20:00-22:00">20:00-22:00</option>
										<option value="7:00-9:00">7:00-9:00</option>
										<option value="7:00-9:00">7:00-9:00</option>
									</select>
								</li>
								<li><label for="enquiry">Запрос:</label><textarea name="cont" cols="50" rows="8" id="enquiry"></textarea></li>
							</ol>
						</div>
					</div>
				</div>

				<div class="submitFormButtons" style="text-align: right;">
					<button id="submit_callback" type="submit" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false">
						<span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-e"></span>
						<span class="ui-button-text">Отправить</span>
					</button>
					<script type="text/javascript">$("#submit_callback").button({icons:{primary:"ui-icon-triangle-1-e"}});</script>
				</div>
			</form>
		</div>
		<div class="modal-footer clearfix">
		</div>
	</div>
</noindex>

<script type="text/javascript">
	$("#submit_callback").click(function () {
		var data = $("#callback_form").serialize();
		alert("Ваш запрос отправлен!\nНаш специалист перезвонит в ближайшее время");
		$("#callback").css({"display":"none"});

		$.ajax({
			type: "post",
			url: "/callback",
			data: data,
			success: function(msg){
				//							alert(msg);
			}
		});

		return false;
	});
</script>