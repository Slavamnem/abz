<?php
	// Include all the necessary files depending on where they are requested from, input script or from the request handler file (/library/RequestHandler.php)
	if (LOAD_TYPE == "basic") {
		define("ROOT_DIR", "/");
		define("APP_DIR", "/app/");
	}
	if (LOAD_TYPE == "request-handler"){
		define("ROOT_DIR", "../");
		define("APP_DIR", "");
	}

	include ROOT_DIR."config/config.php";
	include ROOT_DIR."library/Helper.php";
	include ROOT_DIR."library/Image.php";
	include ROOT_DIR."library/Session.php";

	include APP_DIR."BaseObject.php";
	include APP_DIR."Worker.php";
	include APP_DIR."FillWorkers.php";
	include APP_DIR."User.php";
	include APP_DIR."Page.php";
	include APP_DIR."Application.php";
	include APP_DIR."AjaxHandler.php";
?>