<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveDuplicateFullDatabaseEntry extends Migration
{
    public function up()
    {
        // Remove the duplicate, non-applied migration entry with version 2025-12-12-000001
        $this->db->table('migrations')->where('version', '2025-12-12-000001')->delete();
    }

    public function down()
    {
        // No-op: we don't want to reinsert obsolete migration rows.
    }
}
