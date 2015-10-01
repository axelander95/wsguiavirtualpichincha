<?php
	function execute_sql($query) {
		$connection = mysqli_connect('localhost', 'root', '', 'db_guiavirtualpichincha');
		$result = mysqli_query($connection, $query);
		mysqli_close($connection);
		return $result;
	}
?>