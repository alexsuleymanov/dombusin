<?
	class Form_Profile extends Form_Form{

		public function init(){
			global $labels, $sett, $db_prefix;
			parent::init();

			$this->setAction("/user/profile");
			$this->setMethod('post');
			$this->setAttrib('id', 'profileform');
	
			$User = new Model_User('client');
			$user = $User->get($_SESSION['userid']);

			$this->addElement('text', 'email', array(
				'required'	  => true,
				'label'       => $labels["email"],
				'size'		  => 60,
				'maxlength'   => '60',
				'value'       => $user->email,
				'validators'  => array(
					array('StringLength', true, array(0, 60)),
					array('EmailAddress', true),
				),
/*				'attribs' 	  => array(
					'readonly' => 1,
				),*/
				'class' => 'form-control',
			));

			$this->addElement('text', 'name', array(
				'required'	  => true,
				'label'       => $labels["name"],
				'size'		  => 60,
				'maxlength'   => '60',
				'value'       => ($_POST['name']) ? $_POST['name'] : $user->name,
				'validators'  => array(
					array('StringLength', true, array(0, 30))
				),
				'class' => 'form-control',
			));

			$this->addElement('text', 'surname', array(
				'required'	  => true,
				'label'       => $labels["surname"],
				'size'		  => 60,
				'maxlength'   => '60',
				'value'       => ($_POST['surname']) ? $_POST['surname'] : $user->surname,
				'validators'  => array(
					array('StringLength', true, array(0, 30))
				),
				'class' => 'form-control',
			));

			$this->addElement('text', 'phone', array(
				'required'	  => false,
				'label'       => $labels["phone"],
				'size'		  => 60,
				'maxlength'   => '60',
				'value'       => ($_POST['phone']) ? $_POST['phone'] : $user->phone,
				'validators'  => array(),
				'class' => 'form-control',
			));

			$this->addElement('text', 'city', array(
				'required'	  => false,
				'label'       => $labels["city"],
				'size'		  => 60,
				'maxlength'   => '60',
				'value'       => ($_POST['city']) ? $_POST['city'] : $user->city,
				'validators'  => array(),
				'class' => 'form-control',
			));

			$this->addElement('text', 'address', array(
				'required'	  => true,
				'label'       => $labels["address"],
				'description' => $labels["enter_real_address"],
				'size'		  => 60,
				'maxlength'   => '60',
				'value'       => ($_POST['address']) ? $_POST['address'] : $user->address,
				'validators'  => array(),
				'class' => 'form-control',
			));
			$this->address->addDecorator('Description');

	        $this->addElement('submit', 'submit', array(
	            'label'       => $labels["save"],
				'decorators'  => array('ViewHelper'),
    	    ));

			$this->addDisplayGroup(
				array('email'), 'advDataGroup',
				array(
					'legend' => $labels['aux_data'],
				)
			);

			$this->addDisplayGroup(
				array('name', 'surname', 'phone', 'city', 'address'), 'contactsDataGroup',
				array(
					'legend' => $labels['private_data'],
				)
			);

			$this->addDisplayGroup(
				array('submit'), 'buttonsGroup'
			);
		}
	}