<?
	class Watermark{
		public $image;
		public $watermark;
		public $dst;

		protected $mark_w;
		protected $mark_h;
		protected $src_w;
		protected $src_h;

		public function __construct($filename){
			$this->image = imagecreatefromjpeg($filename);
			$this->src_w = imagesx($this->image);
			$this->src_h = imagesy($this->image);
		}

		public function add(){
			imageline($this->image, 0, 0, $this->src_w, $this->src_h, imagecolorallocate($this->image, 255, 255, 255));
//			imageline($this->image, 0, 0, imagecolorallocate($this->image, 255, 255, 255));

			imagejpeg($this->image);
		}
	}