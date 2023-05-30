<?php
header("Access-Control-Allow-Origin: *");
require 'conexion.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtener los datos enviados en la solicitud POST
  $data = json_decode(file_get_contents("php://input"), true);

  // Verificar que los datos requeridos estén presentes
  if (isset($data['autor_mensaje']) && isset($data['contenido_mensaje']) && isset($data['id_respuesta'])) {
    // Preparar la consulta SQL para insertar un nuevo país
    $stmt = $pdo->prepare("INSERT INTO respuestas (autor_mensaje, contenido_mensaje, id_respuesta) VALUES (?, ?, ?)");

    // Asignar los valores de los parámetros de la consulta
    $autor_mensaje = $data['autor_mensaje'];
    $contenido_mensaje = $data['contenido_mensaje'];
	$id_respuesta = $data['id_respuesta'];


    // Ejecutar la consulta con los valores proporcionados
    $stmt->execute([$autor_mensaje, $contenido_mensaje, $id_respuesta]);

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

