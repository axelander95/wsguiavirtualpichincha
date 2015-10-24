<?php
	function execute_sql($query) {
		$connection = mysqli_connect('localhost', 'root', '', 'db_guiavirtualpichincha');
		$result = mysqli_query($connection, $query);
		mysqli_close($connection);
		return $result;
	}
	function execute_multiple_queries($query1, $query2){
		$connection = mysqli_connect('localhost', 'root', '', 'db_guiavirtualpichincha');
		$result = mysqli_query($connection, $query1);
		if ($result)
			$result2 = mysqli_query($connection, $query2);
		mysqli_close($connection);
		return $result2;
	}
?>