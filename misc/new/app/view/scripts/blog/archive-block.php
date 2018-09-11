<h2>Архив</h2>
<?
	$t[months] = array(
		"1" => "Январь",
		"2" => "Февраль",
		"3" => "Март",
		"4" => "Апрель",
		"5" => "Май",
		"6" => "Июнь",
		"7" => "Июль",
		"8" => "Август",
		"9" => "Сентябрь",
		"10" => "Октябрь",
		"11" => "Ноябрь",
		"12" => "Декабрь",
	);

	$period = "month"; // month, year

	$Article = new Model_Page('post');
	$article = $Article->getone(array("select" => "tstamp", "order" => "tstamp asc", "limit" => "1"));

	$oldest = getdate($article->tstamp);
	$now = getdate(time());

	if($period == 'month'){
		for($i = $now["year"]; $i >= $oldest["year"]; $i--){
			for($j = 1; $j <= 12; $j++){
				$t1 = mktime(0, 0, 0, $j, 1, $i);
				$t2 = mktime(0, 0, 0, $j+1, 1, $i);
				if($Article->getnum(array("where" => "tstamp > $t1 and tstamp < $t2"))){?>
					<a href="/blog/archive/<?=$i?>/<?=$j?>"><?=$t[months][$j]." ".$i?></a><br>
<?				}
			}

		}
	}else{
		for($i = $oldest["year"]; $i <= $now["year"]; $i++){
			echo $i."<br>";
		}		
	}
