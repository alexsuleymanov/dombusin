<?
$form = $this->form; /* @var $form Zend_Form */

?>
<form id="asform_orderform" enctype="application/x-www-form-urlencoded" class="asform" action="/1" method="post">
	<dl class="zend_form">
		<div class="row">
			<dt id="subm-label">&nbsp;</dt>
			<dd class="element">
				<input type="hidden" name="subm" value="1" id="asform_subm">
			</dd>
		</div>
		<dt id="advDataGroup-label">&nbsp;</dt>
		<dd id="advDataGroup-element">
			<fieldset id="fieldset-advDataGroup">
				<dl>
					<div class="row">
						<dt id="email-label">
							<label for="asform_email" class="element-label <?if($form->getElement('email')->isRequired()) echo 'required'?>"><?=$form->getElement('email')->getLabel()?></label>
						</dt>
						<dd class="element">
							<input type="text" name="<?=$form->getElement('email')->getName()?>" id="asform_<?=$form->getElement('email')->getName()?>" value="" size="45" maxlength="45" class="form-control">
						</dd>
					</div>
					<p class="errors">
<?						foreach($form->getElement('email')->getMessages() as $k => $v) {
							echo $v."<br>";
						}?>
					</p>
					
					<div class="row">
						<dt id="password-label">
							<label for="asform_password" class="element-label optional"><?=$form->getElement('password')->getLabel()?></label>
						</dt>
						<dd class="element">
							<input type="password" name="<?=$form->getElement('email')->getName()?>>" id="asform_<?=$form->getElement('password')->getName()?>" value="" size="45" maxlength="45" class="form-control">
						</dd>
					</div>
					<p class="hint"><?=$form->getElement('password')->getDescription()?></p>
					
					<div class="row">
						<dt id="name-label">
							<label for="asform_name" class="element-label required">Имя</label>
						</dt>
						<dd class="element">
							<input type="text" name="name" id="asform_name" value="" size="45" maxlength="45" class="form-control">
						</dd>
					</div>
					
					<div class="row">
						<dt id="surname-label">
							<label for="asform_surname" class="element-label required">Фамилия</label>
						</dt>
						<dd class="element">
							<input type="text" name="surname" id="asform_surname" value="" size="45" maxlength="45" class="form-control">
						</dd>
					</div>

					<div class="row">
						<dt id="phone-label">
							<label for="asform_phone" class="element-label required">Телефон</label>
						</dt>
						<dd class="element">
							<input type="text" name="phone" id="asform_phone" value="" size="45" maxlength="45" class="form-control">
						</dd>
					</div>
					
<p class="hint">Укажите реальный телефон в формате 38(067)123-4567. По нему перезвонит наш менеджер для уточнения деталей заказа</p>
<div class="row"><dt id="city-label"><label for="asform_city" class="element-label required">Город</label></dt>
<dd class="element">
<input type="text" name="city" id="asform_city" value="" size="45" maxlength="45" class="form-control"></dd></div>
<div class="row"><dt id="address-label"><label for="asform_address" class="element-label optional">Адрес</label></dt>
<dd class="element">
<input type="text" name="address" id="asform_address" value="" size="45" maxlength="45" class="form-control"></dd></div>
<p class="hint">Введите свой реальный адрес, по которому будут доставляться товары</p>
<div class="row"><dt id="comment-label"><label for="asform_comment" class="element-label optional">Комментарий к заказу</label></dt>
<dd class="element">
<textarea name="comment" id="asform_comment" rows="7" cols="45" class="form-control"></textarea></dd></div></dl></fieldset></dd>
<dt id="paymentDataGroup-label">&nbsp;</dt><dd id="paymentDataGroup-element"><fieldset id="fieldset-paymentDataGroup"><dl>
<div class="row"><dt id="esystem-label"><label for="asform_esystem" class="element-label required">Способ оплаты</label></dt>
<dd class="element">
<select name="esystem" id="asform_esystem" class="form-control">
<?	foreach ($form->getElement('esystem')->options as $k => $v) {?>
	<option value="<?=$k?>" label="<?=$v?>"><?=$v?></option>
<?}?>
</select></dd></div>
<p class="hint">Заказы, на сумму до 200 грн. отправляются только по предоплате</p>
<div class="row"><dt id="delivery-label"><label for="asform_delivery" class="element-label required">Способ доставки</label></dt>
<dd class="element">
<select name="delivery" id="asform_delivery" class="form-control">
<?	foreach ($form->getElement('delivery')->options as $k => $v) {?>
	<option value="<?=$k?>" label="<?=$v?>"><?=$v?></option>
<?}?>
</select></dd></div>
<div class="row"><dt id="sklad-label"><label for="asform_sklad" class="element-label optional">Номер склада</label></dt>
<dd class="element">
<input type="text" name="sklad" id="asform_sklad" value="" size="45" maxlength="45" class="form-control"></dd></div>
<div class="row"><dt id="needcall-label"><label for="asform_needcall" class="element-label optional">Нужен звонок</label></dt>
<dd class="element">
<input type="hidden" name="needcall" value="0"><input type="checkbox" name="needcall" id="asform_needcall" value="1"></dd></div>
<p class="hint">Вам перезвонят до начала сборки заказа</p></dl></fieldset></dd>
<dt id="buttonsGroup-label">&nbsp;</dt><dd id="buttonsGroup-element"><fieldset id="fieldset-buttonsGroup"><dl>

<input type="submit" name="submit" id="asform_submit" value="Подтвердить" onclick="$('#loading').show().animate({opacity: 0.9}, 500); $(this).hide();"></dl></fieldset></dd></dl></form>
