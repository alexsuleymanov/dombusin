<?
	class AS_Watermark{
		public $image;
		public $watermark;
		public $dst;
		
		protected $mark_w;
		protected $mark_h;
		protected $src_w;
		protected $src_h;
		protected $font;
		protected $text;

		public function __construct($filename){
			global $path;

			$this->image = imagecreatefromjpeg($filename);
			$this->src_w = imagesx($this->image);
			$this->src_h = imagesy($this->image);
			$this->font = $path."/app/view/img/font/Arial.ttf";
			$this->text = "WWW.DOMBUSIN.COM";
		}

		public function add($type = 1){
			if($type == 1){
				$white = imagecolorallocatealpha($this->image, 255, 255, 255, 40);
				$black = imagecolorallocatealpha($this->image, 150, 150, 150, 40);
				$font_size = round(min($this->src_h, $this->src_w) / 50);

				$font_box_size = imagettfbbox($font_size, 0, $this->font, $this->text);
				$logo_width = $font_box_size[2] - $font_box_size[0];
				$logo_height = $font_box_size[1] - $font_box_size[7];

				$logos_at_line = round($this->src_w / $logo_width / 2);
				$lines = round($this->src_h / $logo_height / 2);

				for($i = 0; $i < $lines; $i++){
					for($j = 0; $j < $logos_at_line; $j++){
//					print_r(array($j*$logo_width*2+2, $i*$logo_height*2+2)); echo "<p>";
						imagettftext($this->image, $font_size, 0, $j*$logo_width*2+round($logo_width/$lines*($i % $lines))+2, $i*$logo_height*2+2, $black, $this->font, $this->text);
					}
				}
			}

			if($type == 2){
				$font_size = round(min($this->src_h, $this->src_w) / 20);
				$white = imagecolorallocatealpha($this->image, 255, 255, 255, 10);
				$black = imagecolorallocatealpha($this->image, 50, 50, 50, 10);

				$font_box_size = imagettfbbox($font_size, 0, $this->font, $this->text);
				$logo_width = $font_box_size[2] - $font_box_size[0];
				$logo_height = $font_box_size[1] - $font_box_size[7];

				imagettftext($this->image, $font_size, 45, $this->src_w / 10 * 4 + 10, $this->src_h - 10, $white, $this->font, $this->text);
				imagettftext($this->image, $font_size, -45, $this->src_w / 10, $this->src_h / 10, $black, $this->font, $this->text);
			}


			imagejpeg($this->image, $this->dst);
			imagedestroy($this->image);
		}
	}