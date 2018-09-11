<?
	class Form_Remind extends Form_Form{

		public function init(){
			global $labels, $sett;
			parent::init();

			$this->setAction("/login/remind");

			$this->setMethod('post');
			$this->setAttrib('id', 'remindform');
				
			$this->addElement('text', 'email', array(
				'required'	  => true,
				'label'       => $labels["email"],
				'value'       => $_POST['email'],
				'size'		  => 60,
				'maxlength'   => '60',
			));

	        $this->addElement('submit', 'submit', array(
	            'label'       => $labels["send"],
				'value'		  => $labels["send"],
				'decorators'  => array('ViewHelper'),
    	    ));

			$this->addDisplayGroup(
				array('email'), 'advDataGroup',
				array(
					'legend' => $labels["email"],
				)
			);

			$this->addDisplayGroup(
				array('submit'), 'buttonsGroup'
			);
		}
	}