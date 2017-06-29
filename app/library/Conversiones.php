<?php

use Phalcon\Mvc\User\Component;

/**
 * Conversiones
 *
 * Conversión de caracteres de diferentes tipos
 */
class Conversiones extends Component
{

	/**
	 * fecha
	 *
	 * Tipos de formato de fecha:
	 * 	1 = dd/mm/aaaa -> aaaa-mm-dd
	 *  2 = aaaa-mm-dd -> dd/mm/aaaa
	 *  3 = aaaa-mm-dd -> 16 de Mayo de 2014
	 *  4 = aaaa-mm-dd -> Sábado 17 de Mayo de 2014
	 *  5 = aaaa-mm-dd -> AGOSTO
	 *  6 = aaaa-mm-dd -> AG
	 *  7 = aaaa-mm-dd -> 02BC_Febrero
	 *  8 = aaaa-mm-dd -> Agosto de 2015
	 *  9 = aaaa-mm-dd -> MARZO_2015
	 *  10 = aaaa-mm-dd-> Lunes, 31/06/2015
	 *  11 = 9-> Septiembre
	 * @return string
	 * @author Julián Camilo Marín Sánchez
	 */
	public function fecha($tipo_formato, $fecha) {
		if(!$fecha || $fecha == NULL || $fecha == "00/00/0000" || $fecha == "0000-00-00"){
			return "";
		}
		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$siglas_meses = array("EN","FE","MR","AB","MY","JN","JL","AG","SE","OC","NO","DI");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		if($tipo_formato == 1) {
			$parts = explode('/', $fecha);
			$nueva_fecha = "$parts[2]-$parts[1]-$parts[0]";
			return $nueva_fecha;
		}
		elseif($tipo_formato == 2){
			$parts = explode('-', $fecha);
			$nueva_fecha = "$parts[2]/$parts[1]/$parts[0]";
			return $nueva_fecha;
		}
		elseif($tipo_formato == 3){
			$parts = explode('-', $fecha);
			return $parts[2] . " de " . $meses[$parts[1]-1] . " de " . $parts[0];
		}
		elseif($tipo_formato == 4){
			$parts = explode('-', $fecha);
			return $dias[date('w', strtotime($fecha))] . " " . $parts[2] . " de " . $meses[$parts[1]-1] . " de " . $parts[0];
		}
		elseif($tipo_formato == 5){
			$parts = explode('-', $fecha);
			return strtoupper($meses[$parts[1]-1]);
		}
		elseif($tipo_formato == 6){
			$parts = explode('-', $fecha);
			return strtoupper($siglas_meses[$parts[1]-1]);
		}
		elseif($tipo_formato == 7){
			$parts = explode('-', $fecha);
			return $parts[1] . "BC_" . $meses[$parts[1]-1];
		}
		elseif($tipo_formato == 8){
			$parts = explode('-', $fecha);
			return $meses[$parts[1]-1] . " de " . $parts[0];
		}
		elseif($tipo_formato == 9){
			$parts = explode('-', $fecha);
			return strtoupper($meses[$parts[1]-1]) . "_" . $parts[0];
		}
		elseif($tipo_formato == 10){
			$parts = explode('-', $fecha);
			return $dias[date('w', strtotime($fecha))] . " " . $parts[2] . "/" . $meses[$parts[1]-1] . "/" . $parts[0];
		}
		elseif($tipo_formato == 11){
			return $meses[$fecha-1];
		}
	}

	/**
	 * hora
	 *
	 * Tipos de formato de fecha:
	 * 	1 = aaaa-mm-dd HH:MM:SS -> 08:30AM ó HH:MM:SS -> 08:30AM
	 * @return string
	 * @author Julián Camilo Marín Sánchez
	 */
	public function hora($tipo_formato, $fecha) {
		if(!$fecha || $fecha == NULL || $fecha == "00/00/0000" || $fecha == "0000-00-00"){
			return "";
		}
		switch ($tipo_formato) {
    		case "1":
    			$date = date_create($fecha);
    			return date_format($date, 'G:iA');
    			break;
				case "2":
    			$date = date_create($fecha);
    			return date_format($date, 'd/m/Y G:iA');
    			break;
    		default:
    			return "";
    	}
	}

	public function hora2($tipo_formato, $fecha) {
		if(!$fecha || $fecha == NULL || $fecha == "00/00/0000" || $fecha == "0000-00-00"){
			return "";
		}
		switch ($tipo_formato) {
    		case "1":
				$horaConver = "";
				$arrfecha   = explode(":",$fecha);
				$hora       = $arrfecha[0];
				switch ($hora) {
					case "01":
						$horaConver = "13";
					break;
					case "02":
						$horaConver = "14";
					break;
					case "03":
						$horaConver = "15";
					break;
					case "04":
						$horaConver = "16";
					break;
					case "05":
						$horaConver = "17";
					break;
					case "06":
						$horaConver = "18";
					break;
					default:
						$horaConver = $hora;
				}
				$fecha = $horaConver.":".$arrfecha[1].":".$arrfecha[2];

    			$date = date_create($fecha);
    			return date_format($date, 'G:iA');
    			break;
				case "2":
    			$date = date_create($fecha);
    			return date_format($date, 'd/m/Y G:iA');
    			break;
    		default:
    			return "";
    	}
	}

