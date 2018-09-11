<table cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td>
<?	
	$pagesinoneruler = 20;

	if(file_exists(dirname(__FILE__)."../../img/rule/prev.gif") && file_exists(dirname(__FILE__)."../../img/rule/next.gif")){
		$prev_img = "<img src=\"/img/rule/prev.gif\" alt=\"\">";
		$next_img = "<img src=\"/img/rule/next.gif\" alt=\"\">";
	}else{
		$prev_img = "&lt;";
		$next_img = "&gt;";
	}
	$separator = "|";

	$cnt = $this->cnt;
	$results = $this->results;
	$start = $this->start;

	if ($cnt >= $results) {
		$pages = ceil($cnt / $results);
		$fpage = 0;
		$tpage = $pages;
		$cpage = round($start / $results);

		if ($pagesinoneruler < $pages) {
			$fpage = $cpage - round($pagesinoneruler / 2);
			$tpage = $cpage + round($pagesinoneruler / 2);
			if ($fpage < 0) {
				$fpage = 0;
				$tpage = $pagesinoneruler;
			}
			if ($tpage > $pages) {
				$fpage = $pages - $pagesinoneruler;
				$tpage = $pages;
			}
		}

		if ($start > 0) {
			$newp = $start - $results;
			if ($start < 0) $start = 0;
			echo "<a href=\"".$this->url->page.$this->url->gvar("start=".$newp)."\" class=\"rulea\">".$prev_img."</a>&nbsp;&nbsp; ";
		}
		
		echo ($start <= 0)? '<span class="rulea">': '<a class="rulea" href="'.$this->url->page.$this->url->gvar("start=".(($start - $results > 0)? $start - $results: 0)).'">';
//		echo "&lt;&lt;";
		if ($fpage > 0) echo ' ... ';
		echo ($start <= 0)? '</span>': '</a>';

		$first = 1;
		for ($n = $fpage; $n < $tpage; $n++) {
			if ($first) $first = 0;
//			else echo "|";
//			else echo "&nbsp;&nbsp;";
			echo ($cpage == $n)? ' <span class="rule">': ' <a class="rulea" href="'.$this->url->page.$this->url->gvar("start=".($n * $results)).'">';
			echo $n + 1;
			echo ($cpage == $n)? "</span> $separator ": "</a> $separator ";
		}

		echo ($start + $results >= $cnt)? '<span class="rulea">': '<a class="rulea" href="'.$this->url->page.$this->url->gvar("start=".($start + $results)).'">';
		if ($tpage < $pages) echo ' ... ';
//		echo "&gt;&gt;";
		echo ($start + $results >= $cnt)? '</span>': '</a>';

		if ($start < $cnt - $results) {
			$newp = $start + $results;
			if ($start >= $cnt - $results) $start = $cnt - $results;
			echo " &nbsp;&nbsp;<a href=\"".$this->url->page.$this->url->gvar("start=".$newp)."\" class=\"rulea\">".$next_img."</a>";
		}
	}?>
		</td>
	</tr>
</table>