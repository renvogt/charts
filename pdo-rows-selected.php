

<?php 
# Conectamos a la base de datos
$host='localhost';
$dbname='test';
$user='root';
$pass='secret';

try {

  $db= new PDO("mysql:host=$host;dbname=$dbname;port=3306;charset=utf8", $user, $pass);

  # Para que genere excepciones a la hora de reportar errores.
  $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}

catch(PDOException $e) {
    echo "Se ha producido un error al intentar conectar al servidor MySQL: ".$e->getMessage();
    // die();   ante una excepción, se lance un mensaje y se interrumpa la ejecución.

}
 
$stmt = $db->query('SELECT * FROM nombre');
$row_count = $stmt->rowCount();
echo $row_count.' rows selected';


$id=1;
$sentencia = $db->prepare("SELECT * FROM nombre where id = ?");

  while ($fila = $sentencia->fetch()) {
    echo $fila;
  
}


	
	?>