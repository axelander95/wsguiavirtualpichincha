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
			case 'inserta_categoria':
				$response = inserta_categoria($_REQUEST['descripcion']);
				$array = array('ok' => (int) $response);
				echo json_encode($array);
				break;
			case 'actualiza_elimina_categoria':
				$response = actualiza_elimina_categoria($_REQUEST['id_categoria'], $_REQUEST('descripcion'), $_REQUEST['estado']);
				$array = array('ok' => (int) $response);
				echo json_encode($array);
				break;
			case 'inicia_sesion':
				$response = inicia_sesion($_REQUEST['nombre_usuario'], $_REQUEST['contrasena']);
				echo $response;
				break;
			case 'califica_sitio':
				$response = califica_sitio($_REQUEST['id_sitio_turistico'], $_REQUEST['id_usuario'], $_REQUEST['valor']);
				$array = array('ok' => (int) $response);
				echo json_encode($array);
				break;
			default:
				echo 'Solicitud incorrecta.';
				break;
		}
	}
		function inserta_usuario ($id_canton, $nombre, $correo_electronico, $nombre_usuario, $contrasena, $tipo_usuario){
			$query = 'INSERT INTO tb_usuario (id_canton, nombre, correo_electronico, nombre_usuario, contrasena, fecha_registro, tipo_usuario,
			estado) VALUES (' . $id_canton . ', \'' . $nombre . '\', \'' . $correo_electronico . '\', \'' . $nombre_usuario . '\',
			\'' . sha1($contrasena) . '\', NOW(), \'' . $tipo_usuario . '\', \'' . $estado . '\')';
			$result = execute_sql ($query);
			return $result;
		}
		function inserta_categoria ($descripcion){
			$query = 'INSERT INTO tb_categoria (descripcion, estado) VALUES (\'' . $descripcion . '\', 1)';
			$result = execute_sql($query);
			return $result;
		}
		function actualiza_elimina_categoria ($id_categoria, $descripcion, $estado) {
			$query = 'UPDATE tb_categoria SET descripcion = \'' . $descripcion . '\', estado = ' . $estado . ' WHERE id_categoria = ' . $id_categoria;
			$result = execute_sql($query);
			return $result;
		}
		function inicia_sesion ($nombre_usuario, $contrasena){
			$query = 'SELECT * FROM tb_usuario WHERE nombre_usuario = \'' . $nombre_usuario . '\' AND contrasena = \'' . sha1($contrasena) . '\'';
			$result = execute_sql ($query);
			$json = array();
			if (mysqli_num_rows($result) > 0)
				while ($row = mysqli_fetch_assoc($result))
					$json[] = $row;
			return json_encode($json);
		}
		function califica_sitio ($id_sitio_turistico, $id_usuario, $valor){
			$query = 'SELECT * FROM tb_calificacion_sitio WHERE id_sitio_turistico = ' . $id_sitio_turistico . ' AND id_usuario = ' . $id_usuario;
			$select = execute_sql($query);
			if (mysqli_num_rows($select) > 0)
				$query = 'UPDATE tb_calificacion_sitio SET valor = ' . $valor . ' WHERE id_sitio_turistico = ' . $id_sitio_turistico . ' AND 
				id_usuario = ' . $id_usuario;
			else 
				$query = 'INSERT INTO tb_calificacion_sitio (id_sitio_turistico, id_usuario, valor) VALUES (' . $id_sitio_turistico . ', ' . $id_usuario . ',
				' . $valor . ')';
			$result = execute_sql($query);
			return $result;
		}
?>