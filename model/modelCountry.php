<?php
require_once '../core/conexion.php';

class modelCountry extends conexion
{
	public function searchCountries($id,$name)
	{
		$condition = "";

		if ($id != "") {
			$condition = " WHERE pais_Id = $id";
			if ($name != "") {
				$condition .= " AND pais_Nombre ='$name'";
			}
		} else if ($name != "") {
			$condition .= " WHERE pais_Nombre = '$name'";
		}

		$sql = "SELECT pais_Id,pais_Nombre,bandera,paisEstado
				FROM pais 
				$condition";
		$result = mysqli_query($this->conexion, $sql);
		$country = array();

		while ($row = mysqli_fetch_assoc($result)) {
			$country[] = $row;
		}

		return $country;
	}

	public function createCountry($nombre, $bandera, $estado, $ciudad, $estadoCiudad)
	{
		$sql = "INSERT INTO pais (pais_Nombre,bandera,paisEstado)";
		$sql = $sql . "VALUES ('$nombre','$bandera',$estado)";
		$resultado = mysqli_query($this->conexion, $sql);
		$idpais = mysqli_insert_id($this->conexion);

		if ($resultado) {

			$sql = "INSERT INTO ciudad (ciud_Nombre,pais_Id,ciudEstado) 
					VALUES('$ciudad',$idpais,$estadoCiudad)";
			$resultado = mysqli_query($this->conexion, $sql);

			if ($resultado) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function searchCountryById($id)
	{
		$sql = "SELECT pais_Id,pais_Nombre,bandera,paisEstado
				FROM pais WHERE pais_Id = $id";
		$data = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($data);
		return $record;
	}

	public function updateCountry($nombre, $imgbandera,$estado,$id)
	{
		$sql = "UPDATE pais SET pais_Nombre = '$nombre',bandera='$imgbandera',paisEstado = $estado WHERE pais_Id = $id";
		$resultado = mysqli_query($this->conexion, $sql);
		if ($resultado) {
			return true;
		} else {
			return false;
		}
	}
}
