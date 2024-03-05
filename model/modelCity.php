<?php
require_once('../Core/conexion.php');
require_once('modelSelectors.php');

class modelCity extends Conexion
{
    public function searchCities($id,$city,$country)
	{
		$condition = "";

		if ($id != "") {
			$condition = " WHERE ciud_Id = $id";
			if ($city != "") {
				$condition .= " AND ciud_Nombre ='$city'";
				if ($country != "") {
					$condition .= " AND pais_Nombre = '$country'";
				}
			} else if ($country != "") {
				$condition .= " AND pais_Nombre = '$country'";
			}
		} else if ($city != "") {
			$condition .= " WHERE ciud_Nombre = '$city'";

			if ($country != "") {
				$condition .= " AND pais_Nombre = '$country'";
			}
		} else if ($country != "") {
			$condition = " WHERE pais_Nombre = '$country'";
		}

		$sql = "SELECT ciud_Id,ciud_Nombre,pais_Nombre,ciudEstado 
				FROM  ciudad 
				INNER JOIN pais USING(pais_Id) $condition
                ORDER BY pais_Nombre asc";
		$result = mysqli_query($this->conexion,$sql);
		$cities = array();

		while ($row = mysqli_fetch_assoc($result)) {
			$cities[] = $row;
		}

		return $cities;
	}

	public function createCity($name, $country, $state)
	{
		$sql = "INSERT INTO ciudad (ciud_Nombre, pais_Id, ciudEstado) VALUES ('$name', '$country', '$state')";
		$result = mysqli_query($this->conexion, $sql);

		return $result;
	}

	public function searchCityById($cityId)
	{
		$sql = "SELECT ciud_Id, ciud_Nombre, c.pais_Id, ciudEstado, pais_Nombre FROM ciudad c
				INNER JOIN pais USING(pais_Id)
				WHERE ciud_Id = $cityId";
		$result = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($result);
		
		$modelSelector = new ModelSelectors;

		$country = $modelSelector->selectorPais($record->pais_Id, $this->conexion);

		$data = (object) [
			'record' => $record,
			'country' => $country
		];

		return $data;
	}

	public function updateCity($name, $country, $state, $cityId)
	{
		$sql = "UPDATE ciudad SET ciud_Nombre = '$name', pais_Id = $country, ciudEstado = $state
				WHERE ciud_Id = $cityId";
		$result = mysqli_query($this->conexion, $sql);

		return $result;
	}
}