<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class FixDb extends Controller
{
    public function index()
    {
        $db = Database::connect();

        echo "<h1>Fixing DB...</h1>";

        // 1. Modify Column
        try {
            $sql = "ALTER TABLE ordenes_trabajo MODIFY COLUMN estado VARCHAR(50) DEFAULT 'PENDIENTE'";
            $db->query($sql);
            echo "<p>Column modified to VARCHAR(50).</p>";
        } catch (\Exception $e) {
            echo "<p style='color:red'>Error modifying column: " . $e->getMessage() . "</p>";
        }

        // 2. Update Data
        try {
            $sql = "UPDATE ordenes_trabajo SET estado = 'EN_PROCESO' WHERE estado = '' OR estado IS NULL";
            $db->query($sql);
            echo "<p>Rows updated: " . $db->affectedRows() . "</p>";
        } catch (\Exception $e) {
            echo "<p style='color:red'>Error updating data: " . $e->getMessage() . "</p>";
        }

        // 3. Show Data
        $query = $db->query("SELECT * FROM ordenes_trabajo");
        $results = $query->getResultArray();

        echo "<pre>";
        print_r($results);
        echo "</pre>";
    }
}
