<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Conexion{
	private static $objCon = null;
	private static $instancia = null;
	public static function obtenerInstancia(){
		if(self::$objCon == null)
		{
			self::$instancia = new Conexion();
			//self::$objCon = mysqli_connect("localhost","jose9cd_2018","*sj2020$","jose9cd_2018");
			// mysqli_connect("localhost"," nombre usuario","clve de la base de datos","nombre de la base de datos");
			self::$objCon = mysqli_connect("localhost","root","12345678","tercero2024");
			//8Nua;Krf&v77
		}
		return self::$objCon;
	}
	function __destruct(){
		mysqli_close(conexion::obtenerInstancia());
	}
}
$rs = conexion::obtenerInstancia();
?>