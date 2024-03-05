<?php
require_once '../core/conexion.php';
//Clase Sede
class modelBranch extends conexion
{
	public function searchBranchs($id, $name)
	{
		$condition = "";

		if ($id != "") {
			$condition = " WHERE sede_Id = $id";
			if ($name != "") {
				$condition .= " AND sede_Nombre ='$name'";
			}
		} else if ($name != "") {
			$condition .= " WHERE sede_Nombre = '$name'";
		}

		$sql = "SELECT sede_Id,sede_Nombre,prov_Nombre,ciud_Nombre,pais_Nombre,usua_Nombre,sedeEstado
				FROM sedeciudadpais 
				$condition";
		$result = mysqli_query($this->conexion, $sql);
		$branch = array();

		while ($row = mysqli_fetch_assoc($result)) {
			$branch[] = $row;
		}

		return $branch;
	}

	public function createBranch($nombre, $proveedor, $ciudad, $estado)
	{
		$sql = "INSERT INTO sede (sede_Nombre,prov_Id,ciud_Id,sedeEstado)";
		$sql = $sql . "VALUES ('$nombre','$proveedor','$ciudad',$estado)";
		$resultado = mysqli_query($this->conexion, $sql);

		if ($resultado) {
			return true;
		} else {
			return false;
		}
	}

	public function searchBranchById($branchId)
	{	
		$sql = "SELECT sede_Id, sede_Nombre, s.prov_Id, s.ciud_Id, sedeEstado, prov_Nombre, ciud_Nombre 
				FROM sede s
				INNER JOIN proveedor USING(prov_Id)
				INNER JOIN ciudad USING(ciud_Id)
				WHERE sede_Id=$branchId";
		$result = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($result);

		$modelSelector = new ModelSelectors;

		$provider = $modelSelector->selectorProveedor($record->prov_Id, $this->conexion);
		$city = $modelSelector->selectorCiudad($record->ciud_Id, $this->conexion);

		$data = (object) [
			'provider' => $provider,
			'city' => $city,
			'record' => $record
		];

		return $data;
	}

	public function updateBranch($nombre, $proveedor, $ciudad, $Id, $estado)
	{
		$sql = "UPDATE sede SET sede_Nombre = '$nombre',prov_Id = '$proveedor',ciud_Id = '$ciudad',sedeEstado = $estado";
		$sql = $sql . " WHERE sede_Id = $Id";
		$resultado = mysqli_query($this->conexion, $sql);
		if ($resultado) {
			return true;
		} else {
			return false;
		}
	}

	public function readProveedor($nombre)
	{
		$sql = "select * from sedeciudadpais where usua_Nombre='$nombre'";
		$data = mysqli_query($this->conexion, $sql);
		return $data;
	}

	public function buscar_sedeciudadespecifico($ciudad)
	{
		$sql = "SELECT * FROM  sedeciudadpais";
		$sql = $sql . " where ciud_Nombre = '$ciudad'";
		$data = mysqli_query($this->conexion, $sql);
		return $data;
	}

	public function buscar_proveedorsespecifico($proveedor)
	{
		$sql = "SELECT * FROM sedeciudadpais";
		$sql = $sql . " where prov_Nombre = '$proveedor'";
		$data = mysqli_query($this->conexion, $sql);
		return $data;
	}
}
