<?php
require_once('../Core/conexion.php');
class modelLogin extends Conexion
{
	public function validateLogin($user, $password)
	{
		$sql = "SELECT usua_Nombre,usua_Clave,rol.rol_Nombre,usua_foto 
				FROM usuario 
				INNER JOIN rol USING(rol_Id) 
				WHERE usua_Nombre = '$user' AND usua_Clave = '$password'";
		$result = mysqli_query($this->conexion, $sql);

		$login = mysqli_fetch_assoc($result);

		if ($login > 0) {
			return $login;
		} else {
			return false;
		}
	}

	public function encryptPassword($password) {
        $salt = 'system';
        $hash = hash('sha256', $salt . $password);
        return $hash;
    }
}
