<?php
	$connection = null;
	function connect () {
		$connection = mysqli_connect('localhost', 'root', '', 'db_guiavirtualpichincha');
		if (!connection)
			die('No se pudo establecer conexión con la base de datos.');
	}
	function execute_sql($query) {
		$result = mysqli_query($connection, $query);
		return $result;
	}
	function disconnect() {
		$closed = mysqli_close($connection);
		return $closed;
	}
?>