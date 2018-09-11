<h1><?=($this->article->h1) ? $this->article->h1 : $this->article->name?></h1>
<?=$this->article->cont?>
<?	$Articles = new Model_Page('article');
	$this->articles = $Articles->getall(array("where" => "tstamp < ".$this->article->tstamp." and visible = 1", "order" => "tstamp desc", "limit" => 3));
	if(count($this->articles)){?>
		<h3><?=$this->labels['read_more']?></h3>
<?		echo $this->render("articles/list.php");
	}?>