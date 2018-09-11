<?
	class Form_Comment extends Form_Form{
		public function init(){
			global $labels, $sett, $view;
			parent::init();

			$this->setAction("/comments");
			$this->setMethod('post');
			$this->setAttrib('id', 'contactform');
			
			$this->addElement('hidden', 'type', array(
				'required'	  => false,
				'label'       => '',
				'value'       => 'prod',
			));

			$this->addElement('hidden', 'par', array(
				'required'	  => false,
				'label'       => '',
				'value'       => $view->prod->id,
			));

			$this->addElement('text', 'author', array(
				'required'	  => true,
				'label'       => $labels["author"],
				'size'		  => 60,
				'maxlength'   => '60',
				'value'       => $_POST['author'],
				'validators'  => array(
					array('StringLength', true, array(2, 60)),
				),
			));
			$this->author->addDecorator(new Form_Decorator_AjaxError());

			$this->addElement('textarea', 'cont', array(
				'required'	  => true,
				'label'       => $labels['message'],
				'rows'		  => 10,
				'cols'		  => 50,
				'value'       => $_POST['cont'],
				'validators'  => array(
					array('StringLength', true, array(10, 600))
				),
			));
			$this->cont->addDecorator(new Form_Decorator_AjaxError());

	        $this->addElement('submit', 'submit', array(
	            'label'       => $labels["send"],
				'decorators'  => array('ViewHelper'),
    	    ));

			$this->addDisplayGroup(
				array('author', 'cont', 'submit'), 'buttonsGroup',
				array(
					'legend' => $labels["add_comment"],
				)

			);
		}
	}