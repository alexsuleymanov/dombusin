<?
	class Form_Adv extends Form_Form{
		public function init(){
			global $labels, $sett;
			parent::init();

			$this->setAction("/adv/add");
			$this->setMethod('post');
			$this->setAttrib('id', 'advform');
			
			$this->addElement('select', 'type', array(
				'required'	  => true,
				'label'       => 'Тип объявления:',
				'value'       => $_POST['type'],
				'multiOptions' => array(
			        '0' => 'Продажа',
			        '1' => 'Покупка',
			    ),
			));

			$AdvCat = new Model_AdvCat();
			$cats = $AdvCat->getall();
			$opt = array();
			foreach($cats as $k => $v)
				$opt[$v->id] = $v->name;

			$this->addElement('select', 'cat', array(
				'required'	  => true,
				'label'       => 'Выберите категорию:',
				'value'       => $_POST['type'],
				'multiOptions' => $opt,
			));

			$this->addElement('text', 'subj', array(
				'required'	  => true,
				'label'       => 'Тема объявления:',
				'value'       => $_POST['subj'],
				'size'		  => 60,
				'maxlength'   => '60',
				'validators'  => array(
					array('StringLength', true, array(0, 100))
				),
				'filters'     => array('StringTrim'),
			));

			$this->addElement('textarea', 'cont', array(
				'required'	  => true,
				'label'       => 'Текст объявления:',
				'rows'		  => 10,
				'cols'		  => 50,
				'value'       => $_POST['cont'],
				'validators'  => array(
					array('StringLength', true, array(10, 600))
				),
				'filters'     => array('StringTrim'),
			));

			$this->cont->addDecorator(new Form_Decorator_FCK());

			$this->addElement('textarea', 'contacts', array(
				'label'       => 'Контактная информация:',
				'rows'		  => 10,
				'cols'		  => 50,
				'value'       => $_POST['contacts'],
				'validators'  => array(
					array('StringLength', true, array(10, 600))
				),
				'filters'     => array('StringTrim'),
			));

			$this->addElement('text', 'title', array(
				'label'       => '<TITLE>:',
				'value'       => $_POST['subject'],
				'size'		  => 60,
				'maxlength'   => '60',
				'validators'  => array(
					array('StringLength', true, array(0, 300))
				),
				'filters'     => array('StringTrim'),
			));

			$this->addElement('text', 'kw', array(
				'label'       => '<KEYWORDS>:',
				'value'       => $_POST['subject'],
				'size'		  => 60,
				'maxlength'   => '60',
				'validators'  => array(
					array('StringLength', true, array(0, 300))
				),
				'filters'     => array('StringTrim'),
			));

			$this->addElement('text', 'descr', array(
				'label'       => '<DESCRIPTION>:',
				'value'       => $_POST['subject'],
				'size'		  => 60,
				'maxlength'   => '60',
				'validators'  => array(
					array('StringLength', true, array(0, 300))
				),
				'filters'     => array('StringTrim'),
			));
/*
			$this->addElement('captcha', 'captcha', array(
	            'label' => "Введите символы:",
    	        'captcha' => array(
        	        'captcha'   => 'Figlet',
            	    'wordLen'   => 5,
	                'timeout'   => 300,
    	        ),
	        ));
*/
	        $this->addElement('submit', 'submit', array(
	            'label'       => 'Добавить',
				'decorators'  => array('ViewHelper'),
    	    ));

			$this->addDisplayGroup(
				array('type', 'cat', 'subj', 'cont'), 'advDataGroup',
				array(
					'legend' => 'Объявление'
				)
			);

			$this->addDisplayGroup(
				array('contacts'), 'contactsDataGroup',
				array(
					'legend' => 'Контакты'
				)
			);

			$this->addDisplayGroup(
				array('title', 'kw', 'descr'), 'optimizeDataGroup',
				array(
					'legend' => 'Параметры оптимизации'
				)
			);

			$this->addDisplayGroup(
				array('submit'), 'buttonsGroup'
			);

                
		}
	}