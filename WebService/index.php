<?php
	include_once 'database.php';
	if (isset($_REQUEST['metodo'])) {
		$metodo = $_REQUEST['metodo'];
		switch ($metodo) {
			case 'inserta_usuario':
				$response = inserta_usuario($_REQUEST['id_canton'], $_REQUEST['nombre'], $_REQUEST['correo_electronico'], $_REQUEST['nombre_usuario'],
				$_REQUEST['contrasena'], $_REQUEST['tipo_usuario']);
				$array = array('ok' => (int) $response);
				echo json_encode($array);
				break;
			case 'carga_cantones':
				$response = carga_cantones($_REQUEST['id_provincia']);
				echo $response;
				break;
			case 'carga_marcador_mapa':
				$response = carga_marcador_mapa($_REQUEST['id_categoria']);
				$json = array();
				foreach($response as $data)
				{
					$mydata = unserialize($data);
					$json[] = array('titulo'=>$mydata['name'], 'descripcion'=>$mydata['address'], 'latitud'=>$mydata['latitude'], 'longitud'=>$mydata['longitude']);
				}
				echo json_encode($json);
				break;
			default:
				echo 'Solicitud incorrecta.';
				break;
		}
	}
		function carga_categorias (){
			$query = 'SELECT * FROM tb_categoria WHERE estado = 1';
			$result = execute_sql($query);
			$result = execute_sql ($query);
			$json = array();
			if (mysqli_num_rows($result) > 0)
				while ($row = mysqli_fetch_assoc($result))
					$json[] = $row;
			return json_encode($json);
		}
		function inserta_usuario ($id_canton, $nombre, $correo_electronico, $nombre_usuario, $contrasena, $tipo_usuario){
			$query = 'INSERT INTO tb_usuario (id_canton, nombre, correo_electronico, nombre_usuario, contrasena, fecha_registro, tipo_usuario,
			estado) VALUES (' . $id_canton . ', \'' . $nombre . '\', \'' . $correo_electronico . '\', \'' . $nombre_usuario . '\',
			\'' . sha1($contrasena) . '\', NOW(), \'' . $tipo_usuario . '\', \'' . $estado . '\')';
			$result = execute_sql ($query);
			return $result;
		}
		function carga_marcador_mapa ($id_categoria) {
			$query = 'SELECT meta_value FROM tb_postmeta INNER JOIN tb_posts ON tb_posts.ID = tb_postmeta.post_id INNER JOIN tb_term_relationships ON tb_term_relationships.object_id = tb_posts.ID 
			INNER JOIN tb_term_taxonomy ON tb_term_relationships.term_taxonomy_id = tb_term_taxonomy.term_taxonomy_id 
			INNER JOIN tb_terms ON tb_terms.term_id = tb_term_taxonomy.term_id WHERE meta_key = \'cpm_point\' AND tb_posts.post_status = \'publish\' AND tb_terms.term_id = ' . $id_categoria;
			$result = execute_sql($query);
			$data = array();
			if (mysqli_num_rows($result) > 0)
				while ($row = mysqli_fetch_assoc($result))
					$data[] = $row['meta_value'];
			return $data;
		}
?>