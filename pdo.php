

<?php 
# Conectamos a la base de datos
$host='localhost';
$dbname='test';
$user='root';
$pass='secret';

try {

  $conexion = new PDO("mysql:host=$host;dbname=$dbname;port=3306;charset=utf8", $user, $pass);

  # Para que genere excepciones a la hora de reportar errores.
  $conexion->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}

catch(PDOException $e) {
    echo "Se ha producido un error al intentar conectar al servidor MySQL: ".$e->getMessage();
    // die();   ante una excepción, se lance un mensaje y se interrumpa la ejecución.

}
 
	$matriz = array(); // En esta matriz almacenaremos los resultados.
	
	/* Se defina la consulta SQL */
	$consulta = "SELECT * FROM nombre "; //TABLA
	$consulta .= "WHERE agente = 'perez';"; //CAMPO
	
	/* Cada elemento que sea recuperado de la tabla, se almacena en la matriz. */
	foreach ($conexion->query($consulta) as $item) $matriz[] = $item;
	
	/* Se vuelca la matriz en pantalla. */
	echo "<pre>";
	var_dump($matriz);


/*
 Al haber puesto PDO::FETCH_ASSOC hemos indicado que deseamos los resultados cómo una matriz asociativa, y eso es lo que ves en el resultado. Aunque la matriz de contactos es indexada,
porque cada contacto es independiente y no tienen una clave asociativa específica, dentro de cada contacto tenemos los datos con claves asociativas que se corresponde, cómo ves, con los nombres de las columnas en la tabla. 

PDO::FETCH_NUM, los datos de cada contacto aparecerían con una clave indexada.
PDO::FETCH_BOTH (o no ponemos nada, ya que este es el valor por defecto), en cada contacto los datos aparecerán duplicados, con clave asociativa e indexada.
*/


	/* Se define la consulta SQL */
	$consulta = "INSERT INTO nombre (";
	$consulta .= "agente, puesto";
	$consulta .= ") VALUES (";
	$consulta .= "'perez', 'profe');";
	/* Se efectúa la consulta. */
	$conexion->query($consulta);


//En el caso de las consultas que NO devuelven resultados (INSERT, UPDATE o DELETE), 
//se puede emplear el método exec(), en lugar
//de query()


?>


