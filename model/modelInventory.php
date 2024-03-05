<?php
require_once '../core/conexion.php';
require_once('modelSelectors.php');

class modelInventory extends Conexion
{

	public function searchInventories($id,$inventory,$provider,$branch)
	{
		$condition = "";

		if ($id != "" && $provider != "" && $inventory != "" && $branch != "") {
			$condition = "WHERE detIng_Id =$id AND prov_nombre = '$provider' AND ing_Nombre ='$inventory' AND sede_Nombre = '$branch'";
		} else if ($provider != "" && $inventory = "" && $branch != "") {
			$condition = "WHERE prov_nombre = '$provider' AND ing_Nombre ='$inventory' AND sede_Nombre = '$branch'";
		} else if ($id != "" && $inventory != "" && $branch != "") {
			$condition = "WHERE detIng_Id =$id AND ing_Nombre ='$inventory' AND sede_Nombre = '$branch'";
		} else if ($id != "" && $provider != "" && $inventory != "") {
			$condition = "WHERE detIng_Id =$id AND prov_nombre = '$provider' AND ing_Nombre ='$inventory'";
		} else if ($id != "" && $provider != "" && $branch != "") {
			$condition = "WHERE detIng_Id =$id AND prov_nombre = '$provider' AND sede_Nombre = '$branch'";
		} else if ($id != "" && $provider != "") {
			$condition = "WHERE detIng_Id =$id AND prov_nombre = '$provider'";
		} else if ($id != "" && $inventory != "") {
			$condition = "WHERE detIng_Id =$id AND ing_Nombre ='$inventory'";
		} else if ($id != "" && $branch != "") {
			$condition = "WHERE detIng_Id =$id AND sede_Nombre = '$branch'";
		} else if ($provider != "" && $inventory != "") {
			$condition = "WHERE prov_nombre = '$provider' AND ing_Nombre ='$inventory'";
		} else if ($provider != "" && $branch != "") {
			$condition = "WHERE prov_nombre = '$provider' AND sede_Nombre = '$branch'";
		} else if ($inventory != "" && $branch != "") {
			$condition = "WHERE ing_Nombre ='$inventory' AND sede_Nombre = '$branch'";
		} else if ($id != "") {
			$condition = "WHERE detIng_Id =$id";
		} else if ($provider != "") {
			$condition = "WHERE prov_nombre = '$provider'";
		} else if ($inventory != "") {
			$condition = "WHERE ing_Nombre ='$inventory'";
		} else if ($branch != "") {
			$condition = "WHERE sede_Nombre = '$branch'";
		}

		$sql = "SELECT detIng_Id, detIng_precio, detIng_cantidad, ing_Nombre, ing_Foto, sede_Nombre, prov_Nombre,
				ciud_Nombre, pais_Nombre, usua_Nombre, ingEstado
				FROM infoingrediente $condition";
		$result = mysqli_query($this->conexion,$sql);
		$inventories = array();

		while ($row = mysqli_fetch_assoc($result)) {
			$inventories[] = $row;
		}

		return $inventories;
	}

	public function createInventory($nombre, $Foto, $precio, $cantidad, $sede, $estado)
	{
		$sql = "INSERT INTO ingrediente (ing_Nombre,ing_Foto,ingEstado)";
		$sql = $sql . "VALUES ('$nombre','$Foto',$estado)";
		$resultado = mysqli_query($this->conexion, $sql);

		if ($resultado) {
			$idinventario = mysqli_insert_id($this->conexion);
			$sql = "INSERT INTO detalleingrediente (detIng_precio,detIng_cantidad,ing_Id,sede_Id,detIngEstado)
					VALUES ($precio,$cantidad,$idinventario,$sede,$estado)";
			$resultado = mysqli_query($this->conexion, $sql);
			if ($resultado) {
				return true;
			} else {
				return false;
			}
		}
	}
	public function searchInventoryById($Id)
	{
		$sql = "SELECT detIng.detIng_Id,detIng.detIng_precio, detIng.detIng_cantidad, ing.ing_Nombre, ing.ing_Foto,ingEstado,s.sede_Id, sede_Nombre
				FROM detalleingrediente as detIng
				INNER JOIN ingrediente as ing on detIng.ing_Id = ing.ing_Id
				INNER JOIN sede s USING(sede_Id) 
				WHERE detIng.detIng_Id = '$Id'";
		$result = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($result);

		$modelSelector = new ModelSelectors;

		$branch = $modelSelector->selectorSede($record->sede_Id, $this->conexion);

		$data = (object) [
			'record' => $record,
			'branch' => $branch
		];

		return $data;
	}

	public function updateInventory($nombre, $Foto, $precio, $cantidad, $sede, $estado, $inv_id)
	{
		$sql = "SELECT ing_Id FROM ingrediente INNER JOIN detalleingrediente USING(ing_Id) WHERE detIng_Id = '$inv_id'";
		$data = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($data);

		$sql = "UPDATE ingrediente SET ing_Nombre = '$nombre',ing_Foto = '$Foto',ingEstado = $estado WHERE ing_Id = $record->ing_Id";
		$resultado = mysqli_query($this->conexion, $sql);

		if ($resultado) {
			$sql = "UPDATE detalleingrediente as detIng SET detIng_precio = '$precio', detIng_cantidad = '$cantidad',detIng.sede_Id='$sede'";
			$sql = $sql . "WHERE detIng_Id = $inv_id";
			$resultado = mysqli_query($this->conexion, $sql);
			if ($resultado) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function readProveedor($nombre)
	{
		$sql = "SELECT * FROM infoingrediente where usua_Nombre='$nombre'";
		$data = mysqli_query($this->conexion, $sql);
		return $data;
	}
}
