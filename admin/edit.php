<?
	require("../fckeditor/fckeditor.php");

	function edit($name, $cont) {
		global $path;
		$oFCKeditor = new FCKeditor($name);
		$oFCKeditor->Value = $cont;
		$oFCKeditor->Create();		
	}
