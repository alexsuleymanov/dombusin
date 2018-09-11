<?
	class AS_Sitemap{
		protected $opt;
		protected $map;

		public function __construct(){
			$this->opt = Zend_Registry::get('opt');
		}

		protected function create(){
			$Page = new Model_Page('page');
	
			$pages = $Page->getall(array("where" => "visible = 1"));
			foreach($pages as $v){
				$prior = ($v->intname == '') ? 1 : 0.8;
				$this->map[] = array("href" => "https://".$_SERVER['HTTP_HOST']."/".$v->intname, "prior" => $prior);
			}

			if($this->opt['articles']){
				$Article = new Model_Page('article');

				$articles = $Article->getall(array("where" => "visible = 1", "order" => "tstamp desc"));
				foreach($articles as $v){
					$this->map[] = array("href" => "https://".$_SERVER['HTTP_HOST']."/articles/".$v->intname, "prior" => 0.7, "tstamp" => $v->tstamp);
				}
			}

/*			if($this->opt['news']){
				$News = new Model_Page('news');

				$news = $News->getall(array("where" => "visible = 1", "order" => "tstamp desc"));
				foreach($news as $v){
					$this->map[] = array("href" => "https://".$_SERVER['HTTP_HOST']."/news/".$v->intname, "prior" => 0.7, "tstamp" => $v->tstamp);
				}
			}
*/
			if($this->opt['prod_cats']){
				$Cat = new Model_Cat();

				$cat = $Cat->getall(array("where" => "visible = 1", "order" => "name"));
				foreach($cat as $v){
					$prior = ($v->cat == 0) ? 0.8 : 0.6;
					$this->map[] = array("href" => "https://".$_SERVER['HTTP_HOST']."/catalog/cat-".$v->id."-".$v->intname, "prior" => $prior);
				}
			}

			if($this->opt['prods']){
				$Prod = new Model_Prod();

				$prods = $Prod->getall(array("where" => "visible = 1"));
				foreach($prods as $v){
					$this->map[] = array("href" => "https://".$_SERVER['HTTP_HOST']."/catalog/prod-".$v->id, "prior" => 0.1);
				}
			}
		}

		public function get(){
			return $this->map;
		}

		public function draw(){
			$map_draw = "";
			$map_draw .= "<urlset\n
					xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"
					xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
					xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
					http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
			$map_draw .= "	<!-- Created by Alex Suleymanov www.asweb.com.ua -->\n";

			foreach($this->map as $v){
				$map_draw .= "	<url>\n";
				$map_draw .= "		<loc>".$v['href']."</loc>\n";
				if($v['tstamp']) $map_draw .= "		<lastmod>".date("Y-m-d", $v['tstamp'])."</lastmod>\n";
				if($v['freq']) $map_draw .= "		<changefreq>".$v['freq']."</changefreq>\n";
				if($v['prior']) $map_draw .= "		<priority>".$v['prior']."</priority>\n";
				$map_draw .= "	</url>\n";
			}

			$map_draw .= "</urlset>";

			return $map_draw;			
		}
	
		public function save($filename){
			$this->create();

			$ff = fopen($filename, "w");
			fwrite($ff, "<?xml version=\"1.0\" encoding=\"UTF-8\""."?".">\n");
			fwrite($ff, $this->draw());
			fclose($ff);
		}
	}
