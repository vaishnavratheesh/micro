<?php
require_once 'config/database.php';

try {
    // Check if admin already exists
    $admin = $client->shoe_store->users->findOne(['email' => 'admin@gmail.com']);
    
    if (!$admin) {
        // Create admin user
        $result = $client->shoe_store->users->insertOne([
            'username' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'admin',
            'created_at' => time()
        ]);
        echo "Admin user created successfully!";
    } else {
        echo "Admin user already exists!";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 