<?php
require_once '../core/conexion.php';
class modelProduct extends conexion
{

	public function searchProducts($id, $name)
	{
		$condition = "";

		if ($id != "") {
			$condition = " WHERE prod_Id = $id";

			if ($name != "") {
				$condition .= " AND prod_Nombre = '$name'";
			}
		} else if ($name != "") {
			$condition = " WHERE prod_Nombre = '$name'";
		}

		$sql = "SELECT prod_Id,prod_Nombre,prod_Foto,prod_Descripcion,prod_Precio,prodEstado FROM producto $condition";
		$data = mysqli_query($this->conexion, $sql);

		$product = array();

		while ($row = mysqli_fetch_assoc($data)) {
			$product[] = $row;
		}

		return $product;
	}

	public function createProduct($nombre, $foto, $descripcion, $precio, $estado)
	{
		$sql = "INSERT INTO producto (prod_Nombre,prod_Foto,prod_Descripcion,prod_Precio,prodEstado)";
		$sql = $sql . "VALUES ('$nombre','$foto','$descripcion','$precio',$estado)";
		$resultado = mysqli_query($this->conexion, $sql);
		if ($resultado) {
			return true;
		} else {
			return false;
		}
	}

	public function searchProductById($Id)
	{
		$sql = "SELECT prod_Id,prod_Nombre,prod_Foto,prod_Descripcion,prod_Precio,prodEstado FROM producto WHERE prod_Id = $Id";
		$data = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($data);
		return $record;
	}

	public function updateProduct($nombre, $foto, $descripcion, $precio, $Id, $estado)
	{
		$sql = "UPDATE producto SET prod_Nombre = '$nombre',prod_Foto = '$foto',prod_Descripcion = '$descripcion',prod_Precio = '$precio',prodEstado = $estado";
		$sql = $sql . " WHERE prod_Id = $Id";
		$resultado = mysqli_query($this->conexion, $sql);
		if ($resultado) {
			return true;
		} else {
			return false;
		}
	}

	public function getMenuProduct()
	{
		$sql = "SELECT prod_Id,prod_Nombre,prod_Foto,prod_Descripcion,prod_Precio,prodEstado FROM producto";
		$result = mysqli_query($this->conexion,$sql);
		$product = array();
		
		while ($row = mysqli_fetch_assoc($result)) {
			$product [] = $row;
		}
		return $product;
	}
}
