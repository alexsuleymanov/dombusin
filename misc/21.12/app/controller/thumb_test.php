<?
	set_time_limit(0);
//	/thumb?src=pic/cat/320.jpg&width=120&height=120
	$ftypes = array(1 => "gif", 2 => "jpg", 3 => "png", 4 => "swf", 5 => "psd", 6 => "bmp");
	$ims = getimagesize($path."/".$url->g['src']);
	$ftype = $ftypes[$ims[2]];

/*	if($ftype == "jpg")
		header("Content-type: image/jpeg");
	elseif($ftype == "gif")
		header("Content-type: image/gif");
	elseif($ftype == "png")
		header("Content-type: image/png");

	$Watermark = new AS_Watermark($path."/".$url->g['src']);
	$Watermark->add();
*/
	

	$dd = opendir($path."/pic/prod");

	while($ff = readdir($dd)){
		if($ff == '.' || $ff == '..') continue;

		$Watermark = new AS_Watermark($path."/pic/prod/".$ff);
    	$Watermark->dst = $path."/pic/prod/".$ff;
		$Watermark->add();
		echo $ff."<br/>";
	}
