<?php
//	/thumb?src=pic/cat/320.jpg&width=120&height=120
	$ftypes = array(1 => "gif", 2 => "jpg", 3 => "png", 4 => "swf", 5 => "psd", 6 => "bmp");
	$ims = getimagesize($path."/".$url->g['src']);
	$ftype = $ftypes[$ims[2]];

	if($ftype == "jpg")
		header("Content-type: image/jpeg");
	elseif($ftype == "gif")
		header("Content-type: image/gif");
	elseif($ftype == "png")
		header("Content-type: image/png");

	header("Expires: ".date("D, d M Y H:i:s", time()+30+86400));
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-control: public");
	header('Pragma: public');

	if (!$outputcache->start("thumb_".str_replace(array(".", "/", "\\"), "_", $url->g["src"])."_".$url->g["width"]."_".$url->g["height"])){
		$width = 0 + $url->g['width'];
		$height = 0 + $url->g['height'];

		$ir = new imageresizer;
		$ir->src = $path."/".$url->g['src'];
		$ir->type = $ir->outtype = $ftype;
		$sz = getimagesize($ir->src);

		if($width && $height){
			$ir->dstw = $width;
			$ir->dsth = $height;

			if(round($sz[1] * $width / $sz[0]) < $height){
				$ratio = $sz[1] / $height;
				$ir->srcx = round(($sz[0] - $width * $ratio)/2);
				$ir->srcw = $sz[0] - 2 * $ir->srcx;
				$ir->srch = $sz[1];
				$ir->srcy = 0;
			}else{
				$ratio = $sz[0] / $width;
				$ir->srcx = 0;
				$ir->srcy = round(($sz[1] - $height * $ratio)/2);
				$ir->srcw = $sz[0];
				$ir->srch = $sz[1] - 2 * $ir->srcy;
			}
		}elseif($width && $height == 0){
			$ir->dstw = min($width, $sz[0]);
			$ir->dsth = round($sz[1] * $ir->dstw / $sz[0]);
		}elseif($height && $width == 0){
			$ir->dsth = min($height, $sz[1]);
			$ir->dstw = round($sz[0] * $ir->dsth / $sz[1]);
		}elseif($height == 0 && $width == 0){
			$ir->dstw = $sz[0];
			$ir->dsth = $sz[1];
		}

		$ir->dst = '';

		if(file_exists($path."/".$url->g['src'])){
			$ir->resize();
		   	$outputcache->end(array(str_replace(array("/", "."), "_", str_replace("../", "", $url->g["src"]))));
		}else{
			echo "";
		}
	}