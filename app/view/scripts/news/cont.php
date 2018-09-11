<h2><?=($this->news->h1) ? $this->news->h1 : $this->news->name?></h2>
<?=$this->news->cont?>
<?
	$News = new Model_Page('news');
	$this->news = $News->getall(array("where" => "tstamp < ".$this->news->tstamp." and visible = 1", "order" => "tstamp desc", "limit" => 3));
	if($this->news){?>
		<h3><?=$this->labels['read_more']?></h3>
<?		echo $this->render("news/list.php");
	}?>