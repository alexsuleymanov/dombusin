<h2 class="actions"><?=$this->labels['actions_archive']?></h2>
<?
	$t['months'] = array(
		"1" => $this->labels['january'],
		"2" => $this->labels['february'],
		"3" => $this->labels['march'],
		"4" => $this->labels['april'],
		"5" => $this->labels['may'],
		"6" => $this->labels['june'],
		"7" => $this->labels['july'],
		"8" => $this->labels['august'],
		"9" => $this->labels['september'],
		"10" => $this->labels['october'],
		"11" => $this->labels['november'],
		"12" => $this->labels['december'],
	);

	$archive = Model_Page::archive('actions');

	foreach($archive as $k => $y){?>
	<a class="acitons" href="/actions/archive/<?=$k?>"><?=$k?></a><br>
<?		if(is_array($y)){
			foreach($y as $kk => $m){?>
		<a class="actions" href="/actions/archive/<?=$k?>/<?=$m?>"><?=$t['months'][$m]?></a><br>
<?			}
		}
	}
