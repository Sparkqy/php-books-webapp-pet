<?php

use Illuminate\Database\Schema\Blueprint;
use Src\Core\Database\Migration\Migration;

class TagsTableMigration extends Migration
{
    public function up()
    {
        $this->schema->create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('tags');
    }
}
