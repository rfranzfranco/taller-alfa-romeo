<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveObsoleteMigration extends Migration
{
    public function up()
    {
        $this->db->table('migrations')
            ->where('class', 'App\\Database\\Migrations\\CreateFullDatabase_Obsoleta')
            ->delete();
    }

    public function down()
    {
        // No action on down; we don't want to reinsert obsolete entries.
    }
}
