<?
if (isset($_GET['action'])) {
	if($_GET['action'] == 'delete'){
		echo realpath(dirname(__FILE__)) ."/../". $_GET['filename'];
		unlink(realpath(dirname(__FILE__)) ."/../". $_GET['filename']);
		die();
	}
}
	include("../../incl.php");
	include("../auth.php");

	$ftypes = array(1 => "gif", 2 => "jpg", 3 => "png", 4 => "swf", 5 => "psd", 6 => "bmp");
	$ims = getimagesize($_FILES["userfile"]["tmp_name"]);
	$ftype = $ftypes[$ims[2]];

	$filename = md5(time()).".".$ftype;
	$tmp_file = $path."/admin/tmp/".$filename;
	
	move_uploaded_file($_FILES["userfile"]["tmp_name"], $tmp_file);
	$dst = $tmp_file;

	if ($tmp_file && ($_GET['width'] || $_GET['height'])) {
		$ir = new imageresizer;
		$ir->src = $tmp_file;
		$ir->type = $ftype;
		$ir->outtype = ($_GET['ftype']) ? $_GET['ftype'] : 'jpg';

		$width = 0 + $_GET['width'];
		$height = 0 + $_GET['height'];

		$sz = getimagesize($ir->src);

		if($width && $height){
			$ir->dstw = $width;
			$ir->dsth = $height;
														//		уменьшаем по высоте
			if(round($sz[1] * $width / $sz[0]) < $height){
				$ratio = $sz[1] / $height;
				$ir->srcx = round(($sz[0] - $width * $ratio)/2);
				$ir->srcw = $sz[0] - 2 * $ir->srcx;
				$ir->srch = $sz[1];
				$ir->srcy = 0;
			}else{										//		уменьшаем по ширине
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

		$ir->dst = $dst;
		$ir->resize();
		
		$Watermark = new AS_Watermark($dst);
	    $Watermark->dst = $dst;
		$Watermark->add(2);

		echo $filename;
	}elseif($tmp_file){
		echo $filename;
	}
