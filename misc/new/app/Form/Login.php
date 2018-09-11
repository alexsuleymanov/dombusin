<?
	class Form_Login extends Form_Form{

		public function init(){
			global $labels, $sett, $url;
			parent::init();

			$this->setAction("/login");

			$this->setMethod('post');
			$this->setAttrib('id', 'loginform');

			if($_GET["redirect"])
				$this->addElement('hidden', 'redirect', array(
					'required'	  => false,
					'label'       => '',
					'value'       => $_GET["redirect"],
				));

			$this->addElement('text', 'login', array(
				'required'	  => true,
				'label'       => "E-mail",
				'value'       => $_POST['login'],
				'size'		  => 45,
				'maxlength'   => '45',
			));

			$this->addElement('password', 'pass', array(
				'required'	  => true,
				'label'       => $labels["password"],
				'value'       => $_POST['pass'],
				'size'		  => 45,
				'maxlength'   => '45',
			));

	        $this->addElement('submit', 'submit', array(
	            'label'       => $labels["sign_in"],
				'value'		  => $labels["sign_in"],
				'decorators'  => array('ViewHelper'),
    	    ));

			$this->addDisplayGroup(
				array('login', 'pass'), 'advDataGroup',
				array(
					'legend' => $labels["login_password"],
				)
			);

			$this->addDisplayGroup(
				array('submit'), 'buttonsGroup'
			);
		}
	}