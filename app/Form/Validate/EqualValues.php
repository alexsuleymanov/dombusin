<?
	class Form_Validate_EqualValues extends Zend_Validate_Abstract{
		const NOT_EQUAL = 'notEqual';
    
		protected $_messageTemplates = array();

		protected $_contextKey;
    
		public function __construct($key){
			$this->_contextKey = $key;
		}
    
		public function isValid($value, $context = null){
			global $labels;

			$this->_messageTemplates = array(
				self::NOT_EQUAL => $labels["passwords_are_not_equal"],
			);

			if (is_array($context))
				if (isset($context[$this->_contextKey]) && ($value === $context[$this->_contextKey]))
					return true;
       
			if ($value === $context)
				return true;

			$this->_error(self::NOT_EQUAL);
			return false;
		}
	}