<?php
require_once('../Core/conexion.php');
require_once('modelSelectors.php');

class modelEmployee extends Conexion
{
	public function searchEmployees($id, $name, $lastName)
	{
		$condition = "";

		if ($id != "") {
			$condition = " WHERE empl_Id = $id";
			if ($name != "") {
				$condition .= " AND empl_Nombre ='$name'";
				if ($lastName != "") {
					$condition .= " AND empl_Apellido = '$lastName'";
				}
			} else if ($lastName != "") {
				$condition .= " AND empl_Apellido = '$lastName'";
			}
		} else if ($name != "") {
			$condition .= " WHERE empl_Nombre = '$name'";

			if ($lastName != "") {
				$condition .= " AND empl_Apellido = '$lastName'";
			}
		} else if ($lastName != "") {
			$condition = " WHERE empl_Apellido = '$lastName'";
		}

		$sql = "SELECT empl_Id,empl_Nombre,empl_Apellido,empl_Documento,empl_Telefono,carg_Nombre,usua_Nombre,tipo,UsEstado 
				FROM empleado 
				INNER JOIN cargo ON empleado.carg_Id = cargo.carg_Id 
				INNER JOIN usuario ON empleado.usua_Id = usuario.usua_Id
				LEFT JOIN tipo_documento USING(id_tipo) $condition
				ORDER BY empl_Nombre ASC";
		$data = mysqli_query($this->conexion, $sql);
		$employee = array();

		while ($row = mysqli_fetch_assoc($data)) {
			$employee[] = $row;
		}
		mysqli_close($this->conexion);
		return $employee;
	}

	public function createEmployee($name, $lastName, $typeDocument, $document, $tel, $post, $user, $password, $userPicture, $state)
	{

		$sql = "INSERT INTO usuario(usua_Nombre,usua_Clave,rol_Id,usua_foto,UsEstado)";
		$sql = $sql . " VALUES ('$user','$password',3,'$userPicture',$state)";
		$resultado = mysqli_query($this->conexion, $sql);

		if ($resultado) {
			$sql = "SELECT usua_Id FROM usuario WHERE usua_Nombre = '$user'";
			$data = mysqli_query($this->conexion, $sql);
			$record = mysqli_fetch_object($data);

			$sql = "INSERT INTO empleado (empl_Nombre,empl_Apellido,empl_Documento,empl_Telefono,carg_Id,usua_Id, id_tipo,emplEstado)";
			$sql = $sql . "VALUES ('$name','$lastName','$document','$tel','$post','$record->usua_Id','$typeDocument',$state)";
			$resultado = mysqli_query($this->conexion, $sql);
			mysqli_close($this->conexion);
			if ($resultado) {
				return true;
			} else {
				return false;
			}
		}
		
	}

	public function searchEmployeeById($empl_Id)
	{
		$sql = "SELECT empl_Id,empl_Nombre,empl_Apellido,empl_Documento,empl_Telefono, usua_Nombre,usua_Clave,
				e.usua_Id, carg_Nombre, e.carg_Id,tipo,e.id_tipo, usua_foto, UsEstado
				FROM empleado e 
				INNER JOIN usuario USING(usua_Id) 
				INNER JOIN cargo  USING(carg_Id)
				INNER JOIN tipo_documento USING(id_tipo) 
				WHERE empl_Id = $empl_Id;";
		$result = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($result);

		$modelSelector = new ModelSelectors;

		$position = $modelSelector->selectorCargo($record->carg_Id,$this->conexion);
		$typeDocument = $modelSelector->selectorTipoDocumento($record->id_tipo,$this->conexion);

		$data = (object) [
			'record' => $record, 
			'position' => $position,
			'typeDocument' => $typeDocument
		];
		mysqli_close($this->conexion);
		return $data;
	}

	public function updateEmployee($nombre, $apellido, $documento, $tel, $cargo, $Id, $usuario, $clave, $usua_id, $tipo, $foto, $estado)
	{
		$sql = "UPDATE usuario SET usua_Nombre = '$usuario',usua_Clave = '$clave',usua_foto = '$foto',UsEstado = $estado WHERE usua_Id = '$usua_id'";
		$resultado = mysqli_query($this->conexion, $sql);
		if ($resultado) {
			$sql = "UPDATE empleado SET empl_Nombre = '$nombre',empl_Apellido = '$apellido',empl_Documento = '$documento',
					empl_Telefono = '$tel',carg_Id = '$cargo', id_tipo = '$tipo',emplEstado = $estado ";
			$sql = $sql . "WHERE empl_Id = $Id";
			$resultado = mysqli_query($this->conexion, $sql);
			if ($resultado) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
