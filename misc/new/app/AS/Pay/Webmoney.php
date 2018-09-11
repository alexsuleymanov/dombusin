<?
	class AS_Pay_Webmoney extends AS_Pay_Esystem{
//		private $purse = "Z710774029637";
		private $secret_key = "";

		public function pay(){

		}
		
		public function is_success(){
			if($_POST['LMI_PREREQUEST']==1) {
				$Order = new Model_Order();

				$order = $Order->get($_POST['LMI_PAYMENT_NO']);
				if(!$order->id){
					echo "ERR: НЕТ ТАКОГО ТОВАРА";
					exit;
				}

				if(trim($res[1]) != trim($_POST['LMI_PAYMENT_AMOUNT'])) {
					echo "ERR: НЕВЕРНАЯ СУММА ".$_POST['LMI_PAYMENT_AMOUNT'];
					exit;
				}

				if(trim($_POST['LMI_PAYEE_PURSE']) != $this->purse) {
					echo "ERR: НЕВЕРНЫЙ КОШЕЛЕК ПОЛУЧАТЕЛЯ ".$_POST['LMI_PAYEE_PURSE'];
					exit;
				}

				if(trim($_POST['LMI_MODE']) == 1){
					echo "ERR: ПЛАТЕЖ ВЫПОЛНЕН В ТЕСТОВОМ РЕЖИМЕ";
					exit;
				}

				if(!trim($_POST['email']) or trim($_POST['email'])=="") {
					echo "ERR: НЕ УКАЗАН EMAIL";
					exit;
				}
				echo "YES";
			}else{
				$common_string = $_POST['LMI_PAYEE_PURSE'].$_POST['LMI_PAYMENT_AMOUNT'].$_POST['LMI_PAYMENT_NO'].$_POST['LMI_MODE'].$_POST['LMI_SYS_INVS_NO'].$_POST['LMI_SYS_TRANS_NO'].$_POST['LMI_SYS_TRANS_DATE'].$this->secret_key.$_POST['LMI_PAYER_PURSE'].$_POST['LMI_PAYER_WM'];
				$hash = strtoupper(md5($common_string));

				if($hash != $_POST['LMI_HASH']) return false;
				return true;
			}
		}
	}
