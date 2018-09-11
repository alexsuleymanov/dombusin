<?
	set_time_limit(0);
	include("adm_incl.php");
	
	echo $view->render('head.php');

	$qr = $db->q("select p.id, p.name from dombusin_prod as p left join dombusin_relation as r on r.relation = p.id where r.relation is NULL");

	while($prod = $qr->f()){
		if(!$prod->id ) continue;
		if($prod->name)
			echo "<a target=\"_blank\" href=\"adm_prod.php?action=edit&id=".$prod->id."\">".$prod->name."</a><br />";
		else
			echo "<a target=\"_blank\" href=\"adm_prod.php?action=edit&id=".$prod->id."\">Странный товар</a> | <a target=\"_blank\" href=\"adm_prod.php?action=del&id=".$prod->id."\">Удалить</a><br />";
	}
	
	echo $view->render('foot.php');