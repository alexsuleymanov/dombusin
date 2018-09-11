<?
	class Form_Decorator_Antispam extends Zend_Form_Decorator_Abstract{
		public function getJSCode(){
			$form = $this->getElement();
			$button = $form->getElement('submit');
			$jsCode='
				<script>
					function asweb_generate_code(){
						var code = "asfdlkh";
						var code2 = Math.pow(15, 2) - (200 / 10);
						var code3 = "yaglkhag";
						var code4 = "0" + (Math.pow(2, 5) - 24);
						var code6 = Math.pow(5, 2);
						var code5 = "y"+code6+"jga0y"+code6;	
						var code123 = code + code2 + code3 + code4 + code5;
						return code123;
					}
				</script>
				<script>
					document.getElementById("'.$button->getAttrib('id').'").addEventListener("click", function() {
						document.getElementById("asform_code").value = asweb_generate_code();
					});
				</script>
			';
			return $jsCode;
		}
	
		public function render($content){
			$element = $this->getElement();
			if (null === $element->getView()){
				return $content;
			}

			$placement = $this->getPlacement();
			switch  ($placement) {
				case  'APPEND':
					return $content.$this->getJSCode();
				case  'PREPEND':
					return  $this->getJSCode().$content;
				case  null:
				default:
					return $content.$this->getJSCode();
			}
		}
	}