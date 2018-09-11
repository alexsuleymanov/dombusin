<?
	class Form_Decorator_Ajax extends Zend_Form_Decorator_Abstract{
		public function getJSCode(){
			$form = $this->getElement();
			$button = $form->getElement('submit');
			$jsCode='
				<div id ="check_'.$form->getAttrib('id').'"></div>
				<script>
				$("#'.$button->getAttrib('id').'").click(function () {
					data =	$("#'.$form->getAttrib('id').'").serialize();
					$.ajax({
						type: "'.$form->getMethod().'",
						url: "'.$form->getAction().'",
						data: data,
						success: function(msg){
							$("#check_'.$form->getAttrib('id').'").html(msg);
						}
					});
					return false;
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