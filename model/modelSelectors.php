<?php
class ModelSelectors
{

	public function selectorCargo($cargo = "", $conexion)
	{

		$condiciones = $cargo == "" ? "" : " WHERE carg_id <> $cargo";

		$sql = "SELECT carg_Id,carg_Nombre FROM cargo $condiciones";
		$data = mysqli_query($conexion, $sql);
		$cargo = array();
		while ($row = mysqli_fetch_assoc($data)) {
			$cargo[] = $row;
		}
		return $cargo;
	}

	public function selectorTipoDocumento($tipo = "", $conexion)
	{

		$condiciones = $tipo == "" ? "" : " WHERE id_tipo <> $tipo";

		$sql = "SELECT id_tipo,tipo FROM tipo_documento $condiciones";
		$data = mysqli_query($conexion, $sql);
		$tipoDocumento = array();
		while ($row = mysqli_fetch_assoc($data)) {
			$tipoDocumento[] = $row;
		}
		return $tipoDocumento;
	}

	public function selectorProveedor($proveedor = "", $conexion)
	{

		$condiciones = $proveedor == "" ? "" : " WHERE prov_id <> $proveedor";

		$sql = "SELECT prov_Id,prov_Nombre FROM proveedor $condiciones";
		$data = mysqli_query($conexion, $sql);
		$proveedores = array();
		while ($row = mysqli_fetch_assoc($data)) {
			$proveedores[] = $row;
		}
		return $proveedores;
	}

	public function selectorCiudad($ciudad = "", $conexion)
	{

		$condiciones = $ciudad == "" ? "" : " WHERE ciud_id <> $ciudad";

		$sql = "SELECT ciud_Id,ciud_Nombre,pais_Nombre 
				FROM ciudad 
				INNER JOIN pais USING(pais_Id)
				$condiciones";
		$data = mysqli_query($conexion, $sql);
		$ciudades = array();
		while ($row = mysqli_fetch_assoc($data)) {
			$ciudades[] = $row;
		}
		return $ciudades;
	}

	public function selectorSede($sede = "", $conexion)
	{

		$condiciones = $sede == "" ? "" : " WHERE sede_Nombre <> '$sede'";

		$sql = "SELECT sede_Id,sede_Nombre,ciud_Nombre 
				FROM sede INNER JOIN ciudad USING(ciud_Id) $condiciones";
		$data = mysqli_query($conexion, $sql);
		$sedes = array();
		while ($row = mysqli_fetch_assoc($data)) {
			$sedes[] = $row;
		}
		return $sedes;
	}

	public function selectorPais($pais = "", $conexion)
	{
		$condiciones = $pais == "" ? "" : " WHERE pais_id <> $pais";

		$sql = "SELECT pais_Id,pais_Nombre FROM pais $condiciones";
		$result = mysqli_query($conexion, $sql);

		$country = array();

		while ($row = mysqli_fetch_assoc($result)) {
			$country[] = $row;
		}

		return $country;
	}


	// public function selectorRol()
	// {
	// 	$sql = "SELECT rol_Id,rol_Nombre FROM rol where rol_Nombre!='Administrador'";
	// 	$data = mysqli_query($this->conexion, $sql);
	// 	return $data;
	// }

	// public function selectorCliente()
	// {
	// 	$sql = "SELECT clie_Id,clie_Nombre,clie_Apellido FROM cliente";
	// 	$data = mysqli_query($this->conexion, $sql);
	// 	return $data;
	// }

	// public function selectorProducto()
	// {
	// 	$sql = "SELECT prod_Id,prod_Nombre,prod_Precio FROM producto";
	// 	$data = mysqli_query($this->conexion, $sql);
	// 	return $data;
	// }

}
