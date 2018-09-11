<?
	class Form_Order extends Form_Form{

		public function init(){
			global $labels, $sett, $db_prefix, $url;
			parent::init();

			$this->setAction("/order".$url->gvar("lkhylaskdghl="));
			$this->setMethod('post');
			$this->setAttrib('id', 'orderform');
	
			$User = new Model_User('client');
			$user = $User->get($_COOKIE['userid']);

			$this->addElement('hidden', 'subm', array(
				'required'	  => false,
				'label'       => '',
				'value'       => "1",
			));

			$this->addElement('text', 'email', array(
				'required'	  => true,
				'label'       => $labels["email"],
				'size'		  => 45,
				'maxlength'   => '45',
				'value'       => ($_POST['email']) ? $_POST['email'] : $user->email,
				'validators'  => array(
					array('StringLength', true, array(0, 60)),
					array('EmailAddress', true),
				),
			));
			if($_COOKIE['userid']){
				$this->email->setAttrib('readonly', 1);
			}else{
        		//$this->email->addValidator('UniqueEmail');
			}

			if(!$_COOKIE['userid']){
				$this->addElement('password', 'password', array(
					'required'	  => false,
					'label'       => $labels["password"],
					'description' => "Пароль только для новых клиентов",
					'size'		  => 45,
					'maxlength'   => '45',
					'value'       => "",
					'validators'  => array(
						array('StringLength', true, array(5, 60)),
					),
				));
				$this->password->addDecorator('Description');
			}
			
			
			$this->addElement('text', 'name', array(
				'required'	  => true,
				'label'       => $labels["name"],
				'size'		  => 45,
				'maxlength'   => '45',
				'value'       => ($_POST['name']) ? $_POST['name'] : $user->name,
				'validators'  => array(
					array('StringLength', true, array(0, 30))
				),
			));

			$this->addElement('text', 'surname', array(
				'required'	  => true,
				'label'       => $labels["surname"],
				'size'		  => 45,
				'maxlength'   => '45',
				'value'       => ($_POST['surname']) ? $_POST['surname'] : $user->surname,
				'validators'  => array(
					array('StringLength', true, array(0, 30))
				),
			));

			$this->addElement('text', 'phone', array(
				'required'	  => true,
				'label'       => $labels["phone"],
				'description' => $labels["enter_real_phone"],
				'size'		  => 45,
				'maxlength'   => '45',
				'value'       => ($_POST['phone']) ? $_POST['phone'] : $user->phone,
				'validators'  => array(),
			));
			$this->phone->addDecorator('Description');

			$this->addElement('text', 'city', array(
				'required'	  => true,
				'label'       => $labels["city"],
				'size'		  => 45,
				'maxlength'   => '45',
				'value'       => ($_POST['city']) ? $_POST['city'] : $user->city,
				'validators'  => array(),
			));

			$this->addElement('text', 'address', array(
				'required'	  => false,
				'label'       => $labels["address"],
				'description' => $labels["enter_real_address"],
				'size'		  => 45,
				'maxlength'   => '45',
				'value'       => ($_POST['address']) ? $_POST['address'] : $user->address,
				'validators'  => array(),
			));
			$this->address->addDecorator('Description');

			$this->addElement('textarea', 'comment', array(
				'required'	  => false,
				'label'       => "Комментарий к заказу",
				'rows'		  => 7,
				'cols'		  => 45,
				'value'       => $_POST['comment'],
				'validators'  => array(
					array('StringLength', true, array(0, 600))
				),
			));

			$Cart = new Model_Cart();			
			$Esystem = new Model_Esystem();
			$esystems = $Esystem->getall(array("where" => "visible = 1", "order" => "prior desc, name"));
			$esys = array();
			foreach($esystems as $k => $v)
				if($v->minsum <= $Cart->amount()) $esys[$v->id] = $v->name;

			$this->addElement('select', 'esystem', array(
				'required'	  => true,
				'label'       => $labels["payment_method"],
				'description' => "Заказы, на сумму до 200 грн. отправляются только по предоплате",
				'value'       => $_POST['esystem'],
				'multiOptions' => $esys,
			));
			if($Cart->amount() < 200) $this->esystem->addDecorator('Description');

			$Delivery = new Model_Delivery();
			$delivery = $Delivery->getall(array("where" => "visible = 1", "order" => "prior desc, name"));
			$delivs = array();
			foreach($delivery as $k => $v)
				$delivs[$v->id] = $v->name;

			$this->addElement('select', 'delivery', array(
				'required'	  => true,
				'label'       => $labels["delivery_method"],
				'value'       => $_POST['delivery'],
				'multiOptions' => $delivs,
			));

			$this->addElement('text', 'sklad', array(
				'required'	  => false,
				'label'       => "Номер склада",
				'size'		  => 45,
				'maxlength'   => '45',
				'value'       => $_POST['sklad'],
				'validators'  => array(
					array('StringLength', true, array(0, 30))
				),
			));

//			if(!$_COOKIE['userid'])
	        $this->addElement('submit', 'submit', array(
	            'label'       => $labels["confirm"],
				'decorators'  => array('ViewHelper'),
    	    ));

			$this->addDisplayGroup(
				array('email', 'password', 'name', 'surname', 'phone', 'city', 'address', 'comment'), 'advDataGroup',
				array(
					'legend' => "",
				)
			);

			$this->addDisplayGroup(
				array('esystem', 'delivery', 'sklad'), 'paymentDataGroup',
				array(
					'legend' => ""
				)
			);

	//		if(!$_COOKIE['userid'])
			$this->addDisplayGroup(
				array('submit'), 'buttonsGroup'
			);

		}
	}