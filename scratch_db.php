<?php

require 'app/Config/Constants.php';
require 'vendor/autoload.php';

$db = \Config\Database::connect();
$db->query("CREATE TABLE IF NOT EXISTS activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    action VARCHAR(255),
    description TEXT,
    ip_address VARCHAR(45),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

echo "Activity logs table created successfully.\n";
