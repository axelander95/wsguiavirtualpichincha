<?php 
	include_once 'functions.php';
	if (isset($_REQUEST['metodo'])) {
		$metodo = $_REQUEST['metodo'];
		switch ($metodo) {
			case 'signup':
				signup($_REQUEST['username'], $_REQUEST['username'], $_REQUEST['email'], $_REQUEST['password']);
				break;
			case 'login':
				login($_REQUEST['username'], $_REQUEST['password']);
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
			case 'get_markers_by_category':
				get_markers_by_category($_REQUEST['id_categoria']);
				break;
			case 'add_post':
				add_post($_REQUEST['id_user'], $_REQUEST['post_title'], $_REQUEST['post_content']);
				break;
			case 'get_post':
				get_post($_REQUEST['id_post']);
				break;
			case 'get_comments':
				get_comments($_REQUEST['id_post']);
				break;
			case 'comment_post':
				comment_post($_REQUEST['id_post'], $_REQUEST['username'], $_REQUEST['id_user'], $_REQUEST['comment']);
				break;
			case 'qualify':
				qualify($_REQUEST['id_usuario'], $_REQUEST['qualification']);
				break;
			case 'get_average':
				get_average();
				break;
			case 'upload_image':
				upload_image($_FILES, $_REQUEST['id_user'], $_REQUEST['id_post']);
				break;
			case 'get_image':
				get_image($_REQUEST['filename']);
				break;
		}
	}
	else
		echo 'No se ha realizado solicitud http alguna.';
		
?>