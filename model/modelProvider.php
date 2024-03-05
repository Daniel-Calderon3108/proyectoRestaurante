<?php
require_once('../Core/conexion.php');
require_once('modelSelectors.php');

class modelProvider extends Conexion
{
	public function searchProviders($id,$name)
	{
		$condition = "";

		if ($id != "") {
			$condition = " WHERE prov_Id = $id";
			if ($name != "") {
				$condition .= " AND prov_Nombre ='$name'";
			}
		} else if ($name != "") {
			$condition .= " WHERE prov_Nombre = '$name'";
		}

		$sql = "SELECT prov_Id,prov_Nombre,prov_Correo,prov_Telefono,prov_Documento,prov_Link_Pagina,usua_Nombre,tipo,UsEstado
				FROM proveedor 
				INNER JOIN usuario USING(usua_Id) 
				INNER JOIN tipo_documento USING (id_tipo) $condition";
		$result = mysqli_query($this->conexion,$sql);
		$providers = array();

		while ($row = mysqli_fetch_assoc($result)) {
			$providers[] = $row;
		}

		return $providers;
	}

	public function createProvider($nombre, $tipo, $documento, $correo, $tel, $link, $usuario, $clave, $estado, $fotoUsuario)
	{

		$sql = "INSERT INTO usuario(usua_Nombre,usua_Clave,rol_Id,usua_foto,UsEstado)";
		$sql = $sql . " VALUES ('$usuario','$clave',4,'$fotoUsuario',$estado)";
		$resultado = mysqli_query($this->conexion, $sql);

		if ($resultado) {
			$sql = "SELECT usua_Id FROM usuario WHERE usua_Nombre = '$usuario'";
			$data = mysqli_query($this->conexion, $sql);
			$record = mysqli_fetch_object($data);

			$sql = "INSERT INTO proveedor (prov_Nombre,prov_Correo,prov_Telefono,prov_Documento,prov_Link_Pagina,usua_Id,Estado,id_tipo)";
			$sql = $sql . "VALUES ('$nombre','$correo','$tel','$documento','$link',$record->usua_Id,$estado,$tipo)";
			$resultado = mysqli_query($this->conexion, $sql);
			if ($resultado) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function searchProviderById($Id)
	{
		$sql = "SELECT prov_Id,prov_Nombre,prov_Correo,prov_Telefono,prov_Documento,prov_Link_Pagina,tipo,usua_Nombre,usua_Clave,UsEstado, p.id_tipo,p.usua_Id, usua_foto
				FROM proveedor p
				INNER JOIN usuario USING(usua_Id)
				INNER JOIN tipo_documento USING(id_tipo)   
				WHERE prov_Id = $Id";
		$result = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($result);

		$modelSelector = new ModelSelectors;

		$typeDocument = $modelSelector->selectorTipoDocumento($record->id_tipo,$this->conexion);

		$data = (object) [
			'record' => $record,
			'typeDocument' => $typeDocument
		];

		return $data;
	}

	public function updateProvider($nombre, $tipo, $documento, $correo,$tel,$link, $usuario,$clave,$usua_id,$prov_id,$estado,$fotoUsuario)
	{
		$sql = "UPDATE usuario SET usua_Nombre = '$usuario',usua_Clave = '$clave',usua_foto = '$fotoUsuario',UsEstado = $estado WHERE usua_Id = '$usua_id'";
		$resultado = mysqli_query($this->conexion, $sql);
		if ($resultado) {

			$sql = "UPDATE proveedor SET prov_Nombre = '$nombre',prov_Correo = '$correo',prov_Telefono = '$tel',prov_Documento = '$documento',prov_Link_Pagina = '$link', id_tipo = $tipo, Estado = $estado";
			$sql = $sql . " WHERE prov_Id = $prov_id";
			$resultado = mysqli_query($this->conexion, $sql);
			if ($resultado) {
				return true;
			} else {
				return false;
			}
		}
	}
}
