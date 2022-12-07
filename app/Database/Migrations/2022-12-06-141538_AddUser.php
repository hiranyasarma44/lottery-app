<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Exception;

class AddUser extends Migration
{
    public function up()
    {
        echo 'ok';
       try{
        $this->forge->addField([
            'blog_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'blog_title' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'blog_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('blog_id', true);
        $this->forge->createTable('blog');
       }catch(Exception $e){
            var_dump($e);
       }
    }

    public function down()
    {
        $this->forge->dropTable('blog');
    }
}
