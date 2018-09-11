<?	class imageresizer {
		public $src;
		public $dst;
		public $dsts;
		public $dstw;
		public $dsth;
		public $srcw;
		public $srch;

		public $dstx;
		public $dsty;
		public $srcx;
		public $srcy;

		public $type;
		public $outtype;
		public $jpegqual;

		public $watermark;
		public $watermark_w;
		public $watermark_h;

		public function __construct() {
			$this->type = 'jpg';
			$this->outtype = 'jpg';
			$this->jpegqual = 80;

			$this->dstw = $this->dsth = 'auto';
			$this->srcw = $this->srch = 0;
			$this->dstx = $this->dsty = $this->srcx = $this->srcy = 0;
		}

		public function resize() {
			switch($this->type) {
				case 'jpg':
					$srcim = imagecreatefromjpeg($this->src);
					break;
				case 'gif':
					$srcim = imagecreatefromgif($this->src);
					break;
				case 'png':
					$srcim = imagecreatefrompng($this->src);
					break;
				default:
					$srcim = imagecreatefromjpeg($this->src);
					break;
			}

			$srcw = ($this->srcw) ? $this->srcw : imagesx($srcim);
			$srch = ($this->srch) ? $this->srch : imagesy($srcim);
				
			if ($this->dsth === 'auto' && $this->dstw > 0 && $srcw > 0)
				$this->dsth = round($srch * $this->dstw / $srcw);
			
			if ($this->dstw === 'auto' && $this->dsth > 0 && $srch > 0)
				$this->dstw = round($srcw * $this->dsth / $srch);

			$dstim = imagecreatetruecolor($this->dstw, $this->dsth);
			if($this->type == 'png'){
				$bg = imagecolorallocate($dstim, 0, 0, 0);
				imageColorTransparent($dstim, $bg);
			}

			imagecopyresampled($dstim, $srcim, $this->dstx, $this->dsty, $this->srcx, $this->srcy, $this->dstw, $this->dsth, $srcw, $srch);
			
			$this->dst = ($this->dst) ? $this->dst : NULL;
			switch($this->outtype) {
				case 'jpg':
					imagejpeg($dstim, $this->dst, $this->jpegqual);
					break;
				case 'gif':
					if($this->dst)
						imagegif($dstim, $this->dst);
					else
						imagegif($dstim);
					break;
				case 'png':
					if($this->dst)
						imagepng($dstim, $this->dst);
					else
						imagepng($dstim);
					break;
				default:
					imagejpeg($dstim, $this->dst, $this->jpegqual);
					break;
			}
		}
	}