<?php
header("Access-Control-Allow-Origin: *");
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM mensajes WHERE id_mensaje = ?");
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $response = array("success" => true, "data" => array("mensajes" => $result));
    header('Content-Type: application/json');
    echo json_encode($response);
  } else {
$stmt = $pdo->query("SELECT * FROM mensajes");
$mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($mensajes as &$mensaje) {
    $id_mensaje = $mensaje['id_mensaje'];
    $stmt = $pdo->prepare("SELECT * FROM respuestas WHERE id_respuesta = :id_mensaje");
    $stmt->bindParam(':id_mensaje', $id_mensaje);
    $stmt->execute();
    $respuestas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $mensaje['respuestas'] = $respuestas;
}

$response = array("success" => true, "data" => array("mensajes" => $mensajes));
header('Content-Type: application/json');
echo json_encode($response);

  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtener los datos enviados en la solicitud POST
  $data = json_decode(file_get_contents("php://input"), true);

  // Verificar que los datos requeridos estén presentes
  if (isset($data['autor_mensaje']) && isset($data['contenido_mensaje'])) {
    // Preparar la consulta SQL para insertar un nuevo país
    $stmt = $pdo->prepare("INSERT INTO mensajes (autor_mensaje, contenido_mensaje) VALUES (?, ?)");

    // Asignar los valores de los parámetros de la consulta
    $autor_mensaje = $data['autor_mensaje'];
    $contenido_mensaje = $data['contenido_mensaje'];


    // Ejecutar la consulta con los valores proporcionados
    $stmt->execute([$autor_mensaje, $contenido_mensaje]);

    // Devolver una respuesta de éxito
    header('Content-Type: application/json');
    // Permitir el encabezado 'Content-Type' en la respuesta
    header('Access-Control-Allow-Headers: Content-Type');
    echo json_encode(['message' => 'Datos guardados correctamente']);
  } else {
    // Devolver una respuesta de error si faltan datos requeridos
    header('Content-Type: application/json');
    // Permitir el encabezado 'Content-Type' en la respuesta
    header('Access-Control-Allow-Headers: Content-Type');
    echo json_encode(['error' => 'Faltan datos necesarios']);
  }
}

