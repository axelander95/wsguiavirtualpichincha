<?php
	if (!empty($_POST)){
		$nombre = $_POST['nombre'];
		$canton = $_POST['canton'];
		$correo_electronico = $_POST['correo_electronico'];
		$nombre_usuario = $_POST['nombre_usuario'];
		$contrasena = $_POST['contrasena'];
		$tipo_usuario = $_POST['tipo_usuario'];
		if (isset($nombre) && isset($canton) && isset($correo_electronico) && isset($nombre_usuario) && isset($contrasena) && isset($tipo_usuario)){
			
		}
		else
			$validacion = 'Debe llenar los campos requeridos.';
			
	}
?>
<form action="signup.php" method="post" name="inserta_usuario">
	<label>Nombre</label>
	<input type="text" name="nombre"/>
	<label>Elije el cantón donde resides</label>
	<select>
		<option name="canton" value="1">Guayaquil</option>
	</select>
	<label>Correo electrónico</label>
	<input type="email" name="correo_electronico"/>
	<label>Nombre de usuario</label>
	<input type="text" name="nombre_usuario"/>
	<label>Contraseña</label>
	<input type="password" name="contrasena"/>
	<input type="hidden" name="tipo_usuario" value="E"/>
	<label><?php echo (isset($validacion)?$validacion:'');?></label>
	<input type="submit" value="Crear cuenta"/>
</form>