<?php

use Illuminate\Database\Schema\Blueprint;
use Src\Core\Database\Eloquent\Eloquent;

class UsersTableMigration extends Eloquent
{
    public function up()
    {
        $this->schema->create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique()->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password');
            $table->string('auth_token')->nullable();
            $table->boolean('is_admin')->default(false);
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('users');
    }
}
