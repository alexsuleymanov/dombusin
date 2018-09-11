<?
	class Form_Filter_Translit implements Zend_Filter_Interface{
	    public function filter($value){
			return Func::translit($value);
    	}
	}