	public function mes($tipo_formato, $mes) {
		if(!$mes || $mes == NULL || $mes == "0" || $mes == "-1"){
			return "";
		}
		switch ($mes) {
			case "1":
				return "Enero";
			break;
			case "2":
				return "Febrero";
			break;
			case "3":
				return "Marzo";
			break;
			case "4":
				return "Abril";
			break;
			case "5":
				return "Mayo";
			break;
			case "6":
				return "Junio";
			break;
			case "7":
				return "Julio";
			break;
			case "8":
				return "Septiembre";
			break;
			case "9":
				return "Octubre";
			break;
			case "10":
				return "Noviembre";
			break;
			case "11":
				return "Noviembre";
			break;
			case "12":
				return "Diciembre";
			break;
			default:
    			return "";
		}
	}

	/**
	 * array_fechas
	 *
	 * @return string
	 * @author Julián Camilo Marín Sánchez
	 */
	public function array_fechas($tipo_formato, $fechas) {
		$nuevas_fechas = array();
		foreach($fechas as $row){
			$nuevas_fechas[] = $this->fecha($tipo_formato, $row);
		}
		return $nuevas_fechas;
	}

	/**
	 * array_fechas
	 *
	 * @return string
	 * @author Julián Camilo Marín Sánchez
	 */
	public function array_porcentaje($porcentaje) {
		$nuevas_porcentaje = array();
		foreach($porcentaje as $row){
			$nuevo_porcentaje[] = $row / 100;
		}
		return $nuevo_porcentaje;
	}


	/**
	 * multipleupdate
	 * @param $tabla String
	 * @param $elementos Array of Arrays
	 * @param $id_columna
	 *
	 * El array $elementos debe de tener el siguiente formato:
	 * $elementos = array ("id_columna" => array (id1, id2, id3...), "nombre_col2" => array(elemento1, elemento2, elemento3...));
	 * NOTA: El primer campo debe de ser el id de la tabla el resto pueden ser arrays o valores individuales
	 * @return string
	 * Produce un string similar a este:
	 * UPDATE categories SET
	 *	    	display_order = CASE id
	 *    	WHEN 1 THEN 32
	 *    	WHEN 2 THEN 33
	 *    	WHEN 3 THEN 34
	 *    	END,
	 *    	title = CASE id
	 *    	WHEN 1 THEN 'New Title 1'
	 *    	WHEN 2 THEN 'New Title 2'
	 *    	WHEN 3 THEN 'New Title 3'
	 *    	END
	 *    	WHERE id IN (1,2,3)
	 * @author Julián Camilo Marín Sánchez
	 */

	public function multipleupdate($tabla, $elementos, $id_columna){
		$sql = "";
		$sql .= "UPDATE $tabla SET ";
		for($i = 1; $i < count($elementos); $i++){
			$sql .= array_keys($elementos)[$i] . " = CASE " . $id_columna;
			$j = 0;
			if(is_array($elementos[array_keys($elementos)[$i]])){
				foreach($elementos[array_keys($elementos)[$i]] as $row){
					$sql .= " WHEN " . $elementos[array_keys($elementos)[0]][$j] . " THEN '" . $row . "'";
					$j++;
				}
			} else {
				foreach($elementos[array_keys($elementos)[0]] as $row){
					$sql .= " WHEN " . $row . " THEN '" . $elementos[array_keys($elementos)[$i]] . "'";
				}
			}
			$sql .= " END, ";
		}
		//Eliminamos la última coma
		$sql = substr($sql, 0, -2);
		$sql .= " WHERE " . $id_columna . " IN (" . implode(',', $elementos[array_keys($elementos)[0]]) . ")";
		return $sql;
	}

	/**
	 * multipleinsert
	 * @param $tabla String
	 * @param $elementos Array in Array
	 *
	 * @return string
	 * NOTA: El primer elemento debe de ser Array
	 * Produce un string similar a este:
	 * 	INSERT INTO example
	 *  (example_id, name, value, other_value)
	 *  VALUES
	 *	  (100, 'Name 1', 'Value 1', 'Other 1'),
	 *	  (101, 'Name 2', 'Value 2', 'Other 2'),
	 *	  (102, 'Name 3', 'Value 3', 'Other 3'),
	 *	  (103, 'Name 4', 'Value 4', 'Other 4');
	 * @author Julián Camilo Marín Sánchez
	 */

	public function multipleinsert($tabla, $elementos){
		$sql = "REPLACE INTO $tabla (".implode(",", array_keys($elementos)).") VALUES ";
		$i = 0;
		foreach($elementos[array_keys($elementos)[0]] as $row){
			$array = array();
			foreach(array_keys($elementos) as $row){
				if(is_array($elementos[$row])){
					$array[] = "'".$elementos[$row][$i]."'";
				} else {
					$array[] = "'".$elementos[$row]."'";
				}

			}
			$sql .= "(".implode(",", $array)."),";
			$i++;
		}
		return substr($sql, 0, -1);
	}

	/**
	 * multipledelete
	 * @param $tabla String
	 * @param id_columna String
	 * @param $elementos Array
	 *
	 * El parámetro $elementoso debe de enviarse en string separado por comas
	 * @return string
	 * @author Julián Camilo Marín Sánchez
	 */

	public function multipledelete($tabla, $id_columna, $elementos){
		return "DELETE FROM $tabla WHERE $id_columna IN (" . $elementos . ")";
	}

	/**
	 * get_client_ip
	 *
	 * Retorna la direcicón IP del cliente
	 * @return string
	 * @author Julián Camilo Marín Sánchez
	 */

	public function get_client_ip() {
		$ipaddress = '';
		if ($_SERVER['HTTP_CLIENT_IP'])
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if($_SERVER['HTTP_X_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if($_SERVER['HTTP_X_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if($_SERVER['HTTP_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if($_SERVER['HTTP_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if($_SERVER['REMOTE_ADDR'])
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
}
