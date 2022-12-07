<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        // $this->forge->addField([
        //     'id' => [
        //         'type' => 'INT',
        //         'auto_increment' => true
        //     ],
        //     'name' => [
        //         'type' => 'varchar',
        //         'constraint' => '50'
        //     ],
        //     'email' => [
        //         'type' => 'varchar',
        //         'constraint' => '50'
        //     ],
        //     'password' => [
        //         'type' => 'varchar',
        //         'constraint' => '255'
        //     ],
        //     'created_at datetime default current_timestamp',
        //     'created_at datetime default current_timestamp on update current_timestamp'
        // ]);
        // $this->forge->addPrimaryKey('id');
        // $this->forge->createTable('users')
    }

    public function down()
    {
        // $this->forge->dropTable('users');
    }
}
