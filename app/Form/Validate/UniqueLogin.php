<?
	class Form_Validate_UniqueLogin extends Zend_Validate_Abstract {
		const INVALID = 'Invalid';

		protected $_messageTemplates = array();
			
		public function isValid($value){
			global $labels;

			$this->_messageTemplates = array(
				self::INVALID => $labels["login_exists"]
			);

	        $this->_setValue($value);
        
			$User = new Model_User('client');
			if ($User->getnum(array("where" => "login = '".data_base::nq($value)."'")) > 0) {
	            $this->_error(self::INVALID);
	            return false;
			}

        	return true;
    	}
	}
