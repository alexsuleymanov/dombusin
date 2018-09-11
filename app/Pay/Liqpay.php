<?
	class Pay_Liqpay extends Pay_Esystem{
		private $merc_id = "";
		private $merc_sign = "";

		public function pay($params){
			$xml = "<request>
					<version>1.2</version>
					<merchant_id>".$this->merc_id."</merchant_id>
					<result_url>https://".$params['SITE_NAME']."/user/order-history</result_url>
					<server_url>https://".$params['SITE_NAME']."/order/pay-result/esystem-".$params['SITE_ESYSTEM']."/order-".$params['SITE_ORDERNUMBER']."</server_url>
					<order_id>".$params['SITE_ORDERNUMBER']."</order_id>
					<amount>".$params['SITE_PAYAMOUNT']."</amount>
					<currency>UAH</currency>
					<description>".$params['SITE_PRODDESCR']."</description>
					<default_phone></default_phone>
					<pay_way>card</pay_way>
				</request>";

			$sign=base64_encode(sha1($this->merc_sign.$xml.$this->merc_sign,1));

			$xml_encoded=base64_encode($xml); 

			echo "
				<form name=\"payform\" action=\"https://www.liqpay.com/?do=clickNbuy\" method=\"POST\" />
					<input type=\"hidden\" name=\"operation_xml\" value=\"".$xml_encoded."\" />
					<input type=\"hidden\" name=\"signature\" value=\"".$sign."\" />
				</form>
				<script type=\"text/javascript\">window.payform.submit()</script>";
		}
		
		public function is_success(){
			global $path;
            $xml = base64_decode($_POST['operation_xml']);

			$vals = array();
			$xml_parser = xml_parser_create('utf-8');

/*			$ff = fopen($path."/tmp/log.txt", "w");
			foreach($_POST as $k => $v){
				fwrite($ff, "_POST[".$k."] = ".$v."\n\n");
			}
			fwrite($ff, $xml);
			fclose($ff);
*/

			xml_parse_into_struct($xml_parser, $xml, $vals);
			xml_parser_free($xml_parser);

			$sign = base64_encode(sha1($this->merc_sign.$xml.$this->merc_sign, 1));
			if($sign == $_POST['signature']){
				foreach($vals as $k => $v){
					if(strtolower($v['tag']) == "status" && $v['value'] == 'success') return true;
					elseif(strtolower($v['tag']) == "status" && $v['value'] == 'failure') return false;
					elseif(strtolower($v['tag']) == "status" && $v['value'] == 'wait_secure') return true;

				}
			}
		}
	}
