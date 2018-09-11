<?
	require_once "lib/LiqPay.php";

	class AS_Pay_Liqpay extends AS_Pay_Esystem{
		private $public_key = "i85750823577";
		private $private_key = "fGiqWRGATnONX7KPbmc3jIUTiCLu95gVRRNJmmKc";

		public function pay($params){
			global $url;
/*			$xml = "<request>
					<version>1.2</version>
					<merchant_id>".$this->merc_id."</merchant_id>
					<result_url>http://".$params['SITE_NAME']."/user/order-history</result_url>
					<server_url>http://".$params['SITE_NAME']."/order/pay-result/esystem-".$params['SITE_ESYSTEM']."/order-".$params['SITE_ORDERNUMBER']."</server_url>
					<order_id>".$params['SITE_ORDERNUMBER']."</order_id>
					<amount>".$params['SITE_PAYAMOUNT']."</amount>
					<currency>UAH</currency>
					<description>".$params['SITE_PRODDESCR']."</description>
					<default_phone></default_phone>
					<pay_way>card</pay_way>
				</request>";

			$sign=base64_encode(sha1($this->merc_sign.$xml.$this->merc_sign,1));

			$xml_encoded=base64_encode($xml); 
*/
            $liqpay = new LiqPay($this->public_key, $this->private_key);
			$html = $liqpay->cnb_form(array(
				'version'        => '3',
				'amount'         => $params['SITE_PAYAMOUNT'],
				'currency'       => $params['SITE_CURRENCY'],
				'description'    => $params['SITE_PRODDESCR'],
				'order_id'       => $params['SITE_ORDERNUMBER'],
				'result_url'	 => "http://".$_SERVER[HTTP_HOST].$url->mk('/order/completed/'.$params['SITE_ORDERNUMBER']),
				'server_url'	 => "http://".$_SERVER[HTTP_HOST].$url->mk('/order/pay-result'),
//				'result_url'	 => "http://".$_SERVER[HTTP_HOST].$url->mk('/order/pay-result'),
			));
			echo $html;
			echo "<script type=\"text/javascript\">document.forms[0].submit();</script>";
/*			echo "
				<form name=\"payform\" action=\"https://www.liqpay.com/?do=clickNbuy\" method=\"POST\" />
					<input type=\"hidden\" name=\"operation_xml\" value=\"".$xml_encoded."\" />
					<input type=\"hidden\" name=\"signature\" value=\"".$sign."\" />
				</form>
				<script type=\"text/javascript\">window.payform.submit()</script>";*/
		}
		
		public function is_success(){
			global $url;
			$data = Zend_Json::decode(base64_encode($_POST['data']));
			
			$status = $data['status'];
			$order_id = $data['order_id'];
//			print_r($data); die();
			if($status == 'success'){
//				$url->redir($url->mk("/order/completed/".$order_id));
				return true;
			}else{
				return false;
			}
		}
	}
