<?php
require_once __DIR__ . '/../vendor/autoload.php';

try {
    $connectionString = "mongodb+srv://vaishnavratheesh2026:mayaratheesh@cluster0.p06gw.mongodb.net/shoe_store?retryWrites=true&w=majority&appName=Cluster0";
    
    $client = new MongoDB\Client($connectionString);
    $database = $client->shoe_store;
    $collection = $database->shoes;
} catch (Exception $e) {
    die("Error connecting to MongoDB: " . $e->getMessage());
}
?> 