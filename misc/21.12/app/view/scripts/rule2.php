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

	$ocnt = $this->ocnt;
	$oresults = $this->oresults;
	$ostart = $this->ostart;

	if ($ocnt > $oresults) {
		$pages = ceil($ocnt / $oresults);
		$fpage = 0;
		$tpage = $pages;
		$cpage = round($ostart / $oresults);

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

		if ($ostart > 0) {
			$newp = $ostart - $oresults;
			if ($ostart < 0) $ostart = 0;
			echo "<a href=\"".$this->url->gvar("ostart=".$newp)."\" class=\"rulea\">".$prev_img."</a>&nbsp;&nbsp; ";
		}

		echo ($ostart <= 0)? '<span class="rulea">': '<a class="rulea" href="'.$this->url->gvar("ostart=".(($ostart - $oresults > 0)? $ostart - $oresults: 0)).'">';
//		echo "&lt;&lt;";
		if ($fpage > 0) echo ' ... ';
		echo ($ostart <= 0)? '</span>': '</a>';

		$first = 1;
		for ($n = $fpage; $n < $tpage; $n++) {
			if ($first) $first = 0;
//			else echo "|";
//			else echo "&nbsp;&nbsp;";
			echo ($cpage == $n)? ' <span class="rule">': ' <a class="rulea" href="'.$this->url->gvar("ostart=".($n * $oresults)).'">';
			echo $n + 1;
			echo ($cpage == $n)? "</span> $separator ": "</a> $separator ";
		}

		echo ($ostart + $oresults >= $ocnt)? '<span class="rulea">': '<a class="rulea" href="'.$this->url->gvar("ostart=".($ostart + $oresults)).'">';
		if ($tpage < $pages) echo ' ... ';
//		echo "&gt;&gt;";
		echo ($ostart + $oresults >= $ocnt)? '</span>': '</a>';

		if ($ostart < $ocnt - $oresults) {
			$newp = $ostart + $oresults;
			if ($ostart >= $ocnt - $oresults) $ostart = $ocnt - $oresults;
			echo " &nbsp;&nbsp;<a href=\"".$this->url->gvar("ostart=".$newp)."\" class=\"rulea\">".$next_img."</a>";
		}
	}?>
