<?
	class Form_Decorator_AjaxError extends Zend_Form_Decorator_Abstract{
		public function _getHtmlCode(){
			$element = $this->getElement();
			$HtmlCode='
				<div id="error_' . $element->getName() . '"></div>
			';
			return $HtmlCode;
		}
	
		public function render($content){
			$element = $this->getElement();
			if (!$element instanceof Zend_Form_Element) {
				return $content;
			}
			if (null === $element->getView()) {
            	return $content;
			}
			$placement = $this->getPlacement();

			switch  ($placement) {
	            case  'APPEND':
    	            return $content.$this->_getHtmlCode();
        	    case  'PREPEND':
            	    return  $this->_getHtmlCode().$content;
	            case null:
    	        default:
        	        return $content.$this->_getHtmlCode();
			}
		}
	}
