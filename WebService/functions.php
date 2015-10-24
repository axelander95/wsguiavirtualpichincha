<?php 
	include_once 'database.php';
	function result_column_to_json($result, $column){
		$data = array();
		if (mysqli_num_rows($result) > 0)
			while ($row = mysqli_fetch_assoc($result))
				$data[] = array_map('utf8_encode', $row[$column]);
		echo json_encode($data);
	}
	function result_to_json($result){
		$json = array();
		if (mysqli_num_rows($result) > 0)
			while ($row = mysqli_fetch_assoc($result))
				$json[] = array_map('utf8_encode', $row);
		echo json_encode($json);
	}
	function boolean_to_json($result) {
		echo json_encode(array('ok'=>($result)?'yes':'no'));
	}
	function signup($username, $nicename, $email, $password){
		$query = 'INSERT INTO tb_users (user_login, user_pass, user_nicename, user_email, user_url, user_registered, user_activation_key ,user_status, 
		display_name) VALUES (\'' . $username . '\', \'' . sha1($password) . '\', \'' . clean($nicename) . '\', \'' . $email . '\', \'\', NOW(), 
		\'\', 0, \'' . $username. '\')';
		$result = execute_sql($query);
		boolean_to_json($result);
	}
	function login($username, $password){
		$query = 'SELECT * FROM tb_users WHERE user_login = \'' . $username . '\' AND user_pass = \'' . sha1($password) . '\' AND user_status = 0';
		$result = execute_sql($query);
		result_to_json($result);
	}
	function get_user_by_username($username){
		$query = 'SELECT * FROM tb_users WHERE user_login = \'' . $username . '\' AND user_status = 0';
		$result = execute_sql($query);
		result_to_json($result);
	}
	function get_user_by_email($email){
		$query = 'SELECT * FROM tb_users WHERE user_email = \'' . $email . '\' AND user_status = 0';
		$result = execute_sql($query);
		result_to_json($result);
	}
	function get_user_by_id($id_user){
		$query = 'SELECT * FROM tb_users WHERE ID = ' . $id_user;
		$result = execute_sql($query);
		result_to_json($result);
	}
	function change_password($username, $password){
		$query = 'UPDATE tb_users SET user_pass = \'' . $password . '\' WHERE user_status = 0 AND user_login = \'' . $username . '\'';
		$result = execute_sql($query);
		boolean_to_json($result);
	}
	function get_markers(){
		$query = 'SELECT meta_value, tb_posts.ID FROM tb_postmeta 
		INNER JOIN tb_posts ON tb_posts.ID = tb_postmeta.post_id 
		WHERE meta_key = \'cpm_point\' AND tb_posts.post_status = \'publish\'';
		$result = execute_sql($query);
		$meta_value = array();
		$id = array();
		$categoria = array();
		if (mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$meta_value[] = $row['meta_value'];
				$id[] = array('id'=>$row['ID']);
				$categoria[] = array('id_categoria'=>$row['term_id']);
			}
		}
		$serialized = array();
		$json = array();
		foreach($meta_value as $value){
			$fixed_serialized_data = preg_replace_callback ( '!s:(\d+):"(.*?)";!',
				function($match) {
					return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
				},
			$value );
			$serialized = unserialize($fixed_serialized_data);
			$json[] = array('title'=>$serialized['name'], 'description'=>$serialized['address'], 'latitude'=>$serialized['latitude'], 
			'longitude'=>$serialized['longitude']);
		}
		echo json_encode(array_merge($json, $id, $categoria));
	}
	function get_markers_by_category($id_categoria){
		$query = 'SELECT meta_value, tb_posts.ID FROM tb_postmeta INNER JOIN tb_posts ON tb_posts.ID = tb_postmeta.post_id 
		INNER JOIN tb_term_relationships ON object_id = tb_posts.ID 
		INNER JOIN tb_term_taxonomy ON tb_term_taxonomy.term_taxonomy_id = tb_term_relationships.term_taxonomy_id 
		INNER JOIN tb_terms ON tb_terms.term_id = tb_term_taxonomy.term_id 
		WHERE meta_key = \'cpm_point\' AND tb_posts.post_status = \'publish\' AND tb_terms.term_id = ' . $id_categoria;
		$result = execute_sql($query);
		$meta_value = array();
		$id = array();
		if (mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$meta_value[] = $row['meta_value'];
				$id[] = array('id'=>$row['ID']);
			}
		}
		$serialized = array();
		$json = array();
		foreach($meta_value as $value){
			$fixed_serialized_data = preg_replace_callback ( '!s:(\d+):"(.*?)";!',
				function($match) {
					return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
				},
			$value );
			$serialized = unserialize($fixed_serialized_data);
			$json[] = array('title'=>$serialized['name'], 'description'=>$serialized['address'], 'latitude'=>$serialized['latitude'], 
			'longitude'=>$serialized['longitude']);
		}
		echo json_encode(array_merge($json, $id));
	}
	function add_post($id_user, $post_title, $post_content) {
		$query = 'INSERT INTO tb_posts (post_author, post_date, post_date_gmt, post_content, post_title, post_status, comment_status,
		ping_status, post_name, post_modified, post_modified_gmt, post_parent, menu_order, post_type, comment_count) VALUES (
		\'' . $id_user . '\', NOW(), NOW(), \'' . $post_content . '\', \'' . $post_title . '\', \'publish\', \'open\', \'open\', 
		\'' . clean($post_title) . '\', NOW(), NOW(), 0, 0, \'post\', 0)';
		$query2 = 'SELECT LAST_INSERT_ID() AS ID';
		$result = execute_multiple_queries($query, $query2);
		$id = null;
		if (mysqli_num_rows($result) > 0)
			while($row = mysqli_fetch_assoc($result))
				$id = $row['ID'];
		$query = 'UPDATE tb_posts SET guid = \'' . $_SERVER['SERVER_NAME'] . '/wsguiavirtualpichincha/WebApp/wp-content/uploads/?p=' . $id . '\' WHERE ID = ' . $id;
		$result = execute_sql($query);
		echo json_encode(array('id_post'=>$id));
	}
	function get_post($id_post){
		$query = 'SELECT * FROM tb_posts INNER JOIN (SELECT guid AS url_imagen FROM tb_posts 
		WHERE ID IN (SELECT meta_value FROM tb_postmeta WHERE post_id = ' . $id_post . ' AND meta_key = \'_thumbnail_id\' )) AS tb_imagen 
		WHERE tb_posts.ID = ' . $id_post;
		$result = execute_sql($query);
		result_to_json($result);
	}
	function get_post_images($id_post){
		$query = 'SELECT guid FROM tb_posts WHERE post_type =  \'attachment\' AND post_parent = ' . $id_post
		$result = execute_sql($query);
		result_to_json($result);
	}
	function delete_image($id_post){
		$query = 'DELETE FROM tb_postmeta WHERE post_id = ' . $id_post . ' AND meta_key = \'_thumbnail_id\'';
		$result = execute_sql($query);
		echo boolean_to_json($result);
	}
	function get_comments($id_post){
		$query = 'SELECT * FROM tb_comments WHERE comment_post_ID = ' . $id_post . ' AND comment_approved = 1';
		$result = execute_sql($query);
		result_to_json($result);
	}
	function comment_post($id_post, $username, $id_user ,$comment){
		$query = 'INSERT INTO tb_comments (comment_post_ID, comment_author, comment_date, comment_date_gmt, comment_content, comment_karma, 
		comment_approved, comment_agent, comment_parent, user_id) VALUES (' . $id_post . ', \'' . $username . '\', NOW(), NOW(), \'' . $comment . '\',
		0, 1, \'cell phone\', 0, ' . $id_user . ')';
		$result = execute_sql($query);
		boolean_to_json($result);
	}
	function qualify($id_user, $qualification){
		
	}
	function get_average(){
		
	}
	function clean($string) {
	   $string = str_replace(' ', '-', $string);

	   return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
	}
	function upload_image($file, $id_user, $id_post){
		$directory = $_SERVER['SERVER_NAME'] . '/wsguiavirtualpichincha/WebApp/wp-content/uploads/';
		$filename = uniqid() . basename($file['file']['name']);
		$guid = $directory . clean($filename);
		$url = $directory . $filename;
		$extension = pathinfo($url, PATHINFO_EXTENSION);
		$size = $file['file']['size'];
		$tempfile = $file['file']['tmp_name'];
		if (!isImage($tempfile))
			echo json_encode(array('ok'=>'no', 'mensaje'=>'El archivo ' . $filename . ' no es una imagen.'));
		else {
			if (file_exists($url))
				echo json_encode(array('ok'=>'no', 'mensaje'=>'El archivo ya existe.'));
			else if ($size > (4 * 500000))
				echo json_encode(array('ok'=>'no', 'mensaje'=>'El archivo excede el límite de 2mb.'));
			else if ($extension != 'jpg' && $extension != 'png' && $extension != 'bmp' && $extension != 'gif')
				echo json_encode(array('ok'=>'no', 'mensaje'=>'Sólo se permite archivos de extensión jpg, png, bmp o gif.'));
			else{
				$done = move_uploaded_file($tempfile, $url);
				if ($done){
					echo json_encode(array('ok'=>'si', 'mensaje'=>'Transferencia exitosa.', 'filename'=> $filename));
					$query1 = 'INSERT INTO tb_posts (post_author, post_date, post_date_gmt, post_content, post_title, post_status, comment_status,
					ping_status, post_name, post_modified, post_modified_gmt, post_parent guid, menu_order, post_type, post_mime_type, comment_count) VALUES (
					' . $id_user . ', NOW(), NOW(), \'empty\', \'' . clean($filename) . '\', \'inherit\', \'open\', \'closed\', 
					\'' . clean($post_title) . '\', NOW(), NOW(), 0, \'' . $guid . '\' , 0, \'attachment\', \'' . $file['file']['type'] . '\', 0)';
					$query2 = 'SELECT LAST_INSERT_ID() AS ID';
					$result = execute_multiple_queries($query, $query2);
					$id = null;
					if (mysqli_num_rows($result) > 0)
						while($row = mysqli_fetch_assoc($result))
							$id = $row['ID'];
					$query = 'INSERT INTO tb_postmeta (post_id, meta_key, meta_value) VALUES (' . $id_post . ', \'_thumbnail_id\', ' . $id . ')';
					$result = execute_query($query);
					boolean_to_json($result);
				}
				else
					echo json_encode(array('ok'=>'no', 'mensaje'=>'Hubo un error, intente nuevamente.'));
			}
		}
	}
	function isImage ($filename){
		return getimagesize($filename);
	}
	function get_image($filename){
		$url = $_SERVER['DOCUMENT_ROOT'] . 'wsguiavirtualpichincha/WebApp/wp-content/uploads/' . $filename;
		if (file_exists($url)){
			$type = pathinfo($url, PATHINFO_EXTENSION);
			$data = file_get_contents($url);
			$base64 = base64_encode($data);
			echo json_encode(array('image'=>$base64, 'type'=>$type));
		}
		else
			echo json_encode(array('image'=>null));
	}
	function get_image2($filename){
		$url = $_SERVER['DOCUMENT_ROOT'] . 'wsguiavirtualpichincha/WebApp/wp-content/uploads/' . $filename;
		echo $url;
		if (file_exists($url)){
			header('Content-Disposition: attachment; filename='.basename($url));
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($url));
			ob_clean();
			flush();
			echo json_encode(array ('image'=>readfile($url)));
		}
		else
			echo json_encode(array('image'=>null));
	}
?>