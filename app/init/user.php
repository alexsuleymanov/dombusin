<?
	if(!Model_User::isauth()){
		Model_User::authfromcookie();
	}