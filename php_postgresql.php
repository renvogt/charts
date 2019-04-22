https://informaticapc.com/tutorial-php/bases-de-datos-postgresql.php
https://www.php.net/manual/es/pgsql.examples-basic.php

<?php
	
	// Con esta línea mostramos los posibles errores:
	ini_set("display_errors", "on");

	// ----------------------------------------------

	function conectar_PostgreSQL( $usuario, $pass, $host, $bd )
	{
		$conexion = pg_connect( "user=".$usuario." ".
				  		   "password=".$pass." ".
						   "host=".$host." ".
						   "dbname=".$bd
						  ) or die( "Error al conectar: ".pg_last_error() );

		return $conexion;
	}

	// ----------------------------------------------

	function borrarPersona( $conexion, $id )
	{
		$sql = "DELETE FROM tbl_personas";

		// Si 'id' es diferente de 'null' sólo se borra la persona con el 'id' especificado:
		if( $id != null )
			$sql .= " WHERE id=".$id;

		// Ejecutamos la consulta (se devolverá true o false):
		return pg_query( $conexion, $sql );
	}

	// ----------------------------------------------

	function insertarPersona( $conexion, $id, $nombre )
	{
		$sql = "INSERT INTO tbl_personas VALUES (".$id.", '".$nombre."')";

		// Ejecutamos la consulta (se devolverá true o false):
		return pg_query( $conexion, $sql );
	}

	// ----------------------------------------------

	function modificarPersona( $conexion, $id, $nombre )
	{
		$sql = "UPDATE tbl_personas SET nombre='".$nombre."' WHERE id=".$id;

		// Ejecutamos la consulta (se devolverá true o false):
		return pg_query( $conexion, $sql );
	}

	// ----------------------------------------------

	function listarPersonas( $conexion )
	{
		$sql = "SELECT * FROM tbl_personas ORDER BY id";
		$ok = true;

		// Ejecutar la consulta:
		$rs = pg_query( $conexion, $sql );

		if( $rs )
		{
			// Obtener el número de filas:
			if( pg_num_rows($rs) > 0 )
			{
				echo "<p/>LISTADO DE PERSONAS<br/>";
				echo "===================<p />";

				// Recorrer el resource y mostrar los datos:
				while( $objFila = pg_fetch_object($rs) )
					echo $objFila->id." - ".$objFila->nombre."<br />";
			}
			else
				echo "No se encontraron personas<br />";
		}
		else
			$ok = false;

		return $ok;
	}

	// ----------------------------------------------

	function buscarPersona( $conexion, $id )
	{
		$sql = "SELECT * FROM tbl_personas WHERE id=".$id."";
		$devolver = null;

		// Ejecutar la consulta:
		$rs = pg_query( $conexion, $sql );

		if( $rs )
		{
			// Si se encontró el registro, se obtiene un objeto en PHP con los datos de los campos:
			if( pg_num_rows($rs) > 0 )
				$devolver = pg_fetch_object( $rs, 0 );
		}

		return $devolver;
	}

	// ----------------------------------------------

	// Conectar (se detendrá la ejecución si se produce un error) - * RELLENA LOS DATOS QUE FALTAN *:
	$conexion = conectar_PostgreSQL( "TU_USUARIO", "TU_PASSWORD", "IP_DEL_SERVIDOR", "NOMBRE_DE_LA_BASE_DE_DATOS" );

	// Borrar todos los datos de la tabla:
	$ok = borrarPersona( $conexion, null );

	if( $ok == false )
		echo "Error al borrar los datos.<br/>";
	else
		echo "Datos borrados correctamente.<br/>";

	// insertar una persona:
	$ok = insertarPersona( $conexion, 1, 'Juan Rodríguez P.' );

	if( $ok == false )
		echo "Error al insertar los datos.<br/>";
	else
		echo "Datos insertados correctamente.<br/>";

	// insertar una persona:
	$ok = insertarPersona( $conexion, 2, 'Juan Rodríguez P.' );

	// insertar una persona:
	$ok = insertarPersona( $conexion, 3, 'Roberta Amador H.' );

	// Modificar la persona número 2:
	$ok = modificarPersona( $conexion, 1, "Alfredo Ramírez E." );

	if( $ok == false )
		echo "Error al modificar los datos.<br/>";
	else
		echo "Datos modificados correctamente.<br/>";

	// Modificar la persona:
	$ok = listarPersonas( $conexion );

	if( $ok == false )
		echo "<p>Error al listar los datos.</p>";
	else
		echo "<p>Datos listados correctamente.</p>";

	$objPersona = buscarPersona( $conexion, 2 );

	if( $objPersona == null )
		echo "No se encontró la persona";
	else
		echo "El nombre de la persona con el código: [".$objPersona->id."] es [".$objPersona->nombre."]";

?>