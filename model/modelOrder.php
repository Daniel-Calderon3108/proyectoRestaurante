<?php
require_once '../core/conexion.php';
class modelOrder extends conexion
{
	public function searchOrder($id,$customerName,$customerLastName,$date)
	{
		$condition = "";

		if ($id != "" && $customerName != "" && $customerLastName != "" && $date != "") {
			$condition = "WHERE ped_Id =$id AND clie_Nombre = '$customerName' AND clie_Apellido ='$customerLastName' AND pedFechaPedido = '$date'";
		} else if ($customerName != "" && $customerLastName = "" && $date != "") {
			$condition = "WHERE clie_Nombre = '$customerName' AND clie_Apellido ='$customerLastName' AND ped_FechaPedido = '$date'";
		} else if ($id != "" && $customerLastName != "" && $date != "") {
			$condition = "WHERE ped_Id =$id AND clie_Apellido ='$customerLastName' AND ped_FechaPedido = '$date'";
		} else if ($id != "" && $customerName != "" && $customerLastName != "") {
			$condition = "WHERE ped_Id =$id AND clie_Nombre = '$customerName' AND clie_Apellido ='$customerLastName'";
		} else if ($id != "" && $customerName != "" && $date != "") {
			$condition = "WHERE ped_Id =$id AND clie_Nombre = '$customerName' AND ped_FechaPedido = '$date'";
		} else if ($id != "" && $customerName != "") {
			$condition = "WHERE ped_Id =$id AND clie_Nombre = '$customerName'";
		} else if ($id != "" && $customerLastName != "") {
			$condition = "WHERE ped_Id =$id AND clie_Apellido ='$customerLastName'";
		} else if ($id != "" && $date != "") {
			$condition = "WHERE ped_Id =$id AND ped_FechaPedido = '$date'";
		} else if ($customerName != "" && $customerLastName != "") {
			$condition = "WHERE clie_Nombre = '$customerName' AND clie_Apellido ='$customerLastName'";
		} else if ($customerName != "" && $date != "") {
			$condition = "WHERE clie_Nombre = '$customerName' AND ped_FechaPedido = '$date'";
		} else if ($customerLastName != "" && $date != "") {
			$condition = "WHERE clie_Apellido ='$customerLastName' AND ped_FechaPedido = '$date'";
		} else if ($id != "") {
			$condition = "WHERE ped_Id =$id";
		} else if ($customerName != "") {
			$condition = "WHERE clie_Nombre = '$customerName'";
		} else if ($customerLastName != "") {
			$condition = "WHERE clie_Apellido ='$customerLastName'";
		} else if ($date != "") {
			$condition = "WHERE ped_FechaPedido = '$date'";
		}

		$sql = "SELECT ped_Id, prod_Nombre, prod_Precio, ped_Cantidad, ped_Total, ped_FechaPedido, 
				ped_FechaLlegada, clie_Nombre, clie_Apellido, usua_Nombre, precio_unidad 
				FROM infopedido $condition";
		$result = mysqli_query($this->conexion,$sql);
		$orders = array();

		while ($row = mysqli_fetch_assoc($result)) {
			$orders[] = $row;
		}

		return $orders;
	}

	public function read()
	{
		$sql = "SELECT * FROM infopedido";
		$data = mysqli_query($this->conexion, $sql);
		return $data;
	}
	public function readPedido($nombre)
	{
		$sql = "SELECT * FROM infopedido where usua_Nombre='$nombre'";
		$data = mysqli_query($this->conexion, $sql);
		return $data;
	}
	public function crear_pedido($cantidad, $fechaPedido, $cliente, $producto)
	{
		$sql = "INSERT INTO pedido (ped_Cantidad,ped_FechaPedido,clie_Id,prod_Id)";
		$sql = $sql . "VALUES ('$cantidad','$fechaPedido','$cliente','$producto')";
		$resultado = mysqli_query($this->conexion, $sql);
		if ($resultado) {
			return true;
		} else {
			return false;
		}
	}
	public function buscar_productoespecifico($Id)
	{
		$sql = "SELECT prod_Id,prod_Nombre,prod_Foto,prod_Descripcion,prod_Precio FROM producto WHERE prod_Id = $Id";
		$data = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($data);
		return $record;
	}
	public function actualizar_producto($nombre, $foto, $descripcion, $precio, $Id)
	{
		$sql = "UPDATE producto SET prod_Nombre = '$nombre',prod_Foto = '$foto',prod_Descripcion = '$descripcion',prod_Precio = '$precio'";
		$sql = $sql . " WHERE prod_Id = $Id";
		$resultado = mysqli_query($this->conexion, $sql);
		if ($resultado) {
			return true;
		} else {
			return false;
		}
	}
	public function eliminar_pedido($Id)
	{
		$sql = "DELETE FROM pedido WHERE ped_Id = '$Id'";
		$resultado = mysqli_query($this->conexion, $sql);
		if ($resultado) {
			return true;
		} else {
			return false;
		}
	}
	public function buscarPedido($buscar)
	{
		$sql = "SELECT * FROM infopedido";
		$sql = $sql . " where ped_FechaPedido like '%$buscar%'";
		$data = mysqli_query($this->conexion, $sql);
		return $data;
	}
	public function buscarPedidoCliente($buscar, $nombre)
	{
		$sql = "SELECT * FROM infopedido";
		$sql = $sql . " where usua_Nombre ='$nombre' and ped_FechaPedido like '%$buscar%'";
		$data = mysqli_query($this->conexion, $sql);
		return $data;
	}
	public function BuscarPedidoCreado($buscar)
	{
		$sql = "SELECT ped_Id,ped_Cantidad,prod_Nombre,prod_Precio,clie_Nombre,clie_Apellido FROM pedido inner join producto on pedido.prod_Id = producto.prod_Id inner join cliente on cliente.clie_Id = pedido.clie_Id";
		$sql = $sql . " where ped_FechaPedido = '$buscar'";
		$data = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($data);
		return $record;
	}
	public function confirmarpedido($total, $llegada, $Id)
	{
		$sql = "UPDATE pedido SET ped_Total = '$total',ped_FechaLlegada= '$llegada'";
		$sql = $sql . " WHERE ped_Id = $Id";
		$resultado = mysqli_query($this->conexion, $sql);
		if ($resultado) {
			return true;
		} else {
			return false;
		}
	}
}
