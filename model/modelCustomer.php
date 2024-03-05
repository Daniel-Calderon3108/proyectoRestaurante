<?php
require_once('../Core/conexion.php');
class modelCustomer extends Conexion
{ 
	public function searchCustomers($id,$name,$lastName)
	{
		$condition = "";

		if ($id != "") {
			$condition = " WHERE clie_Id = $id";
			if ($name != "") {
				$condition .= " AND clie_Nombre ='$name'";
				if ($lastName != "") {
					$condition .= " AND clie_Apellido = '$lastName'";
				}
			} else if ($lastName != "") {
				$condition .= " AND clie_Apellido = '$lastName'";
			}
		} else if ($name != "") {
			$condition .= " WHERE clie_Nombre = '$name'";

			if ($lastName != "") {
				$condition .= " AND clie_Apellido = '$lastName'";
			}
		} else if ($lastName != "") {
			$condition = " WHERE clie_Apellido = '$lastName'";
		}

		$sql = "SELECT clie_Id,clie_Nombre,clie_Apellido,clie_Correo,clie_Direccion,clie_Celular,clieEstado
				FROM cliente c
				INNER JOIN usuario u ON c.usu_Id = u.usua_Id $condition";
		$result = mysqli_query($this->conexion,$sql);
		$customers = array();

		while ($row = mysqli_fetch_assoc($result)) {
			$customers[] = $row;
		}
		mysqli_close($this->conexion);
		return $customers;
	}

	public function createCustomer($nombre, $apellido, $correo, $direccion, $tel, $usuario, $clave,$fotoUsuario,$estado)
	{
		$sql = "INSERT INTO usuario(usua_Nombre,usua_Clave,rol_Id,UsEstado,usua_foto)";
		$sql = $sql . " VALUES ('$usuario','$clave',2,$estado,'$fotoUsuario')";
		$resultado = mysqli_query($this->conexion, $sql);

		if ($resultado) {
			$sql = "SELECT usua_Id FROM usuario WHERE usua_Nombre = '$usuario'";
			$data = mysqli_query($this->conexion, $sql);
			$record = mysqli_fetch_object($data);

			$sql = "INSERT INTO cliente (clie_Nombre,clie_Apellido,clie_Correo,clie_Direccion,clie_Celular,usu_Id,ClieEstado)";
			$sql = $sql . "VALUES ('$nombre','$apellido','$correo','$direccion','$tel','$record->usua_Id',$estado)";
			$resultado = mysqli_query($this->conexion, $sql);
			mysqli_close($this->conexion);
			if ($resultado) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function searchCustomerById($clie_Id)
	{
		$sql = "SELECT clie_Id,clie_Nombre,clie_Apellido,clie_Correo,clie_Direccion,clie_Celular,c.usu_Id,usua_Nombre,usua_Clave,usua_foto,UsEstado
				FROM cliente c
				INNER JOIN usuario u ON c.usu_Id = u.usua_Id
				WHERE clie_Id = $clie_Id";
		$data = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($data);
		mysqli_close($this->conexion);
		return $record;
	}

	public function updateCustomer($nombre, $apellido, $correo, $direccion, $tel, $usuario, $clave, $usua_id, $Id,$fotoUsuario,$estado)
	{
		$sql = "UPDATE usuario SET usua_Nombre = '$usuario',usua_Clave = '$clave',usua_foto = '$fotoUsuario',UsEstado = $estado WHERE usua_Id = '$usua_id'";
		$resultado = mysqli_query($this->conexion, $sql);

		if ($resultado) {
			$sql = "UPDATE cliente SET clie_Nombre = '$nombre',clie_Apellido = '$apellido',clie_Correo = '$correo',clie_Direccion = '$direccion',clie_Celular = '$tel',clieEstado = $estado";
			$sql = $sql . " WHERE clie_Id = $Id";
			$resultado = mysqli_query($this->conexion, $sql);
			if ($resultado) {
				return true;
			} else {
				return false;
			}
		}
	}
}
