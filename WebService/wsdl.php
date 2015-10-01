<?php
	include_once 'database.php';
	class WSGuiaVirtualPichincha {
		public function inserta_usuario ($id_canton, $nombre, $correo_electronico, $nombre_usuario, $contrasena, $tipo_usuario){
			$query = 'INSERT INTO tb_usuario (id_canton, nombre, correo_electronico, nombre_usuario, contrasena, fecha_registro, tipo_usuario,
			estado) VALUES (' . $id_canton . ', \'' . $nombre . '\', \'' . $correo_electronico . '\', \'' . $nombre_usuario . '\',
			\'' . sha1($contrasena) . '\', NOW(), \'' . $tipo_usuario . '\', \'' . $estado . '\')';
			connect();
			$result = execute_sql ($query);
			disconnect();
			return $result;
		}
		public function inserta_categoria ($descripcion){
			$query = 'INSERT INTO tb_categoria (descripcion, estado) VALUES (\'' . $descripcion . '\', 1)';
			connect();
			$result = execute_sql($query);
			disconnect();
			return $result;
		}
		public function actualiza_elimina_categoria ($descripcion, $estado) {
			$query = 'UPDATE tb_categoria SET descripcion = \'' . $descripcion . '\', estado = ' . $estado;
			connect();
			$result = execute_sql($query);
			disconnect();
			return $result;
		}
		public function iniciar_sesion ($nombre_usuario, $contrasena){
			$query = 'SELECT * FROM tb_usuario WHERE nombre_usuario = \'' . $nombre_usuario . '\' AND contrasena = \'' . sha1($contrasena) . '\'';
			connect();
			$result = execute_sql ($query);
			$json = array();
			if (mysqli_num_rows($result) > 0){
				while ($row = mysqli_fetch_assoc($result)){
					$json[] = $row;
				}
			}
			return json_encode($json);
		}
		public function califica_sitio ($id_sitio_turistico, $id_usuario, $valor){
			connect();
			$query = 'SELECT * FROM tb_calificacion_sitio WHERE id_sitio_turistico = ' . $id_sitio_turistico . ' AND id_usuario = ' . $id_usuario;
			$select = execute_sql($query);
			if (mysqli_num_rows($select) > 0)
				$query = 'UPDATE tb_calificacion_sitio SET valor = ' . $valor . ' WHERE id_sitio_turistico = ' . $id_sitio_turistico . ' AND 
				id_usuario = ' . $id_usuario;
			else 
				$query = 'INSERT INTO tb_calificacion_sitio (id_sitio_turistico, id_usuario, valor) VALUES (' . $id_sitio_turistico . ', ' . $id_usuario . ',
				' . $valor . ')';
			$result = execute_sql($query);
			disconnect();
			return $result;
		}
	}
?>