<?php
$dbPath = __DIR__ . '/database/wallet.db';
$dbDir = dirname($dbPath);

// Create database directory if it doesn't exist
if (!file_exists($dbDir)) {
    mkdir($dbDir, 0777, true);
}

try {
    $db = new SQLite3($dbPath);
    
    // Create transactions table
    $db->exec('
        CREATE TABLE IF NOT EXISTS transactions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            amount DECIMAL(10,2) NOT NULL,
            description TEXT NOT NULL,
            category TEXT NOT NULL,
            transaction_date DATE NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ');

    echo "Database initialized successfully!\n";
} catch (Exception $e) {
    echo "Error initializing database: " . $e->getMessage() . "\n";
    exit(1);
}
