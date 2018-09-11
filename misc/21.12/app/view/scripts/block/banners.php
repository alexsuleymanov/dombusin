<?	
	$cpage = $_SERVER[REQUEST_URI];
	$Banner = new Model_Banner();

	$banners = $Banner->getall(array("where" => "(`page` = '".data_base::nq($cpage)."' or `page` = 'all_pages') and position = '".$this->position."'"));
	foreach($banners as $k => $banner){?>
<div id="banner_border">
	<center><?=$banner->cont?></center>
</div>
<?	}?>
