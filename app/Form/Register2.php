<?
	class Form_Register2 extends Form_Form{

		public function init(){
			global $labels, $sett, $db_prefix, $url, $path;
			parent::init();

			$this->setAction("/order/new-user");

			$this->setMethod('post');
			$this->setAttrib('id', 'registerform');
	
			if($_GET["redirect"])
				$this->addElement('hidden', 'redirect', array(
					'required'	  => false,
					'label'       => '',
					'value'       => $_GET["redirect"],
				));

			$this->addElement('text', 'email', array(
				'required'	  => true,
				'label'       => $labels["email"],
				'size'		  => 60,
				'maxlength'   => '60',
				'value'       => $_POST['email'],
				'validators'  => array(
					array('StringLength', true, array(0, 60)),
					array('EmailAddress', true),
					array('UniqueEmail', true)
				),
			));

			$this->addElement('text', 'name', array(
				'required'	  => true,
				'label'       => $labels["name"],
				'size'		  => 60,
				'maxlength'   => '60',
				'value'       => $_POST['name'],
				'validators'  => array(
					array('StringLength', true, array(0, 30))
				),
			));

			$this->addElement('text', 'phone', array(
				'required'	  => true,
				'label'       => $labels["phone"],
				'size'		  => 60,
				'maxlength'   => '60',
				'value'       => $_POST['phone'],
				'validators'  => array(),
			));

	        $this->addElement('submit', 'submit', array(
	            'label'       => $labels["register_go"],
				'decorators'  => array('ViewHelper'),
    	    ));

			$this->addDisplayGroup(
				array('email', 'name', 'phone'), 'contactsDataGroup',
				array(
					'legend' => $labels['private_data']
				)
			);

			$this->addDisplayGroup(
				array('captcha', 'submit'), 'buttonsGroup'
			);
		}
	}