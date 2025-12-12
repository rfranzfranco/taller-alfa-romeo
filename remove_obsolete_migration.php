<?php
// Simple helper to remove obsolete migration entry for CreateFullDatabase_Obsoleta
define('ENVIRONMENT', 'development');

require __DIR__ . '/vendor/autoload.php';

// Bootstrap CodeIgniter
require __DIR__ . '/app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '/\\') . '/bootstrap.php';

$db = \Config\Database::connect();
$db->table('migrations')->where('class', 'App\\Database\\Migrations\\CreateFullDatabase_Obsoleta')->delete();

echo "Deleted obsolete migration entry if existed." . PHP_EOL;
