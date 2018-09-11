<ul>
<?	foreach($this->cats as $k => $cat){
		Model_Cat::clear_tree();
		$tree = array_reverse(Model_Cat::get_cat_tree_up($cat->id));
?>
	<li>
		<a href="/catalog/cat-<?=$cat->id?>-<?=$cat->intname?>?filter=1&brand<?=$this->brand->id?>=<?=$this->brand->id?>"><?=$tree[0]->name." ".$cat->name?></a>
	</li>
<?	}?>
</ul>
