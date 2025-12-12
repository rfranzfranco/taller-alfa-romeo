<?php

// Load CodeIgniter
require 'app/Config/Paths.php';
$paths = new Config\Paths();
define('ENVIRONMENT', 'development');
require 'system/bootstrap.php';

use Config\Database;

$db = Database::connect();

echo "Dropping table detalle_insumos_orden...\n";
$db->query("DROP TABLE IF EXISTS detalle_insumos_orden");
echo "Table dropped.\n";
