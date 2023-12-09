<?php
include $_SERVER['DOCUMENT_ROOT'] . "/config/connection_database.php";

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $id = $_GET['id'];

    $sql = "DELETE FROM categories WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    http_response_code(200);
    echo json_encode(['message' => 'Item deleted successfully']);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}
