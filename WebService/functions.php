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
		display_name) VALUES (\'' . $username . '\', \'' . $password . '\', \'' . $nicename . '\', \'' . $email . '\', null, NOW(), 
		null, 0, \'' . $username. '\')';
		$result = execute_sql($query);
		boolean_to_json($result);
	}
	function login($username, $password){
		$query = 'SELECT * FROM tb_users WHERE user_login = \'' . $username . '\' AND user_pass = \'' . $password . '\' AND user_status = 0';
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
		$query = 'UPDATE tb_users SET password = \'' . $password . '\' WHERE user_status = 0 AND user_login = \'' . $username . '\'';
		$result = execute_sql($query);
		boolean_to_json($result);
	}
	function get_markers(){
		$query = 'SELECT meta_value, tb_posts.ID FROM tb_postmeta INNER JOIN tb_posts ON tb_posts.ID = tb_postmeta.post_id WHERE meta_key = \'cpm_point\' AND 
		post_status = \'publish\'';
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
	function get_post($id_post){
		$query = 'SELECT * FROM tb_posts WHERE ID = ' . $id_post . ' AND post_status = \'publish\'';
		$result = execute_sql($query);
		result_to_json($result);
	}
?>