<?
	class Form_Register extends Form_Form{

		public function init(){
			global $labels, $sett, $db_prefix, $url, $path;
			parent::init();

			$this->setAction("/register");

			$this->setMethod('post');
			$this->setAttrib('id', 'registerform');
	
			if($_GET["redirect"])
				$this->addElement('hidden', 'redirect', array(
					'required'	  => false,
					'label'       => '',
					'value'       => $_GET["redirect"],
				));

/*			$this->addElement('text', 'login', array(
				'required'	  => true,
				'label'       => $labels["login"],
				'value'       => $_POST['login'],
				'size'		  => 60,
				'maxlength'   => '60',
				'validators'  => array(
					array('StringLength', true, array(3, 60)),
					array('UniqueLogin', true)
				),
			));
			$this->login->addDecorator('Description');
*/
			$this->addElement('password', 'pass', array(
				'required'	  => true,
				'label'       => $labels["password"],
				'value'       => "",
				'size'		  => 25,
				'maxlength'   => '25',
				'validators'  => array(
					array('StringLength', true, array(6, 60))
				),
				'class' => 'form-control',
			));

			$this->addElement('password', 'pass2', array(
				'required'	  => true,
				'label'       => $labels["repeat_password"],
				'value'       => "",
				'size'		  => 25,
				'maxlength'   => '25',
				'validators'  => array(
					array('StringLength', true, array(6, 60))
				),
				'class' => 'form-control',
			));

			$this->pass2->addValidator(new Form_Validate_EqualValues('pass'));

			$this->addElement('text', 'email', array(
				'required'	  => true,
				'label'       => $labels["email"],
				'size'		  => 25,
				'maxlength'   => '60',
				'value'       => $_POST['email'],
				'validators'  => array(
					array('StringLength', true, array(0, 60)),
					array('EmailAddress', true),
					array('UniqueEmail', true)
				),
				'class' => 'form-control',
			));

			$this->addElement('text', 'name', array(
				'required'	  => true,
				'label'       => $labels["name"],
				'size'		  => 25,
				'maxlength'   => '25',
				'value'       => $_POST['name'],
				'validators'  => array(
					array('StringLength', true, array(0, 30))
				),
				'class' => 'form-control',
			));

			$this->addElement('text', 'surname', array(
				'required'	  => true,
				'label'       => $labels["surname"],
				'size'		  => 25,
				'maxlength'   => '25',
				'value'       => $_POST['surname'],
				'validators'  => array(
					array('StringLength', true, array(0, 30))
				),
				'class' => 'form-control',
			));

			$this->addElement('text', 'phone', array(
				'required'	  => true,
				'label'       => $labels["phone"],
				'size'		  => 25,
				'maxlength'   => '25',
				'value'       => $_POST['phone'],
				'validators'  => array(
					array('StringLength', true, array(0, 30))
				),
				'class' => 'form-control',
			));

/*			$this->addElement('select', 'gender', array(
				'required'	  => true,
				'label'       => "Пол",
				'value'       => "m",
				'multiOptions' => array("m" => "Мужчина", "f" => "Женщина"),
			));*/

/*
			$this->addElement('text', 'phone', array(
				'required'	  => false,
				'label'       => $labels["phone"],
				'size'		  => 60,
				'maxlength'   => '60',
				'value'       => $_POST['phone'],
				'validators'  => array(),
			));

			$this->addElement('text', 'city', array(
				'required'	  => false,
				'label'       => $labels["city"],
				'size'		  => 60,
				'maxlength'   => '60',
				'value'       => $_POST['city'],
				'validators'  => array(),
			));

			$this->addElement('text', 'address', array(
				'required'	  => true,
				'label'       => $labels["address"],
				'size'		  => 60,
				'maxlength'   => '60',
				'value'       => $_POST['address'],
				'validators'  => array(),
			));

			$this->addElement('captcha', 'captcha', array(
	            'label' => "Введите символы:",
    	        'captcha' => array(
        	        'captcha'   => 'Image',
					'font' 		=> $path.'/app/view/img/font/Arial.ttf',
					'fontsize' 	=> '30',
					'imgDir' 	=> $path.'/pic/captcha',
					'imgUrl' 	=> 'https://'.$_SERVER['HTTP_HOST'].'/pic/captcha/',
            	    'wordLen'   => 5,
	                'timeout'   => 300,
    	        ),
		    ));
			$this->captcha->removeDecorator('ViewHelper');
*/
	        $this->addElement('submit', 'submit', array(
	            'label'       => $labels["register_go"],
				'decorators'  => array('ViewHelper'),
                'onlick'      => "_gaq.push(['_trackEvent', 'Register_send', 'Register_account', 'Register_send'])",
    	    ));

			$this->addDisplayGroup(
				array('name', 'surname', 'email', 'phone', 'pass', 'pass2', 'submit'), 'advDataGroup',
				array(
					'legend' => ""
				)
			);

			/*$this->addDisplayGroup(
				array('submit'), 'buttonsGroup'
			);*/
		}
	}
