<?php
//Pendiente de modificar
require_once '../core/conexion.php';
class Cls_usuario extends conexion
{

	public function crear_usuario($nombre, $clave, $rol)
	{
		$sql = "INSERT INTO usuario (usua_Nombre,usua_Clave,rol_Id,UsEstado)";
		$sql = $sql . "VALUES ('$nombre','$clave','$rol',1)";
		$resultado = mysqli_query($this->conexion, $sql);
		if ($resultado) {
			return true;
		} else {
			return false;
		}
	}
	public function buscar_clienteespecifico($clie_Id)
	{
		$sql = "SELECT clie_Id,clie_Nombre,clie_Apellido,clie_Correo,clie_Direccion,clie_Celular FROM cliente WHERE clie_Id = $clie_Id";
		$data = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($data);
		return $record;
	}
	public function buscarUsuario($buscar)
	{
		$sql = "SELECT usua_Id,usua_Nombre,usuario.rol_Id,rol_Nombre FROM usuario inner join rol on usuario.rol_Id = rol.rol_Id";
		$sql = $sql . " where usua_Nombre ='$buscar'";
		$data = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($data);
		return $record;
	}
	public function buscarEmpleado($buscar)
	{
		$sql = "SELECT usua_Id,usua_Nombre,usuario.rol_Id,rol_Nombre FROM usuario inner join rol on usuario.rol_Id = rol.rol_Id";
		$sql = $sql . " where usua_Nombre ='$buscar'";
		$data = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($data);
		return $record;
	}
	public function buscar_usuarioespecifico($nombre)
	{
		$sql = "SELECT usua_Nombre FROM usuario WHERE usua_Nombre = '$nombre'";
		$data = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($data);
		return $record;
	}
	public function buscar_usuarioempleadoespecifico($nombre)
	{
		$sql = "SELECT empl_Nombre,empl_Apellido,empl_Documento,empl_Telefono FROM empleado inner join usuario on empleado.usua_Id = usuario.usua_Id WHERE usua_Nombre = '$nombre'";
		$data = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($data);
		return $record;
	}
	public function buscar_usuarioclienteespecifico($nombre)
	{
		$sql = "SELECT clie_Nombre,clie_Apellido,clie_Correo,clie_Direccion,clie_Celular FROM cliente inner join usuario on cliente.usu_Id = usuario.usua_Id WHERE usua_Nombre = '$nombre'";
		$data = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($data);
		return $record;
	}
	public function buscar_usuarioproveedorespecifico($nombre)
	{
		$sql = "SELECT prov_Nombre,prov_Correo,prov_Telefono,prov_Documento,prov_Link_Pagina FROM proveedor inner join usuario on proveedor.usua_Id = usuario.usua_Id WHERE usua_Nombre = '$nombre'";
		$data = mysqli_query($this->conexion, $sql);
		$record = mysqli_fetch_object($data);
		return $record;
	}
	public function actualizar_empleadousuario($nombre, $apellido, $documento, $tel, $cargo, $usuario)
	{
		$sql = "UPDATE empleado INNER JOIN usuario on empleado.usua_Id = usuario.usua_Id SET empl_Nombre='$nombre',empl_Apellido='$apellido',empl_Documento='$documento',empl_Telefono='$tel',carg_Id='$cargo'";
		$sql = $sql . " WHERE usua_Nombre = '$usuario'";
		echo $sql;
		$resultado = mysqli_query($this->conexion, $sql);
		if ($resultado) {
			return true;
		} else {
			return false;
		}
	}
	public function actualizar_clienteusuario($nombre, $apellido, $correo, $direccion, $tel, $usuario)
	{
		$sql = "UPDATE cliente INNER JOIN usuario on cliente.usu_Id = usuario.usua_Id SET clie_Nombre='$nombre',clie_Apellido='$apellido',clie_Correo='$correo',clie_Direccion='$direccion',clie_Celular='$tel'";
		$sql = $sql . " WHERE usua_Nombre = '$usuario'";
		echo $sql;
		$resultado = mysqli_query($this->conexion, $sql);
		if ($resultado) {
			return true;
		} else {
			return false;
		}
	}
	public function actualizar_proveedorusuario($nombre, $correo, $tel, $documento, $link, $usuario)
	{
		$sql = "UPDATE proveedor INNER JOIN usuario on proveedor.usua_Id = usuario.usua_Id SET prov_Nombre='$nombre',prov_Correo='$correo',prov_Telefono='$tel',prov_Documento='$documento',prov_Link_Pagina='$link'";
		$sql = $sql . " WHERE usua_Nombre = '$usuario'";
		echo $sql;
		$resultado = mysqli_query($this->conexion, $sql);
		if ($resultado) {
			return true;
		} else {
			return false;
		}
	}
	public function eliminar_clienteusuario($nombre)
	{
		$sql = "DELETE cliente,usuario FROM cliente inner join usuario on usuario.usua_Id = cliente.usu_Id WHERE usua_Nombre = '$nombre'";
		$resultado = mysqli_query($this->conexion, $sql);
		if ($resultado) {
			return true;
		} else {
			return false;
		}
	}
	public function eliminar_empleadousuario($nombre)
	{
		$sql = "DELETE empleado,usuario FROM empleado inner join usuario on usuario.usua_Id = empleado.usua_Id WHERE usua_Nombre = '$nombre'";
		$resultado = mysqli_query($this->conexion, $sql);
		if ($resultado) {
			return true;
		} else {
			return false;
		}
	}
	public function eliminar_proveedorusuario($nombre)
	{
		$sql = "DELETE proveedor,usuario FROM proveedor inner join usuario on usuario.usua_Id = proveedor.usua_Id WHERE usua_Nombre = '$nombre'";
		$resultado = mysqli_query($this->conexion, $sql);
		if ($resultado) {
			return true;
		} else {
			return false;
		}
	}
}
