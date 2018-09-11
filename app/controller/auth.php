<?
if (($args[1] == 'facebook' || $args[1] == 'google') && Func::is_ajax() && $_POST['id'] && strstr($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) {
	$id = $_POST['id'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$social = $args[1];
	
	$User = new Model_User();
	
	if(Model_User::isauth()){
		$data = array(
			$social."_id" => $id,
		);
		
		$User->update($data, array("where" => "id = '".Model_User::userid()."'"));
		echo "login";
		die();
	} else {	
		$user = $User->getone(array("where" => "`".$social."_id` = '".data_base::nq($id)."'"));
	
		if ($user->id) {
			Model_User::login($user);		
			echo "login";
		} else {
			$pass = Model_User::mkpass();

			$data = array(
				"type" => 'client',				
				"pass" => $pass,
				"email" => $email,
				"name" => $name,
				"visible" => 1,
			);
			$data[$social."_id"] = $id;
			
			$User->insert($data);
			$userid = $User->last_id();
			$user = $User->get($userid);
		
			Model_User::login($user);
			echo "register";
		}
	}
	
	die();
}
