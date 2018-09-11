<?
	require("admin/fckeditor/fckeditor.php");
	
	class Form_Decorator_FCK extends Zend_Form_Decorator_Abstract {
		private $_basePath = '/admin/fckeditor/';
		public static $fck;
 
		public function setBasePath($path) {
			$this->_basePath = $path;
		}
 
		public function render($content) {
			$newcont = "<input type=\"hidden\" id=\"".$this->getElement()->getName()."\" name=\"".$this->getElement()->getName()."\" value=\"".$this->getElement()->getValue()."\" style=\"display:none\" /><input type=\"hidden\" id=\"".$this->getElement()->getName()."___Config\" value=\"\" style=\"display:none\" /><iframe id=\"".$this->getElement()->getName()."___Frame\" src=\"/admin/fckeditor/editor/fckeditor.html?InstanceName=cont&amp;Toolbar=Default\" width=\"100%\" height=\"400\" frameborder=\"0\" scrolling=\"no\"></iframe>";

			if(self::$fck != 1){
				echo '<script type="text/javascript" src="/admin/fckeditor/fckeditor.js"></script>';
				self::$fck = 1;
			}

			$newcont = $content."<script> 
				var editor = new FCKeditor('".$this->getElement()->getName()."'); 
				editor.BasePath = '".$this->_basePath."'; 
				editor.ToolbarSet = 'User'; 
				editor.ReplaceTextarea('".$this->getElement()->getId()."'); 
				</script>";

			return $newcont;
		}
	}