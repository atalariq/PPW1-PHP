<?php
require __DIR__ . '/shared/db.php';

try {
    $pdo = getDB();
    echo "Connected to PostgreSQL!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
