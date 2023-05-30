<?php
// conexion a la bd  remota para la recogida de datos de la api
$servidor_db = "XXXXXXXXXXXXXXXX";
$nombre_db = "XXXXXXXXXXXXXXXX";
$usuario_db = "XXXXXXXXXXXXXXXX";
$pass_db = "XXXXXXXXXXXXXXXX";
$link = "mysql:host=$servidor_db;dbname=$nombre_db";
try {
    $pdo = new PDO($link, $usuario_db, $pass_db);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}


?>
