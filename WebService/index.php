<?php 
	include_once 'functions.php';
	if (isset($_REQUEST['metodo'])) {
		$metodo = $_REQUEST['metodo'];
		switch ($metodo) {
			case 'signup':
				signup($_REQUEST['username'], $_REQUEST['nicename'], $_REQUEST['email'], $_REQUEST['password']);
				break;
			case 'login':
				login($_REQUEST['username'], $_REQUEST['password]']);
				break;
			case 'get_user_by_username':
				get_user_by_username($_REQUEST['username']);
				break;
			case 'get_user_by_email';
				get_user_by_email($_REQUEST['email']);
				break;
			case 'get_user_by_id':
				get_user_by_id($_REQUEST['id_user']);
				break;
			case 'change_password':
				change_password($_REQUEST['username'], $_REQUEST['password']);
				break;
			case 'get_markers':
				get_markers();
				break;
			case 'get_post':
				get_post($_REQUEST['id_post']);
				break;
		}
	}
	else
		echo 'No se ha realizado solicitud http alguna.';
		
?>