<?php
Class Conexion {
	public $conexion;
	private	$server;
	private	$user;
	private	$password;
    private	$namebd;
    private $charset;

    function __construct() {

        $db_cfg = require_once '../config/database.php';
        $this->server=$db_cfg["servidor"];
        $this->user=$db_cfg["usuario"];
        $this->password=$db_cfg["pass"];
        $this->namebd=$db_cfg["bd"];
        $this->charset=$db_cfg["charset"];

        $this->connectar_bd();
 
        $sql = "SET NAMES '".$this->charset."'";
        mysqli_query($this->conexion,$sql);
    }

    private function connectar_bd()
    {
        $this->conexion = mysqli_connect($this->server,$this->user,$this->password,$this->namebd);
        if (mysqli_connect_error()) {
            die("Fallo la conexion a la base de datos".mysqli_connect_error().mysqli_connect_errno());
        }
    }

}
