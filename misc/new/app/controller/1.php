<?php
$cart = array("asfaksdhlashg" => array("id" => 1, "var" => 0, "price" => 23.5), "asfaksdhlashg525" => array("id" => 2, "var" => 1, "price" => 22.5), "asfaksdhlashasdfsag" => array("id" => 3, "var" => 0, "price" => 24.5));

print_r($cart2);
print_r($cart);

$sess = md5(time());
$cart2 = serialize($cart);
$ff = fopen($path."/sessions/cart/".$sess, "w");
fwrite($ff, $cart2);
fclose($ff);

$cart4 = file_get_contents($path."/sessions/cart/".$sess);
$cart5 = unserialize($cart4);
	
echo "<p>!!!!!!!!!!!!!!!!!!!<p>";
print_r($cart5);

die();

echo 222; 
die();
$User = new Model_User();

$i = 0;

if (($handle = fopen($path."/phones.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
		if(empty($data[0]) || empty($data[4])) continue;
		echo $data[0].": ".$data[4]."<br>";
		$q = "update dombusin_user set phone = '".$data[4]."' where id = ".$data[0].";\n";

		if (++$i > 100) {
			$i = 0;			
			$User->mq($q);
			$q = '';
		}
    }
    fclose($handle);
}