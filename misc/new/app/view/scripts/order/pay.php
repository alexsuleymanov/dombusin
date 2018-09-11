<?
	$Esystem = new Model_Esystem($this->esystem);
	$Eforms = new Model_Eforms();

	$esystem = $Esystem->get();
	$eforms = $Eforms->getall(array("where" => "systemid = '".$this->esystem."'"));
?>
<form name="apform" action="<?=$esystem->forms?>" method="post">
<?	foreach($eforms as $ff) {
		$val = preg_match("/^SITE_/", $ff->valuef) ? $this->params[$ff->valuef] : $ff->valuef;?>
	<input name="<?=$ff->name?>" type="<?=$ff->typef?>" value="<?=$val?>">
<?	}?>
</form>
<?	if ($esystem->autof) {?>
<script language="JavaScript">
alert("");
window.apform.submit()
</script>
<?	} else {
		foreach($this->params as $k => $v){
			$cont = preg_replace("/".$k."/m", $v, $esystem->cont);
		}
		echo $cont;
	}
