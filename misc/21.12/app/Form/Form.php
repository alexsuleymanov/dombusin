<?
	class Form_Form extends Zend_Form{
		protected $_translate = array (
			Zend_Validate_Alnum::NOT_ALNUM     => "Значение содержит запрещенные символы. Разрешены символы латиници, кирилици, цифры и пробел",
			Zend_Validate_Alnum::STRING_EMPTY  => "Поле не может быть пустым",
    
			Zend_Validate_Date::NOT_YYYY_MM_DD => 'Значение не соответствует формату год-месяц-день',   
			Zend_Validate_Date::INVALID        => 'Неверная дата',   
			Zend_Validate_Date::FALSEFORMAT    => 'Значение не соответствует указанному формату',   
     
			Zend_Validate_EmailAddress::INVALID            => "Не верный формат адреса электронной почты. Введите почту в формате local-part@hostname",
			Zend_Validate_EmailAddress::INVALID_HOSTNAME   => "'%hostname%' не верный домен для адреса электронной почты '%value%'",
			Zend_Validate_EmailAddress::INVALID_MX_RECORD  => "'%hostname%' не имеет MX-записи об адресе электронной почты '%value%'",
			Zend_Validate_EmailAddress::DOT_ATOM           => "'%localPart%' не соответствует формату dot-atom",
			Zend_Validate_EmailAddress::QUOTED_STRING      => "'%localPart%' не соответствует формату quoted-string",
			Zend_Validate_EmailAddress::INVALID_LOCAL_PART => "'%localPart%' не верное имя для адреса электронной почты '%value%'",

			Zend_Validate_Int::NOT_INT => 'Значение не является целочисленным значением',   
     
			Zend_Validate_NotEmpty::IS_EMPTY => 'Поле не может быть пустым',
     
			Zend_Validate_StringLength::TOO_SHORT => 'Длина введённого значения меньше чем %min% символов',   
			Zend_Validate_StringLength::TOO_LONG  => 'Длина введённого значения больше чем %max% символов',   

//			App_Validate_EqualInputs::NOT_EQUAL => 'Пароли не совпадают',
    
			Zend_Captcha_Word::BAD_CAPTCHA   => 'Вы указали не верные символы',
			Zend_Captcha_Word::MISSING_VALUE => 'Поле не может быть пустым',
    
			'agreeRules' => 'Регистрируясь вы должны согласится с правилами',
		);

		public function init(){
	        parent::init();
        
			$this->setAttrib('class', 'asform');

    	    $translator = new Zend_Translate_Adapter_Array($this->_translate);
        
			$this->setTranslator($translator);

			$this->setElementDecorators(array(
		        'ViewHelper',
        		'Errors',
		        array(array('data' => 'HtmlTag'), array('tag' => 'dd', 'class'  => 'element')),
		        array('Label', array('tag' => 'dt', 'class' => 'element-label')),
		        array(array('row'  => 'HtmlTag'), array('tag' => 'div', 'class' => "row")),
		    ));

//			$this->addPrefixPath('Form_Decorator',  'Form/Decorator/', Zend_Form::DECORATOR);
			$this->addElementPrefixPath('Form_Validate', 'Form/Validate/', 'validate');
			$this->addElementPrefixPath('Form_Filter', 'Form/Filter/', 'filter');
		}

		public function printErrorMessages(){
			echo '<script>';
			foreach ($this->getElements() as $element){
				$errors = "<ul class=errors>";
				foreach ($element->getMessages() as $error){          
					$errors.= "<li>".$error."</li>";
				}
				$errors .= "</ul>";
				echo '$("#error_' . $element->getName() . '").html("' . $errors . '");';
			}
			echo '</script>';
		}

		public function clear(){
			$types = array(
				"Zend_Form_Element_Submit",
				"Zend_Form_Element_File",
				"Zend_Form_Element_Captcha",
				"Zend_Form_Element_Exception",
				"Zend_Form_Element_Hash",
				"Zend_Form_Element_Hidden",
				"Zend_Form_Element_Image",
				"Zend_Form_Element_Reset",
				"Zend_Form_Element_Button",
			);

			echo '<script>';
			foreach ($this->getElements() as $element){
				if(in_array($element->getType(), $types)) continue;
				echo "$(\"#".$element->getId()."\").val('');";
			}
			echo '</script>';
		}

		public function success($mes){
			$this->printErrorMessages();
			echo "<script>alert('".$mes."');</script>";
		}

		public function render(Zend_View_Interface $view = null){
            $formid = $this->getId();
            if (0 < strlen($formid)) {
                $this->setAttrib('id', "asform_".$formid);
            }

            $elements = $this->getElements();
            foreach ($elements as $element) {
                $element->setAttrib('id', "asform_".$element->getId());
                
                if($element->id == "asform_submit" && $formid == "orderform"){
                    $element->setAttrib('onclick', "_gaq.push(['_trackEvent', 'Order', 'Click_order', 'Order'])");
                }
                if($element->id == "asform_submit" && $formid == "contactform"){
                    $element->setAttrib('onclick', "_gaq.push(['_trackEvent', 'Contact', 'Contact_ask', 'Contact'])");
                }

                
            }
	        return parent::render($view);
	    }
	}
