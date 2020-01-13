<?php

use Illuminate\Database\Schema\Blueprint;
use Src\Core\Database\Migration\Migration;

class UsersTableMigration extends Migration
{
    public function up()
    {
        $this->schema->create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique()->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password');
            $table->string('hash')->nullable();
            $table->boolean('is_admin')->default(false);
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('users');
    }
}
