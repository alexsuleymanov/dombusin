<?	if($this->page->bc){
		$crumbs = $this->page->bc;
//		echo "1111";
//		print_r($this->page->bc);
?>
						<div class="breadcrumb" style="text-align: center; margin: 10px 0 10px 0;">
							<div xmlns:v="http://rdf.data-vocabulary.org/#">
<?	//eval("\$crumbs = array(".$this->page->bc.");");
	$i = 0;
	foreach($crumbs as $k => $v){
		if($v){?>
								<span typeof="v:Breadcrumb"><a property="v:title" rel="v:url" href="<?=$k?>"><?=$v?></a><?if(++$i < count($crumbs)){?> › <?}?></span>
<?		}else{?>
								<span typeof="v:Breadcrumb"><?=$v?></span>
<?		}
	}?>
							</div>
						</div>
<?	}?>