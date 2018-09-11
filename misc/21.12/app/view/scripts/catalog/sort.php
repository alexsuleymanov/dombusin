<script type="text/javascript">
function prodsort(value) {
	switch(true){
		case(value=='priordesc'):
			href = '<?=$this->url->gvar("order=prior&desc_asc=desc")?>';
			break;
		case(value=='changeddesc'):
			href = '<?=$this->url->gvar("order=changed&desc_asc=desc")?>';
			break;
		case(value=='priceasc'):
			href = '<?=$this->url->gvar("order=price&desc_asc=asc")?>';
			break;
		case(value=='pricedesc'):
			href = '<?=$this->url->gvar("order=price&desc_asc=desc")?>';
			break;
	}
	location.href = href;
}
</script>

<form name="sort" action="http://www.dombusin.com/index.php" method="get">
	Сортировка:&nbsp;
	<select name="sort" id="sort" onchange="prodsort(value)">
		<option value="priordesc"<?=(($_GET['order']=='prior')&&($_GET['desc_asc']=='desc'))?' selected="selected"':''?>>По популярности</option>
		<option value="changeddesc"<?=(($_GET['order']=='changed')&&($_GET['desc_asc']=='desc'))?' selected="selected"':''?>>По обновлению</option>
		<option value="priceasc"<?=(($_GET['order']=='price')&&($_GET['desc_asc']=='asc'))?' selected="selected"':''?>>Цена по возрастанию</option>
		<option value="pricedesc"<?=(($_GET['order']=='price')&&($_GET['desc_asc']=='desc'))?' selected="selected"':''?>>Цена по убыванию</option>
	</select>
</form>