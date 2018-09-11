<?
	class Form_ChangePass extends Form_Form{

		public function init(){
			global $labels, $sett;
			parent::init();

			$this->setAction("/user/change-pass");
			$this->setMethod('post');
			$this->setAttrib('id', 'changepassform');
				
			$this->addElement('password', 'pass', array(
				'required'	  => true,
				'label'       => $labels["password"],
				'value'       => $_POST['pass'],
				'size'		  => 60,
				'maxlength'   => '60',
			));

			$this->addElement('password', 'pass2', array(
				'required'	  => true,
				'label'       => $labels["repeat_password"],
				'value'       => "",
				'size'		  => 60,
				'maxlength'   => '60',
				'validators'  => array(
					array('StringLength', true, array(6, 60))
				),
			));

			$this->pass2->addValidator(new Form_Validate_EqualValues('pass'));

	        $this->addElement('submit', 'submit', array(
	            'label'       => $labels["save"],
				'value'		  => $labels["save"],
				'decorators'  => array('ViewHelper'),
    	    ));

			$this->addDisplayGroup(
				array('pass', 'pass2'), 'advDataGroup',
				array(
					'legend' => $labels["new_password"],
				)
			);

			$this->addDisplayGroup(
				array('submit'), 'buttonsGroup'
			);
		}
	}