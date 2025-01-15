<?php
header("Content-Type: application/json");
$pdo = new PDO("mysql:host=localhost;dbname=chefmanagement", "root", "");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $stmt = $pdo->query("SELECT * FROM chefs");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

if ($method == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO chefs (descripcion, nombres, genero) VALUES (?, ?, ?)");
    $stmt->execute([$data['descripcion'], $data['nombres'], $data['genero']]);
    echo json_encode(["id" => $pdo->lastInsertId()]);
}

if ($method == 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true); // Decodificar JSON recibido
    if (isset($data['id'])) {
        $stmt = $pdo->prepare("DELETE FROM chefs WHERE id = ?");
        $stmt->execute([$data['id']]);
        echo json_encode(["message" => "Chef eliminado"]);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "ID no proporcionado"]);
    }
}

if ($method == 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true); // Decodificar JSON recibido
    if (isset($data['id'], $data['descripcion'], $data['nombres'], $data['genero'])) {
        $stmt = $pdo->prepare("UPDATE chefs SET descripcion = ?, nombres = ?, genero = ? WHERE id = ?");
        $stmt->execute([$data['descripcion'], $data['nombres'], $data['genero'], $data['id']]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode(["message" => "Usuario actualizado"]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Usuario no encontrado o sin cambios"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Datos incompletos"]);
    }
}


