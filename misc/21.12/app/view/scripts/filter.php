<?
	$opt = Zend_Registry::get('opt');
//	par == 1  Основные параметры
//	par == 2  Расширенные параметры
//  par == 3  Все параметры

	$par = 0 + $this->params;
	$cat = 0 + $this->cat;

?>
<form action="/<?=$this->args[0]?>/<?=$this->args[1]?>" method="get">
<input type="hidden" name="filter" value="1">
<table cellspacing="0" cellpadding="0" border="0" width="250" id="filterform">
<?	if($opt["prod_brands"]){?>
	<tr>
		<td valign="top">
			<table cellspacing="0" cellpadding="0" border="0" width="90%">
				<tr>
					<td><strong><?=$this->labels["manufacturer"]?></strong></td>
				</tr>
<?
	$Brand = new Model_Brand();
	$brands = $Brand->getall(array("order" => "name"));
	foreach($brands as $brand){
		if($nnn++ % 2 == 0) echo "<tr>";
?>              
				<tr>
					<td class="char"><input type="checkbox" name="brand<?=$brand->id?>" value="<?=$brand->id?>" <?if($_GET["brand".$brand->id]) echo "checked";?>> <?=$brand->name?></td>
				</tr>
<?	}?>	
			</table>
		</td>
	</tr>
<?	}?>
<?	if($opt["prod_chars"]){?>
	<tr>
		<td>
<?
		$Char = new Model_Char();
		if($par == 1 || $par == 0)
			$chars = $Char->getall(array("where" => Model_Cat::cat_tree($cat)." and search = '1'", "order" => "prior desc"));
		else if($par == 2)
			$chars = $Char->getall(array("where" => Model_Cat::cat_tree($cat)."