<?php
	include_once 'database.php';
	if (isset($_REQUEST['metodo'])) {
		$metodo = $_REQUEST['metodo'];
		switch ($metodo) {
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
			 case 'carga_informacion_sitio_turistico':
				$response = carga_informacion_sitio_turistico($_REQUEST['id_post']);
				$json = array();
				$mydata = unserialize($response);
				$json[] = array('titulo'=>$mydata['name'], 'descripcion'=>$mydata['description']);
				echo json_encode($json);
				break;
			case 'carga_marcador_mapa_id':
				$response = carga_marcador_mapa_id($_REQUEST['id_categoria']);
				echo json_encode($response);
				break;
			case 'carga_promedio_sitio_turistico':
				$response = carga_promedio_sitio_turistico($_REQUEST['id_marker']);
				echo $response;
				break;
			default:
				echo 'Solicitud incorrecta.';
				break;
		}
	}
		function carga_informacion_sitio_turistico($id_post){
			$query = 'SELECT meta_value FROM tb_postmeta INNER JOIN tb_posts ON tb_posts.ID = tb_postmeta.post_id INNER JOIN tb_term_relationships ON tb_term_relationships.object_id = tb_posts.ID 
			INNER JOIN tb_term_taxonomy ON tb_term_relationships.term_taxonomy_id = tb_term_taxonomy.term_taxonomy_id 
			INNER JOIN tb_terms ON tb_terms.term_id = tb_term_taxonomy.term_id WHERE meta_key = \'cpm_point\' AND tb_posts.post_status = \'publish\' AND tb_postmeta.meta_id = ' . $id_post;
			$result = execute_sql($query);
			$data = array();
			if (mysqli_num_rows($result) > 0)
				while($row = mysqli_fetch_assoc($result))
					$data = $row['meta_value'];
			return $data;
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
		function carga_marcador_mapa_id($id_categoria){
			$query = 'SELECT meta_id FROM tb_postmeta INNER JOIN tb_posts ON tb_posts.ID = tb_postmeta.post_id INNER JOIN tb_term_relationships ON tb_term_relationships.object_id = tb_posts.ID 
			INNER JOIN tb_term_taxonomy ON tb_term_relationships.term_taxonomy_id = tb_term_taxonomy.term_taxonomy_id 
			INNER JOIN tb_terms ON tb_terms.term_id = tb_term_taxonomy.term_id WHERE meta_key = \'cpm_point\' AND tb_posts.post_status = \'publish\' AND tb_terms.term_id = ' . $id_categoria;
			$result = execute_sql($query);
			$data = array();
			if (mysqli_num_rows($result) > 0)
				while ($row = mysqli_fetch_assoc($result))
					$data[] = array('id_marker'=>$row['meta_id']);
			return $data;
		}
		function carga_promedio_sitio_turistico ($id_post) {
			$query = 'SELECT * FROM tb_postmeta WHERE meta_id = ' . $id_post . ' WHERE meta_key = \'ratings_average\'';
			$result = execute_sql($query);
			$json = array();
			if (mysqli_num_rows($result) > 0)
				while ($row = mysqli_fetch_assoc($result))
					$json[] = $row;
			return json_decode($json);
		}
?>