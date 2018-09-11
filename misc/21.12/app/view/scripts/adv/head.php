<table>
	<tr>
		<td><a href="/adv/add">Добавить объявление</a></td>
	</tr>
	<tr>
		<td>
			Тип объявления: <select id="adv-type" name="type" onChange="location.href = this.value;">
				<option value="<?=$this->url->mkd(array(0, "adv"))?>" <?if($this->args[0] == 'adv') echo "selected=1"?>>Продажа/Покупка</option>
				<option value="<?=$this->url->mkd(array(0, "sale"))?>" <?if($this->args[0] == 'sale') echo "selected=1"?>>Продажа</option>
				<option value="<?=$this->url->mkd(array(0, "buy"))?>" <?if($this->args[0] == 'buy') echo "selected=1"?>>Покупка</option>
			</select>
		</td>
	</tr>
</table>
